<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureTwoFactor
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user || $user->isSuspended()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'This account is suspended. Contact TLab support.');
        }

        if ($user->requiresTwoFactor()) {
            $verifiedUserId = $request->session()->get('two_factor_verified_user');

            if ($verifiedUserId !== $user->id) {
                return redirect()->route('two-factor.challenge');
            }
        }

        return $next($request);
    }
}