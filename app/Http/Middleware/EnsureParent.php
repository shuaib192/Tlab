<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureParent
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isParent()) {
            return redirect()->route('login')->with('error', 'You must be logged in as a parent to access this page.');
        }

        if (auth()->user()->isSuspended()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'This account is suspended. Contact TLab support.');
        }

        return $next($request);
    }
}
