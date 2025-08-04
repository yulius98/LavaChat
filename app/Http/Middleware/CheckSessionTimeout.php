<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated but session is invalid
        if ($request->hasSession()) {
            $lastActivity = $request->session()->get('last_activity');
            $sessionLifetime = config('session.lifetime') * 60; // Convert to seconds
            
            if ($lastActivity && (time() - $lastActivity) > $sessionLifetime) {
                // Session has expired
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Session expired.'], 401);
                }
                
                return redirect()->route('login')
                    ->with('status', 'Your session has expired. Please login again.');
            }
            
            // Update last activity time
            $request->session()->put('last_activity', time());
        }

        return $next($request);
    }
}
