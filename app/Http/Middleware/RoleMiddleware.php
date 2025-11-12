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
        \Log::info('RoleMiddleware accessed for route: ' . ($request->route()->getName() ?? 'unknown'));
        
        if (!auth()->check()) {
            \Log::info('User not authenticated, redirecting to /panel');
            return redirect('/panel');
        }

        $user = auth()->user();
        $userRole = strtolower($user->role->name);
        
        \Log::info('User role: ' . $userRole);
        
        // Admin has access to everything - this should be checked before any other validation
        // Check for various admin role names
        if (in_array($userRole, ['admin', 'administrator', 'adminstrator'])) {
            \Log::info('User is admin, allowing access');
            return $next($request);
        }
        
        // If no roles specified in middleware, allow access
        if (empty($roles)) {
            \Log::info('No roles specified in middleware, allowing access');
            return $next($request);
        }

        // Check if user role is in the allowed roles from middleware
        if (in_array($userRole, array_map('strtolower', $roles))) {
            \Log::info('User role is in middleware roles, allowing access');
            return $next($request);
        }
        
        // If user role is not in middleware roles, check the menus table for additional permissions
        $currentRoute = $request->route()->getName();
        \Log::info('Checking menu for route: ' . $currentRoute);
        
        // Find corresponding menu entry
        $menu = \App\Models\Menu::where('route', $currentRoute)->first();
        
        if ($menu) {
            $allowedRolesFromMenu = json_decode($menu->roles, true) ?: [];
            \Log::info('Menu found for route, roles: ' . json_encode($allowedRolesFromMenu));
            
            // If menu entry exists and user role is in allowed roles from menu, allow access
            if (in_array($userRole, array_map('strtolower', $allowedRolesFromMenu))) {
                \Log::info('User role is in menu roles, allowing access');
                return $next($request);
            } else {
                \Log::info('User role not in menu roles');
            }
        } else {
            \Log::info('No menu found for route: ' . $currentRoute);
            // If menu doesn't exist for this route, check if it's a plugin route
            // Plugin routes typically follow pattern like 'panel.{plugin_name}.{action}' or 'panel.{plugin_name}'
            if (preg_match('/^panel\.[a-zA-Z]+(\.[a-zA-Z]+|)$/', $currentRoute)) {
                \Log::info('Route matches plugin pattern: ' . $currentRoute);
                // This is likely a plugin route, and if user is admin-like, allow access
                if (in_array($userRole, ['admin', 'administrator', 'adminstrator'])) {
                    \Log::info('User is admin accessing plugin route, allowing access');
                    return $next($request);
                } else {
                    \Log::info('User is not admin, denying access to plugin route');
                }
            } else {
                \Log::info('Route does not match plugin pattern');
            }
        }
        
        \Log::info('Access denied, aborting with 403');
        abort(403, 'Akses ditolak.');
    }
}