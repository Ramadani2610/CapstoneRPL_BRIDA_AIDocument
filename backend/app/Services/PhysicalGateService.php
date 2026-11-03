<?php

namespace App\Services;

use App\Models\Indicator;
use App\Models\Submission;

/**
 * Physical gate — the cheapest, deterministic check that always runs before AI.
 *
 * It catches the failure mode that actually occurs in the field ("claim the
 * maximum, evidence nothing") without paying for an AI call. More evidence
 * than the minimum is always legitimate and is never flagged here.
 */
class PhysicalGateService
{
    /**
     * File format against the indicator's expected evidence type.
     *
     * @return array<int, array{kode:int, jenis:string, pesan:string}>
     */
    public function periksaFormat(Submission $submission): array
    {
        $temuan = [];
        $ekstensi = [
            'pdf' => ['pdf'],
            'pdf_atau_gambar' => ['pdf', 'jpg', 'jpeg', 'png'],
            'foto' => ['jpg', 'jpeg', 'png'],
        ];

        foreach ($submission->evidences as $evidence) {
            $indikator = $evidence->indicator;

            if (! $indikator) {
                continue;
            }

            $diizinkan = $ekstensi[$indikator->tipe_bukti] ?? [];

            if ($diizinkan !== [] && ! in_array(strtolower($evidence->tipe_file), $diizinkan, true)) {
                $temuan[] = [
                    'kode' => $indikator->kode,
                    'jenis' => 'format_salah',
                    'pesan' => "Indikator #{$indikator->kode}: berkas \"{$evidence->nama_asli}\" berformat .{$evidence->tipe_file}, seharusnya ".implode('/', $diizinkan).'.',
                ];
            }
        }

        return $temuan;
    }

    /**
     * Minimum completeness: what is claimed versus what is proven.
     *
     * @return array<int, array{kode:int, jenis:string, pesan:string}>
     */
    public function periksaKelengkapan(Submission $submission): array
    {
        $temuan = [];

        $wajib = Indicator::dalamScope()->where('wajib', true)->get(['id', 'kode', 'nama']);
        $paramIds = $submission->parameters->pluck('indicator_id');

        foreach ($wajib as $ind) {
            if (! $paramIds->contains($ind->id)) {
                $temuan[] = [
                    'kode' => $ind->kode,
                    'jenis' => 'wajib_kosong',
                    'pesan' => "Indikator WAJIB #{$ind->kode} ({$ind->nama}) belum dipilih tingkatnya.",
                ];
            }
        }

        foreach ($submission->parameters as $param) {
            $jumlah = $submission->evidences->where('indicator_id', $param->indicator_id)->count();
            $kode = $param->indicator?->kode;

            if ($jumlah === 0) {
                $jenis = $param->bintang_diklaim >= 2 ? 'klaim_tinggi_tanpa_bukti' : 'tanpa_bukti';

                $temuan[] = [
                    'kode' => $kode,
                    'jenis' => $jenis,
                    'pesan' => "Indikator #{$kode}: diklaim bintang {$param->bintang_diklaim} tetapi TIDAK ADA berkas bukti.",
                ];
            }
        }

        return $temuan;
    }
}
