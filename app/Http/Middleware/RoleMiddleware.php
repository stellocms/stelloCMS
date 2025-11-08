<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/panel');
        }

        $user = auth()->user();
        $userRole = strtolower($user->role->name);
        
        // Admin has access to everything - this should be checked before any other validation
        // Check for various admin role names
        if (in_array($userRole, ['admin', 'administrator', 'adminstrator'])) {
            return $next($request);
        }
        
        // If no roles specified in middleware, allow access
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user role is in the allowed roles from middleware
        if (in_array($userRole, array_map('strtolower', $roles))) {
            return $next($request);
        }
        
        // If user role is not in middleware roles, check the menus table for additional permissions
        $currentRoute = $request->route()->getName();
        
        // Find corresponding menu entry
        $menu = \App\Models\Menu::where('route', $currentRoute)->first();
        
        if ($menu) {
            $allowedRolesFromMenu = json_decode($menu->roles, true) ?: [];
            
            // If menu entry exists and user role is in allowed roles from menu, allow access
            if (in_array($userRole, array_map('strtolower', $allowedRolesFromMenu))) {
                return $next($request);
            }
        }
        
        abort(403, 'Akses ditolak.');
    }
}