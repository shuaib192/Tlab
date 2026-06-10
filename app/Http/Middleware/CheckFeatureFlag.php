<?php
namespace App\Http\Middleware;
use Closure;
class CheckFeatureFlag
{
    public function handle($request, Closure $next, $flag)
    {
        if (!\App\Models\FeatureFlag::isEnabled($flag, $request->user())) {
            abort(404);
        }
        return $next($request);
    }
}
