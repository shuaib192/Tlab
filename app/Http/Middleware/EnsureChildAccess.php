<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureChildAccess
{
    public function handle(Request $request, Closure $next)
    {
        $childId = session('active_child_id');

        if (!$childId) {
            return redirect()->route('child.login')
                ->with('info', 'Please log in to continue.');
        }

        return $next($request);
    }
}
