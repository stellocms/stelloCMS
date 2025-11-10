<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LoginThrottleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya terapkan pada route login
        if ($request->is('panel*') && $request->method() === 'POST') {
            $maxAttempts = 5;
            $decayMinutes = 60; // 60 menit
            
            $key = 'login_attempts_' . $request->ip();
            $attempts = Cache::get($key, 0);
            
            if ($attempts >= $maxAttempts) {
                $timeLeft = Cache::ttl($key);
                $hours = floor($timeLeft / 3600);
                $minutes = floor(($timeLeft % 3600) / 60);
                
                return response()->json([
                    'error' => true,
                    'message' => "Terlalu banyak percobaan login. Silakan coba lagi dalam $hours jam $minutes menit."
                ], 429);
            }
        }
        
        return $next($request);
    }
}