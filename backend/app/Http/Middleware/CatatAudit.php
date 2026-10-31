<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Writes an audit trail for every request that changes data (POST/PUT/PATCH/DELETE).
 *
 * An audit entry must never fail the main request, so every write is wrapped in
 * try/catch and failures are ignored. Per-field before/after values come later
 * through model observers.
 */
class CatatAudit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)
            && $request->user() !== null) {
            try {
                AuditLog::create([
                    'user_id' => $request->user()->id,
                    'aksi' => strtolower($request->method()),
                    'entitas' => $request->path(),
                    'entitas_id' => null,
                    'ip' => $request->ip(),
                    'dibuat_pada' => now(),
                ]);
            } catch (\Throwable $e) {
                // ignored on purpose: audit must not break the main request
            }
        }

        return $response;
    }
}
