<?php

namespace App\Http\Controllers;

use App\Models\AiAssessment;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/** Verification queue. */
class QueueController extends Controller
{
    /**
     * GET /api/dashboard/verifikator — role: verifikator
     */
    public function dashboard(Request $request): JsonResponse
    {
        return response()->json([
            'menunggu' => Submission::antrian()->count(),
            'diproses' => Submission::where('status', Submission::STATUS_DIPROSES)->count(),
            'selesai_hari_ini' => Submission::where('status', Submission::STATUS_DITERIMA)
                ->whereDate('decided_at', today())
                ->count(),
            'gagal' => DB::table('failed_jobs')->count(),
        ]);
    }

    /**
     * GET /api/queue — role: verifikator.
     *
     * Query: ?tab=menunggu|selesai · ?q= · ?status=
     */
    public function index(Request $request): JsonResponse
    {
        $query = Submission::query()->with('user')->withCount('evidences');

        $tab = $request->query('tab', 'menunggu');
        if ($tab === 'selesai') {
            $query->whereIn('status', [Submission::STATUS_DITERIMA, Submission::STATUS_DITOLAK]);
        } else {
            $query->antrian();
        }

        if ($request->filled('q')) {
            $q = $request->query('q');
            $query->where(fn ($w) => $w->where('judul', 'ilike', "%{$q}%")->orWhere('opd', 'ilike', "%{$q}%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $data = $query->orderBy('submitted_at')->paginate(10)->through(function (Submission $s) {
            $saran = AiAssessment::where('submission_id', $s->id)
                ->orderByDesc('id')->first();

            return [
                'id' => $s->id,
                'kode' => 'INV-'.$s->tahun.'-'.str_pad((string) $s->id, 3, '0', STR_PAD_LEFT),
                'judul' => $s->judul,
                'opd' => $s->opd,
                'diajukan_oleh' => $s->user?->name,
                'tgl_diajukan' => $s->submitted_at?->toISOString(),
                'jumlah_dokumen' => $s->evidences_count,
                'status' => $s->status,
                'saran_ai' => $saran ? [
                    'label' => $saran->ringkasan,
                    'keyakinan' => $saran->keyakinan,
                    'usulan_bintang' => $saran->usulan_bintang,
                ] : null,
            ];
        });

        return response()->json($data);
    }

    /**
     * GET /api/queue/{submission} — role: verifikator
     */
    public function show(Request $request, Submission $submission): JsonResponse
    {
        $submission->load(['user', 'parameters.indicator', 'parameters.tier', 'evidences.indicator', 'decisions.indicator']);

        $assessments = AiAssessment::where('submission_id', $submission->id)
            ->orderByDesc('id')->get();

        $perIndikator = [];
        foreach ($submission->parameters as $p) {
            $kode = $p->indicator?->kode;
            $evs = $submission->evidences->where('indicator_id', $p->indicator_id)->values();

            $perIndikator[] = [
                'indicator_kode' => $kode,
                'indicator_nama' => $p->indicator?->nama,
                'bobot' => $p->indicator?->bobot,
                'wajib' => (bool) $p->indicator?->wajib,
                'bintang_diklaim' => $p->bintang_diklaim,
                'tier_label' => $p->tier?->label,
                'evidences' => $evs->map(fn ($e) => [
                    'id' => $e->id,
                    'nama_asli' => $e->nama_asli,
                    'tipe_file' => $e->tipe_file,
                    'ukuran' => $e->ukuran,
                    'tahun_dokumen' => $e->tahun_dokumen,
                    'status_ocr' => $e->status_ocr,
                    'url' => '/api/evidences/'.$e->id.'/file',
                ]),
                'usulan_ai' => $assessments->where('indicator_id', $p->indicator_id)->map(fn ($a) => [
                    'mesin' => $a->mesin,
                    'usulan_bintang' => $a->usulan_bintang,
                    'keyakinan' => $a->keyakinan,
                    'ringkasan' => $a->ringkasan,
                ])->values(),
                'keputusan' => $submission->decisions->firstWhere('indicator_id', $p->indicator_id)?->only([
                    'bintang_final', 'skor', 'catatan',
                ]),
            ];
        }

        return response()->json([
            'id' => $submission->id,
            'kode' => 'INV-'.$submission->tahun.'-'.str_pad((string) $submission->id, 3, '0', STR_PAD_LEFT),
            'judul' => $submission->judul,
            'deskripsi' => $submission->deskripsi,
            'opd' => $submission->opd,
            'kategori' => $submission->kategori,
            'tahun' => $submission->tahun,
            'status' => $submission->status,
            'diajukan_oleh' => $submission->user?->name,
            'submitted_at' => $submission->submitted_at?->toISOString(),
            'per_indikator' => $perIndikator,
        ]);
    }

    /**
     * GET /api/failed-jobs — role: verifikator
     */
    public function failedJobs(Request $request): JsonResponse
    {
        $jobs = DB::table('failed_jobs')->orderByDesc('failed_at')->limit(50)->get();

        $data = $jobs->map(function ($j) {
            $payload = json_decode($j->payload, true);
            $namaJob = $payload['displayName'] ?? 'Job';

            return [
                'id' => $j->id,
                'job' => class_basename($namaJob),
                'jenis_error' => class_basename(strtok($j->exception, ':')),
                'penjelasan' => strtok(strtok($j->exception, "\n"), ':'),
                'gagal_pada' => $j->failed_at,
                'bisa_retry' => true,
            ];
        });

        return response()->json(['data' => $data]);
    }

    /**
     * POST /api/failed-jobs/{id}/retry — role: verifikator
     */
    public function retry(Request $request, string $id): JsonResponse
    {
        $baris = DB::table('failed_jobs')->where('id', $id)->orWhere('uuid', $id)->first();

        if (! $baris) {
            return response()->json([
                'message' => 'Job gagal tidak ditemukan.',
            ], 404);
        }

        Artisan::call('queue:retry', ['id' => [$baris->uuid]]);
        $keluaran = trim(Artisan::output());

        if (str_contains($keluaran, 'ERROR')) {
            return response()->json([
                'message' => 'Job gagal dikirim ulang.',
                'output' => $keluaran,
            ], 500);
        }

        return response()->json([
            'message' => 'Job dikirim ulang ke antrian.',
            'output' => $keluaran,
        ], 202);
    }
}
