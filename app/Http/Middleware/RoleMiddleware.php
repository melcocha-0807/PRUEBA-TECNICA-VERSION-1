<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        $validRoles = ['usuario', 'vendedor', 'auxiliar de bodega'];
        $userRole = trim(mb_strtolower($user->rol ?? ''));
        $requiredRole = trim(mb_strtolower($role));
        if (!$user || !in_array($userRole, $validRoles) || $userRole !== $requiredRole) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
        return $next($request);
    }
}
