<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Correct namespace

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        Log::info('RoleMiddleware triggered. User Role: ' . (Auth::user()->role ?? 'none'));

        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        Log::warning('Unauthorized access attempt by user: ' . (Auth::id() ?? 'guest'));
        return redirect()->route('students.index')->with('error', 'Unauthorized access.');
    }
}


