<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAbility
{
    /**
     * Handle an incoming request.
     * Expect an ability string as the third param.
     */
    public function handle(Request $request, Closure $next, ?string $ability = null)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // If no ability specified, allow the request (auth:sanctum should still protect it)
        if (! $ability) {
            return $next($request);
        }

        // Check token ability via Sanctum's tokenCan helper
        if (method_exists($user, 'tokenCan') && $user->tokenCan($ability)) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden - missing required token ability.'], 403);
    }
}
