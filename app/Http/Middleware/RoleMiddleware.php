<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
  
    public function handle($request, Closure $next, $role)
    {
        // Authenticate the user via JWT
        $user = Auth::guard()->user();

        // Check if user is authenticated and has the required role
        if ($user && $user->user_type === $role) {
            return $next($request);
        }

        // If not authenticated or role mismatch
        return response()->json(['error' => 'Unauthorized...'], 403);
    }


}
