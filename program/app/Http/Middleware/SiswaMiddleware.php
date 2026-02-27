<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SiswaMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'siswa') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }

            // Avoid redirect loop if already on login page
            if (!$request->routeIs('login') && !$request->routeIs('login.post')) {
                return Redirect::route('login');
            }
        }

        return $next($request);
    }
}
