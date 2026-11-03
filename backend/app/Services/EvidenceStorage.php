<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Evidence file storage — one door for LOCAL and SUPABASE modes.
 *
 * The mode follows EVIDENCE_DISK in .env, so switching modes is a one-line
 * change with no other code touched. Every read/write/delete of an evidence
 * file must go through this class.
 */
class EvidenceStorage
{
    public const DISK_LOKAL = 'local';

    public const DISK_SUPABASE = 'supabase';

    /** Active disk name ("local" or "supabase"). */
    public static function diskName(): string
    {
        $nama = (string) config('filesystems.evidence_disk', self::DISK_LOKAL);

        return in_array($nama, [self::DISK_LOKAL, self::DISK_SUPABASE], true)
            ? $nama
            : self::DISK_LOKAL;
    }

    public static function disk()
    {
        return Storage::disk(self::diskName());
    }

    /** Store an upload and return its relative path on the disk. */
    public static function simpan(UploadedFile $berkas, int $submissionId): string
    {
        return $berkas->store('evidences/'.$submissionId, self::diskName());
    }

    public static function ada(string $path): bool
    {
        return self::disk()->exists($path);
    }

    public static function hapus(string $path): void
    {
        self::disk()->delete($path);
    }

    /** Stream the file to the browser inline, whichever disk is active. */
    public static function kirim(string $path, string $namaAsli, ?string $mime): StreamedResponse
    {
        return self::disk()->response($path, $namaAsli, array_filter([
            'Content-Type' => $mime ?: 'application/octet-stream',
        ]), 'inline');
    }
}
