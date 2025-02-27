<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}


