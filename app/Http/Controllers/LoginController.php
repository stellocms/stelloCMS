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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect to intended URL, fallback to dashboard
            return redirect()->intended('/panel/dashboard');
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
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