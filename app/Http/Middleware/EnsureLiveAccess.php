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

        abort(403, 'You must be signed in to join a live classroom.');
    }
}
