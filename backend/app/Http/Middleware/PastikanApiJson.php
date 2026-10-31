<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Forces /api/* requests to always ask for JSON responses.
 *
 * Without this, Laravel may answer with an HTML error page when the request
 * carries no Accept: application/json header, and the frontend cannot parse it.
 */
class PastikanApiJson
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*')) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
