<?php

namespace App\Services;

use App\Models\Evidence;

/**
 * Text extraction from evidence files — PLACEHOLDER.
 *
 * The real implementation (pdftotext for a text layer, pdftoppm + tesseract
 * for scans, UTF-8 sanitising for PostgreSQL) was backed up by the team
 * before this module was agreed on. It needs OCR binaries that this machine
 * does not have, so every call would only return "gagal".
 *
 * To activate later: restore the client, install pdftotext + tesseract with
 * the ind language pack, and call it from JalankanAnalisisAi before the LLM
 * stage. Keep every external call wrapped so a missing tool marks the file
 * "gagal" instead of breaking the pipeline.
 */
class OcrService
{
    /**
     * @return array{teks:string|null, status:string, alasan:string}
     */
    public function ekstrak(Evidence $evidence): array
    {
        return [
            'teks' => null,
            'status' => 'belum',
            'alasan' => 'Modul OCR belum aktif — berkas belum dibaca.',
        ];
    }
}
