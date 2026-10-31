<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Authorization middleware: checks the `role` column of the logged-in user.
 *
 * Usage in routes: ->middleware('role:admin')
 *                  ->middleware('role:verifikator,admin')
 */
class PastikanRole
{
    public function handle(Request $request, Closure $next, string ...$peran): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => 'Belum terautentikasi. Silakan login terlebih dahulu.',
            ], 401);
        }

        // Admins may open every verifikator page (matching config/navigation.ts in the
        // frontend), but not the other way around. Written once here instead of in routes.
        $peranDiizinkan = $peran;
        if (in_array('verifikator', $peran, true) && ! in_array('admin', $peranDiizinkan, true)) {
            $peranDiizinkan[] = 'admin';
        }

        if (! in_array($user->role, $peranDiizinkan, true)) {
            return response()->json([
                'message' => 'Akses ditolak. Halaman ini hanya untuk: '.implode(', ', $peranDiizinkan).'.',
                'role_anda' => $user->role,
            ], 403);
        }

        return $next($request);
    }
}
