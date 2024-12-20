<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = JWTAuth::user();
        if ($user && !$user->hasRole($role)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        return $next($request);

    }
}