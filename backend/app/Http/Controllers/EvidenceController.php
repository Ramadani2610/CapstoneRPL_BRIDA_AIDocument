<?php

namespace App\Http\Controllers;

use App\Models\Evidence;
use App\Models\Indicator;
use App\Models\Submission;
use App\Models\SubmissionParameter;
use App\Services\EvidenceStorage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Evidence files — upload, download, delete.
 *
 * Allowed formats per indicator (locked in design):
 *   pdf             : .pdf
 *   pdf_atau_gambar : .pdf, .jpg, .jpeg, .png
 *   foto            : .jpg, .jpeg, .png
 *   video           : rejected (out of scope)
 *
 * Files go through EvidenceStorage so EVIDENCE_DISK switches modes without
 * touching this class. Never call Storage::disk() directly here.
 *
 * The name on disk is a random UUID; `nama_asli` is kept for display.
 * Downloads only happen through GET /api/evidences/{evidence}/file.
 */
class EvidenceController extends Controller
{
    private const EKSTENSI = [
        'pdf' => ['pdf'],
        'pdf_atau_gambar' => ['pdf', 'jpg', 'jpeg', 'png'],
        'foto' => ['jpg', 'jpeg', 'png'],
    ];

    /**
     * POST /api/submissions/{submission}/evidences — role: inovator
     */
    public function store(Request $request, Submission $submission): JsonResponse
    {
        abort_if($submission->user_id !== $request->user()->id, 404, 'Pengajuan tidak ditemukan.');
        abort_unless($submission->bolehDiubah(), 409, 'Pengajuan sudah dikirim dan tidak dapat diubah.');

        $data = $request->validate([
            'indicator_kode' => ['required', 'integer'],
            'file' => ['required', 'file', 'max:20480'],
            'tahun_dokumen' => ['nullable', 'integer', 'min:2000', 'max:2100'],
        ]);

        $indikator = Indicator::where('kode', $data['indicator_kode'])->firstOrFail();
        abort_unless($indikator->dalam_scope, 422, 'Indikator ini di luar cakupan sistem.');

        $file = $request->file('file');
        $ekstensi = strtolower($file->getClientOriginalExtension());

        $diizinkan = self::EKSTENSI[$indikator->tipe_bukti] ?? [];
        if (! in_array($ekstensi, $diizinkan, true)) {
            return response()->json([
                'message' => "Format berkas .{$ekstensi} tidak diterima untuk indikator {$indikator->nama}.",
                'format_diterima' => $diizinkan,
            ], 422);
        }

        // A tier must be chosen first — "one tier, one evidence"
        $param = SubmissionParameter::where('submission_id', $submission->id)
            ->where('indicator_id', $indikator->id)
            ->first();

        if (! $param) {
            return response()->json([
                'message' => "Pilih tingkat untuk indikator #{$indikator->kode} dulu sebelum mengunggah berkas.",
            ], 422);
        }

        $path = EvidenceStorage::simpan($file, $submission->id);

        $evidence = Evidence::create([
            'submission_id' => $submission->id,
            'indicator_id' => $indikator->id,
            'submission_parameter_id' => $param->id,
            'nama_asli' => $file->getClientOriginalName(),
            'path' => $path,
            'tipe_file' => $ekstensi,
            'mime' => $file->getClientMimeType(),
            'ukuran' => $file->getSize(),
            'tahun_dokumen' => $data['tahun_dokumen'] ?? null,
            'status_ocr' => 'belum',
            'uploaded_at' => now(),
        ]);

        return response()->json([
            'id' => $evidence->id,
            'nama_asli' => $evidence->nama_asli,
            'tipe_file' => $evidence->tipe_file,
            'ukuran' => $evidence->ukuran,
            'status_ocr' => $evidence->status_ocr,
        ], 201);
    }

    /**
     * GET /api/evidences/{evidence}/file — requires login.
     *
     * Allowed for verifikator/admin, or the innovator who owns it. Works in both
     * storage modes.
     */
    public function file(Request $request, Evidence $evidence): StreamedResponse
    {
        $user = $request->user();
        $submission = $evidence->submission;

        $boleh = $user->role === 'admin'
            || $user->role === 'verifikator'
            || $submission->user_id === $user->id;

        abort_unless($boleh, 403, 'Anda tidak berhak mengakses berkas ini.');
        abort_unless(EvidenceStorage::ada($evidence->path), 404, 'Berkas tidak ditemukan di penyimpanan.');

        return EvidenceStorage::kirim($evidence->path, $evidence->nama_asli, $evidence->mime);
    }

    /**
     * DELETE /api/evidences/{evidence} — role: inovator
     */
    public function destroy(Request $request, Evidence $evidence): JsonResponse
    {
        $submission = $evidence->submission;

        abort_if($submission->user_id !== $request->user()->id, 404, 'Berkas tidak ditemukan.');
        abort_unless($submission->bolehDiubah(), 409, 'Pengajuan sudah dikirim dan tidak dapat diubah.');

        EvidenceStorage::hapus($evidence->path);
        $evidence->delete();

        return response()->json(null, 204);
    }
}
