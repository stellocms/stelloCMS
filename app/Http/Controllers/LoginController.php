<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        // Use AdminLTE theme for login page
        return view('theme.admin.adminlte::auth.login');
    }

    public function login(Request $request)
    {
        // Deteksi dan cegah berbagai jenis serangan
        $this->preventAutomatedLogin($request);
        
        // Validasi input untuk mencegah XSS dan karakter berbahaya
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'captcha_input' => ['required', 'integer', 'min:0', 'max:9999'],
            'client_time' => ['nullable', 'integer'],
        ]);

        // Cek apakah user terkena throttling
        $lockoutKey = 'login_lockout_' . $request->ip();
        $attemptsKey = 'login_attempts_' . $request->ip();
        
        if (cache()->has($lockoutKey)) {
            $timeLeft = cache()->ttl($lockoutKey);
            $hours = floor($timeLeft / 3600);
            $minutes = floor(($timeLeft % 3600) / 60);
            
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam $hours jam $minutes menit.",
                ]);
        }

        // Sanitasi input
        $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($request->password, FILTER_SANITIZE_STRING);
        $captchaInput = (int)$request->captcha_input;

        // Validasi captcha
        $captchaResult = session('captcha_result');
        
        if ($captchaResult !== $captchaInput) {
            // Tambahkan jumlah percobaan captcha salah
            $attempts = cache()->get($attemptsKey, 0);
            $attempts++;
            
            if ($attempts >= 5) {
                // Kunci akses selama 60 menit
                cache()->put($lockoutKey, true, 60 * 60); // 60 menit dalam detik
                cache()->forget($attemptsKey);
                
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors([
                        'email' => 'Terlalu banyak percobaan login gagal. Silakan coba lagi setelah 60 menit.',
                    ]);
            } else {
                cache()->put($attemptsKey, $attempts, 60 * 60); // Reset dalam 60 menit
                
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors([
                        'email' => 'Email atau password salah.',
                        'captcha_input' => 'Jawaban captcha salah.',
                    ]);
            }
        }

        // Cek apakah email valid sebelum mencoba login
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Format email tidak valid.',
                ]);
        }

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credentials)) {
            // Reset percobaan jika berhasil login
            cache()->forget($attemptsKey);
            cache()->forget($lockoutKey);
            
            $request->session()->regenerate();

            // Redirect berdasarkan role pengguna
            $user = auth()->user();
            $userRole = strtolower($user->role->name);

            // Jika pengguna adalah admin atau operator, arahkan ke panel
            if (in_array($userRole, ['admin', 'operator'])) {
                return redirect()->intended('/panel/dashboard');
            }

            // Untuk role lainnya, bisa diarahkan ke halaman khusus atau default
            return redirect()->intended('/');
        }

        // Tambahkan jumlah percobaan login salah
        $attempts = cache()->get($attemptsKey, 0);
        $attempts++;
        
        if ($attempts >= 5) {
            // Kunci akses selama 60 menit
            cache()->put($lockoutKey, true, 60 * 60); // 60 menit dalam detik
            cache()->forget($attemptsKey);
            
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Terlalu banyak percobaan login gagal. Silakan coba lagi setelah 60 menit.',
                ]);
        } else {
            cache()->put($attemptsKey, $attempts, 60 * 60); // Reset dalam 60 menit
            
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ]);
        }
    }
    
    /**
     * Mencegah login otomatis dan serangan lainnya
     */
    private function preventAutomatedLogin(Request $request)
    {
        // Cek apakah permintaan berasal dari browser (mencegah permintaan langsung ke API)
        $userAgent = $request->header('User-Agent');
        if (!$userAgent || preg_match('/bot|crawl|spider|slurp|teoma|archive|track/i', $userAgent)) {
            abort(403, 'Akses ditolak');
        }
        
        // Validasi referer (mencegah CSRF dari domain lain)
        $referer = $request->header('Referer');
        $url = $request->url();
        
        if ($referer && !str_starts_with($referer, request()->getSchemeAndHttpHost())) {
            // Jika referer tidak berasal dari domain yang sama, ini bisa jadi serangan CSRF
            \Log::warning('Possible CSRF attempt', [
                'ip' => $request->ip(),
                'user_agent' => $userAgent,
                'referer' => $referer,
                'url' => $url
            ]);
        }
        
        // Cek apakah waktu klien masuk akal (mencegah serangan timing)
        $clientTime = $request->input('client_time');
        if ($clientTime) {
            $timeDiff = abs(time() * 1000 - $clientTime); // Perbedaan waktu dalam milidetik
            // Jika perbedaan lebih dari 5 menit, anggap tidak valid
            if ($timeDiff > 300000) { // 5 menit dalam milidetik
                \Log::warning('Possible timing attack', [
                    'ip' => $request->ip(),
                    'time_diff' => $timeDiff,
                    'client_time' => $clientTime
                ]);
            }
        }
        
        // Cek keberadaan header yang biasanya ada di permintaan browser
        $requiredHeaders = ['Accept', 'Accept-Language', 'User-Agent'];
        $missingHeaders = [];
        
        foreach ($requiredHeaders as $header) {
            if (!$request->header($header)) {
                $missingHeaders[] = $header;
            }
        }
        
        // Jika banyak header penting hilang, mungkin ini permintaan otomatis
        if (count($missingHeaders) > 1) {
            \Log::warning('Request missing required browser headers', [
                'ip' => $request->ip(),
                'missing_headers' => $missingHeaders
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // After logout, redirect to login page instead of panel
        return redirect('/panel');
    }
}