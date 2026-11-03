<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\PredicateThreshold;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Indicator master data for every logged-in role (used by the innovator form).
 */
class IndicatorPublicController extends Controller
{
    /**
     * GET /api/indikators — requires login (all roles).
     *
     * In-scope indicators plus their tiers for the current year.
     * Query: ?tahun= (optional, defaults to the current year)
     */
    public function index(Request $request): JsonResponse
    {
        $tahun = (int) $request->query('tahun', now()->year);

        $indikators = Indicator::dalamScope()
            ->orderBy('kode')
            ->with(['tiers' => fn ($q) => $q->where('tahun', $tahun)->orderByDesc('bintang')])
            ->get()
            ->map(fn (Indicator $i) => [
                'kode' => $i->kode,
                'nama' => $i->nama,
                'deskripsi' => $i->deskripsi,
                'bobot' => $i->bobot,
                'wajib' => $i->wajib,
                'tipe_bukti' => $i->tipe_bukti,
                'rentang_tahun' => $i->rentang_tahun,
                'tiers' => $i->tiers->map(fn ($t) => [
                    'id' => $t->id,
                    'bintang' => $t->bintang,
                    'label' => $t->label,
                    'deskripsi_bukti' => $t->deskripsi_bukti,
                    'konfigurasi' => $t->konfigurasi,
                ]),
            ]);

        return response()->json(['tahun' => $tahun, 'data' => $indikators]);
    }

    /**
     * GET /api/predikat — requires login (all roles).
     *
     * Predicate thresholds for the current year. Query: ?tahun= (optional)
     */
    public function predikat(Request $request): JsonResponse
    {
        $tahun = (int) $request->query('tahun', now()->year);

        $data = PredicateThreshold::where('tahun', $tahun)
            ->orderBy('skor_min')
            ->get(['nama_predikat', 'skor_min', 'skor_max']);

        return response()->json(['tahun' => $tahun, 'data' => $data]);
    }
}
