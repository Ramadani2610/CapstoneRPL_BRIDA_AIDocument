<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\IndicatorTier;
use App\Models\Submission;
use App\Models\SubmissionParameter;
use App\Models\SubmissionStatusHistory;
use App\Services\EvidenceStorage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Innovation submissions (innovator side).
 *
 * Rules that hold in every method:
 *  - An innovator may only touch their own submissions.
 *  - Edit/delete only while the status is draft or direvisi.
 *  - Once submitted, the submission is locked for the innovator.
 */
class SubmissionController extends Controller
{
    private function milikSendiri(Request $request, Submission $submission): void
    {
        abort_if($submission->user_id !== $request->user()->id, 404, 'Pengajuan tidak ditemukan.');
    }

    private function harusBisaDiubah(Submission $submission): void
    {
        abort_unless(
            $submission->bolehDiubah(),
            409,
            'Pengajuan berstatus "'.$submission->status.'" dan tidak dapat diubah lagi oleh inovator.'
        );
    }

    /** Display code: INV-2026-014 */
    private function kode(Submission $submission): string
    {
        return 'INV-'.$submission->tahun.'-'.str_pad((string) $submission->id, 3, '0', STR_PAD_LEFT);
    }

    /**
     * GET /api/dashboard/inovator — role: inovator
     */
    public function dashboard(Request $request): JsonResponse
    {
        $q = Submission::where('user_id', $request->user()->id);

        return response()->json([
            'total' => (clone $q)->count(),
            'draft' => (clone $q)->where('status', Submission::STATUS_DRAFT)->count(),
            'proses' => (clone $q)->whereIn('status', [Submission::STATUS_DIAJUKAN, Submission::STATUS_DIPROSES])->count(),
            'revisi' => (clone $q)->where('status', Submission::STATUS_DIREVISI)->count(),
            'selesai' => (clone $q)->where('status', Submission::STATUS_DITERIMA)->count(),
        ]);
    }

    /**
     * GET /api/submissions — role: inovator
     */
    public function index(Request $request): JsonResponse
    {
        $query = Submission::where('user_id', $request->user()->id)
            ->orderByDesc('updated_at');

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $data = $query->paginate(10)->through(fn (Submission $s) => [
            'id' => $s->id,
            'kode' => $this->kode($s),
            'judul' => $s->judul,
            'kategori' => $s->kategori,
            'tahun' => $s->tahun,
            'status' => $s->status,
            'dibuat' => $s->created_at?->toISOString(),
            'diperbarui' => $s->updated_at?->toISOString(),
        ]);

        return response()->json($data);
    }

    /**
     * POST /api/submissions — role: inovator
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'min:3', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'opd' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'tahun' => ['nullable', 'integer', 'min:2020', 'max:2100'],
        ]);

        $submission = Submission::create([
            ...$data,
            'user_id' => $request->user()->id,
            'tahun' => $data['tahun'] ?? now()->year,
            'status' => Submission::STATUS_DRAFT,
        ]);

        $this->catatStatus($submission, null, Submission::STATUS_DRAFT, $request->user()->id, 'Draft dibuat');

        return response()->json([
            'id' => $submission->id,
            'kode' => $this->kode($submission),
            'judul' => $submission->judul,
            'status' => $submission->status,
        ], 201);
    }

    /**
     * GET /api/submissions/{submission} — role: inovator
     */
    public function show(Request $request, Submission $submission): JsonResponse
    {
        $this->milikSendiri($request, $submission);

        $submission->load([
            'parameters.indicator',
            'parameters.tier',
            'evidences',
            'decisions.indicator',
        ]);

        return response()->json([
            'id' => $submission->id,
            'kode' => $this->kode($submission),
            'judul' => $submission->judul,
            'deskripsi' => $submission->deskripsi,
            'opd' => $submission->opd,
            'kategori' => $submission->kategori,
            'tahun' => $submission->tahun,
            'status' => $submission->status,
            'catatan_revisi' => $submission->catatan_revisi,
            'total_skor' => $submission->total_skor,
            'predikat' => $submission->predikat,
            'submitted_at' => $submission->submitted_at?->toISOString(),
            'decided_at' => $submission->decided_at?->toISOString(),
            'parameters' => $submission->parameters->map(fn ($p) => [
                'indicator_kode' => $p->indicator?->kode,
                'indicator_nama' => $p->indicator?->nama,
                'bintang_diklaim' => $p->bintang_diklaim,
                'tier_label' => $p->tier?->label,
                'jumlah_berkas' => $p->evidences->count(),
            ]),
            'evidences' => $submission->evidences->map(fn ($e) => [
                'id' => $e->id,
                'indicator_kode' => $e->indicator?->kode,
                'nama_asli' => $e->nama_asli,
                'tipe_file' => $e->tipe_file,
                'ukuran' => $e->ukuran,
                'tahun_dokumen' => $e->tahun_dokumen,
                'status_ocr' => $e->status_ocr,
                'url' => '/api/evidences/'.$e->id.'/file',
            ]),
            'hasil' => $submission->decisions->map(fn ($d) => [
                'indicator_kode' => $d->indicator?->kode,
                'bintang_final' => $d->bintang_final,
                'skor' => $d->skor,
                'catatan' => $d->catatan,
            ]),
        ]);
    }

    /**
     * PUT /api/submissions/{submission} — role: inovator
     */
    public function update(Request $request, Submission $submission): JsonResponse
    {
        $this->milikSendiri($request, $submission);
        $this->harusBisaDiubah($submission);

        $data = $request->validate([
            'judul' => ['sometimes', 'string', 'min:3', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'opd' => ['sometimes', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:100'],
        ]);

        $submission->update($data);

        return response()->json(['id' => $submission->id, 'status' => $submission->status]);
    }

    /**
     * DELETE /api/submissions/{submission} — role: inovator
     */
    public function destroy(Request $request, Submission $submission): JsonResponse
    {
        $this->milikSendiri($request, $submission);

        abort_unless(
            $submission->status === Submission::STATUS_DRAFT,
            409,
            'Hanya pengajuan berstatus draft yang dapat dihapus.'
        );

        DB::transaction(function () use ($submission) {
            foreach ($submission->evidences as $evidence) {
                EvidenceStorage::hapus($evidence->path);
            }
            $submission->delete();
        });

        return response()->json(null, 204);
    }

    /**
     * GET /api/submissions/{submission}/parameters — role: inovator
     */
    public function parameters(Request $request, Submission $submission): JsonResponse
    {
        $this->milikSendiri($request, $submission);

        $tahun = $submission->tahun;

        $indikators = Indicator::dalamScope()
            ->orderBy('kode')
            ->with(['tiers' => fn ($q) => $q->where('tahun', $tahun)->orderByDesc('bintang')])
            ->get();

        $dipilih = SubmissionParameter::where('submission_id', $submission->id)
            ->get()
            ->keyBy('indicator_id');

        $data = $indikators->map(function (Indicator $i) use ($dipilih) {
            $p = $dipilih->get($i->id);

            return [
                'indicator_kode' => $i->kode,
                'indicator_nama' => $i->nama,
                'bobot' => $i->bobot,
                'wajib' => $i->wajib,
                'tipe_bukti' => $i->tipe_bukti,
                'tiers' => $i->tiers->map(fn (IndicatorTier $t) => [
                    'id' => $t->id,
                    'bintang' => $t->bintang,
                    'label' => $t->label,
                    'deskripsi_bukti' => $t->deskripsi_bukti,
                ]),
                'dipilih' => $p ? [
                    'tier_id' => $p->tier_id,
                    'bintang_diklaim' => $p->bintang_diklaim,
                ] : null,
            ];
        });

        return response()->json(['tahun' => $tahun, 'data' => $data]);
    }

    /**
     * PUT /api/submissions/{submission}/parameters/{indicator} — role: inovator
     */
    public function simpanParameter(Request $request, Submission $submission, int $indicator): JsonResponse
    {
        $this->milikSendiri($request, $submission);
        $this->harusBisaDiubah($submission);

        $data = $request->validate([
            'tier_id' => ['required', 'integer', 'exists:indicator_tiers,id'],
        ]);

        $indikator = Indicator::where('kode', $indicator)->firstOrFail();
        abort_unless($indikator->dalam_scope, 422, 'Indikator ini di luar cakupan sistem.');

        $tier = IndicatorTier::where('id', $data['tier_id'])
            ->where('indicator_id', $indikator->id)
            ->where('tahun', $submission->tahun)
            ->first();

        abort_if($tier === null, 422, 'Tingkat yang dipilih tidak sesuai indikator/tahun pengajuan.');

        $param = SubmissionParameter::updateOrCreate(
            ['submission_id' => $submission->id, 'indicator_id' => $indikator->id],
            ['tier_id' => $tier->id, 'bintang_diklaim' => $tier->bintang],
        );

        return response()->json([
            'indicator_kode' => $indikator->kode,
            'tier_id' => $param->tier_id,
            'bintang_diklaim' => $param->bintang_diklaim,
        ]);
    }

    /**
     * POST /api/submissions/{submission}/submit — role: inovator
     */
    public function submit(Request $request, Submission $submission): JsonResponse
    {
        $this->milikSendiri($request, $submission);
        $this->harusBisaDiubah($submission);

        $kurang = [];

        if (! $submission->judul || ! $submission->opd) {
            $kurang[] = ['jenis' => 'info_dasar', 'pesan' => 'Judul dan OPD wajib diisi.'];
        }

        $wajibKode = Indicator::dalamScope()->where('wajib', true)->pluck('kode', 'id');
        $terisi = SubmissionParameter::where('submission_id', $submission->id)->pluck('bintang_diklaim', 'indicator_id');

        foreach ($wajibKode as $id => $kode) {
            if (! $terisi->has($id)) {
                $kurang[] = ['jenis' => 'wajib_kosong', 'pesan' => "Indikator wajib #{$kode} belum dipilih tingkatnya."];
            }
        }

        $tanpaBukti = SubmissionParameter::where('submission_id', $submission->id)
            ->withCount('evidences')
            ->with('indicator')
            ->get()
            ->filter(fn ($p) => $p->evidences_count === 0);

        foreach ($tanpaBukti as $p) {
            $kode = $p->indicator?->kode;
            $kurang[] = ['jenis' => 'tanpa_bukti', 'pesan' => "Indikator #{$kode} belum punya berkas bukti."];
        }

        if ($kurang !== []) {
            return response()->json([
                'message' => 'Pengajuan belum lengkap.',
                'kurang' => $kurang,
            ], 422);
        }

        DB::transaction(function () use ($submission, $request) {
            $lama = $submission->status;
            $submission->update([
                'status' => Submission::STATUS_DIAJUKAN,
                'submitted_at' => now(),
                'catatan_revisi' => null,
            ]);
            $this->catatStatus($submission, $lama, Submission::STATUS_DIAJUKAN, $request->user()->id, 'Pengajuan dikirim');
        });

        return response()->json(['id' => $submission->id, 'status' => $submission->status]);
    }

    /**
     * GET /api/submissions/{submission}/riwayat — role: inovator
     */
    public function riwayat(Request $request, Submission $submission): JsonResponse
    {
        $this->milikSendiri($request, $submission);

        $data = SubmissionStatusHistory::where('submission_id', $submission->id)
            ->with('oleh')
            ->orderBy('id')
            ->get()
            ->map(fn ($h) => [
                'status_lama' => $h->status_lama,
                'status_baru' => $h->status_baru,
                'catatan' => $h->catatan,
                'oleh' => $h->oleh?->name ?? 'Sistem',
                'waktu' => $h->created_at?->toISOString(),
            ]);

        return response()->json(['data' => $data]);
    }

    private function catatStatus(Submission $submission, ?string $lama, string $baru, ?int $oleh, ?string $catatan = null): void
    {
        SubmissionStatusHistory::create([
            'submission_id' => $submission->id,
            'status_lama' => $lama,
            'status_baru' => $baru,
            'oleh_user_id' => $oleh,
            'catatan' => $catatan,
            'created_at' => now(),
        ]);
    }
}
