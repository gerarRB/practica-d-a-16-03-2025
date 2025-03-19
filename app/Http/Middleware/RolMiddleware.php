<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Middlewares\RoleMiddleware;


class RolMiddleware
{
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Check if the user is logged in
        if (!$user) {
            return response()->json(['error' => 'Unauthorized access. Please log in.'], 401);
        }

        // Check if the user has at least one of the required roles
        if (!$user->hasAnyRole($roles)) {
            return response()->json([
                'error' => 'You do not have the required role(s): ' . implode(', ', $roles)
            ], 403);
        }

        return $next($request);
    }
}
