<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeacher
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isTeacher()) {
            return redirect()->route('login')->with('error', 'You must be logged in as a teacher to access this page.');
        }

        return $next($request);
    }
}
