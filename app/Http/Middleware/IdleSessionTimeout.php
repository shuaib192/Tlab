<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdleSessionTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $timeoutMinutes = (int) config('session.idle_timeout', 30);
            $lastActivity = $request->session()->get('last_activity_at');

            if ($lastActivity && (time() - (int) $lastActivity) > ($timeoutMinutes * 60)) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('info', 'You were signed out after being inactive for a while. Please sign in again.');
            }

            $request->session()->put('last_activity_at', time());
        }

        return $next($request);
    }
}
