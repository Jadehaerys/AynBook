<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Block unauthenticated users from hitting protected routes.
     * Also enforces a 30-minute idle timeout — if you walk away and come back,
     * you'll need to log in again. Timestamps are stored in the session itself.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Session timeout: 30 minutes of inactivity
        $lastActivity = session('last_activity');
        $timeout      = 30 * 60; // 30 minutes in seconds

        if ($lastActivity && (time() - $lastActivity > $timeout)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        // Refresh last activity timestamp on every request
        session(['last_activity' => time()]);

        return $next($request);
    }
}
