<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureLiveAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            return $next($request);
        }

        if (session('active_child_id')) {
            return $next($request);
        }

        return redirect()->route('login')
            ->with('info', 'Please sign in to join the live classroom.');
    }
}
