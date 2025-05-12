<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // Check if the user is authenticated
        if (Auth::check() && Auth::user()->role === $role) {
            // Allow access to the route
            return $next($request);
        }

        // Redirect to login if not authorized
        return redirect()->route('login');
    }
}

