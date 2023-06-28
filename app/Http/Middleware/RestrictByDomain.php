<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Inspired by: https://aquibj0.hashnode.dev/securing-your-laravel-api-restricting-access-to-a-single-application-domain
 */
class RestrictByDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedDomains = config('app.allowed_domains');

        if (empty($allowedDomains)) {
            return $next($request);
        }

        return in_array($request->getHost(), $allowedDomains)
            ? $next($request)
            : response()->json(['message' => 'Unauthorized'], 401);
    }
}
