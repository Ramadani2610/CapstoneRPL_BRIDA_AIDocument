<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Base class for every API controller.
 *
 * Holds a single helper for now: `todo()`, which answers 501 Not Implemented with
 * a clear message. Skeleton endpoints use it as a placeholder.
 */
abstract class ApiController extends Controller
{
    protected function todo(string $method): JsonResponse
    {
        return response()->json([
            'message' => 'Endpoint belum diimplementasikan.',
            'handler' => $method,
            'petunjuk' => 'Isi method ini sesuai kontrak di docblock, lalu hapus panggilan todo().',
        ], 501);
    }
}
