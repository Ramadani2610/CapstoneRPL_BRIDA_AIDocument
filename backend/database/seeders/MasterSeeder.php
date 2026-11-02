<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Master data: indicators, tiers and predicate thresholds.
 *
 * Source of truth for the whole system. Without these rows every form is
 * empty and no submission can be scored. Values mirror the Kemendagri IID
 * instrument (indicator kode 21..44) as loaded in the production database.
 */
class MasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->seedPredikat();
            $this->seedIndikator();
            $this->seedTingkat();
        });
    }

    private function seedPredikat(): void
    {
        foreach ($this->predikat() as $baris) {
            DB::table('predicate_thresholds')->updateOrInsert(
                ['tahun' => $baris['tahun'], 'nama_predikat' => $baris['nama_predikat']],
                ['skor_min' => $baris['skor_min'], 'skor_max' => $baris['skor_max']],
            );
        }
    }

    private function seedIndikator(): void
    {
        foreach ($this->indikator() as $baris) {
            DB::table('indicators')->updateOrInsert(
                ['kode' => $baris['kode']],
                [
                    'nama' => $baris['nama'],
                    'deskripsi' => $baris['deskripsi'],
                    'bobot' => $baris['bobot'],
                    'wajib' => $baris['wajib'],
                    'tipe_bukti' => $baris['tipe_bukti'],
                    'rentang_tahun' => $baris['rentang_tahun'],
                    'dalam_scope' => $baris['dalam_scope'],
                    'urutan' => $baris['urutan'],
                ],
            );
        }
    }

    private function seedTingkat(): void
    {
        $kodeKeId = DB::table('indicators')->pluck('id', 'kode');

        foreach ($this->tingkat() as $baris) {
            DB::table('indicator_tiers')->updateOrInsert(
                [
                    'indicator_id' => $kodeKeId[$baris['kode']],
                    'tahun' => $baris['tahun'],
                    'bintang' => $baris['bintang'],
                ],
                [
                    'label' => $baris['label'],
                    'deskripsi_bukti' => $baris['deskripsi_bukti'],
                ],
            );
        }
    }

    /** @return array<int, array<string, mixed>> */
    private function indikator(): array
    {
        return [
            ['kode' => 21, 'nama' => 'Regulasi Inovasi Daerah', 'deskripsi' => null, 'bobot' => 3, 'wajib' => true, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 1],
            ['kode' => 22, 'nama' => 'Ketersediaan SDM terhadap Inovasi', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 2],
            ['kode' => 23, 'nama' => 'Dukungan Anggaran', 'deskripsi' => null, 'bobot' => 2, 'wajib' => true, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0_t1_t2', 'dalam_scope' => true, 'urutan' => 3],
            ['kode' => 24, 'nama' => 'BIMTEK Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0_t1_t2', 'dalam_scope' => true, 'urutan' => 4],
            ['kode' => 25, 'nama' => 'Integrasi Program & Kegiatan dalam RKPD', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0_t1_t2', 'dalam_scope' => true, 'urutan' => 5],
            ['kode' => 26, 'nama' => 'Keterlibatan Aktor Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 6],
            ['kode' => 27, 'nama' => 'Pelaksana Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 7],
            ['kode' => 28, 'nama' => 'Jejaring Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => true, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 8],
            ['kode' => 29, 'nama' => 'Sosialisasi Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'foto', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 9],
            ['kode' => 30, 'nama' => 'Pedoman Teknis', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf_atau_gambar', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 10],
            ['kode' => 31, 'nama' => 'Kuantitas Media', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'foto', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 11],
            ['kode' => 32, 'nama' => 'Kemudahan Proses', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 12],
            ['kode' => 33, 'nama' => 'Integrasi Layanan', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'foto', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 13],
            ['kode' => 34, 'nama' => 'Replikasi', 'deskripsi' => null, 'bobot' => 3, 'wajib' => false, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 14],
            ['kode' => 35, 'nama' => 'Alat Kerja', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'foto', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 15],
            ['kode' => 36, 'nama' => 'Kemanfaatan', 'deskripsi' => null, 'bobot' => 3, 'wajib' => true, 'tipe_bukti' => 'pdf_atau_gambar', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 16],
            ['kode' => 37, 'nama' => 'Kecepatan', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 17],
            ['kode' => 39, 'nama' => 'Penyelesaian Pengaduan', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf_atau_gambar', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 18],
            ['kode' => 41, 'nama' => 'Monev', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf_atau_gambar', 'rentang_tahun' => 't0', 'dalam_scope' => true, 'urutan' => 19],
            ['kode' => 44, 'nama' => 'Kualitas Inovasi (video — di luar scope)', 'deskripsi' => null, 'bobot' => 4, 'wajib' => true, 'tipe_bukti' => 'video', 'rentang_tahun' => 't0', 'dalam_scope' => false, 'urutan' => 20],
        ];
    }

    /** @return array<int, array<string, mixed>> */
    private function tingkat(): array
    {
        return [
            ['kode' => 21, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Surat Keputusan Kepala Perangkat Daerah', 'deskripsi_bukti' => 'Salinan SK dari Kepala OPD pembuat inovasi.'],
            ['kode' => 21, 'tahun' => 2026, 'bintang' => 2, 'label' => 'Surat Keputusan Kepala Daerah', 'deskripsi_bukti' => 'Salinan SK dari Kepala Daerah (Wali Kota).'],
            ['kode' => 21, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Peraturan Daerah / Peraturan Kepala Daerah', 'deskripsi_bukti' => 'Salinan Perda / Perkada yang mengatur inovasi daerah tersebut.'],
            ['kode' => 22, 'tahun' => 2026, 'bintang' => 1, 'label' => '1 - 10 orang', 'deskripsi_bukti' => 'SK/daftar SDM 1 sampai 10 orang.'],
            ['kode' => 22, 'tahun' => 2026, 'bintang' => 2, 'label' => '11 - 30 orang', 'deskripsi_bukti' => 'SK/daftar SDM 11 sampai 30 orang.'],
            ['kode' => 22, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Lebih dari 30 orang', 'deskripsi_bukti' => 'SK/daftar SDM lebih dari 30 orang.'],
            ['kode' => 23, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Tahun T-0 saja', 'deskripsi_bukti' => 'Dokumen anggaran tahun berjalan saja.'],
            ['kode' => 23, 'tahun' => 2026, 'bintang' => 2, 'label' => 'Tahun T-1 atau T-2', 'deskripsi_bukti' => 'Dokumen anggaran tahun sebelumnya (1-2 dokumen).'],
            ['kode' => 23, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Tahun T-0, T-1 dan T-2', 'deskripsi_bukti' => 'Tiga dokumen anggaran — satu untuk tiap tahun. (Satu tingkat, bukti mengikuti: 3 dokumen.)'],
            ['kode' => 24, 'tahun' => 2026, 'bintang' => 1, 'label' => '1 kali', 'deskripsi_bukti' => 'Bukti 1 kali kegiatan bimtek.'],
            ['kode' => 24, 'tahun' => 2026, 'bintang' => 2, 'label' => '2 kali', 'deskripsi_bukti' => 'Bukti 2 kali kegiatan bimtek.'],
            ['kode' => 24, 'tahun' => 2026, 'bintang' => 3, 'label' => '3 tahun (T-2, T-1, T-0) atau lebih dari 2 kali', 'deskripsi_bukti' => 'Bukti bimtek pada tiga tahun atau lebih dari 2 kali kegiatan. (IID 2026: ≥3.)'],
            ['kode' => 25, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Tahun T-1 atau T-2', 'deskripsi_bukti' => 'Dokumen RKPD salah satu dari dua tahun sebelumnya.'],
            ['kode' => 25, 'tahun' => 2026, 'bintang' => 2, 'label' => 'Tahun T-1 dan T-2', 'deskripsi_bukti' => 'Dokumen RKPD dua tahun sebelumnya.'],
            ['kode' => 25, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Tahun T-1, T-2 dan T-0', 'deskripsi_bukti' => 'Dokumen RKPD yang memuat program/kegiatan inovasi pada tiga tahun (T-0, T-1, dan T-2).'],
            ['kode' => 26, 'tahun' => 2026, 'bintang' => 1, 'label' => '3 aktor', 'deskripsi_bukti' => 'SK/undangan dengan 3 aktor.'],
            ['kode' => 26, 'tahun' => 2026, 'bintang' => 2, 'label' => '4 aktor', 'deskripsi_bukti' => 'SK/undangan dengan 4 aktor.'],
            ['kode' => 26, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Lebih dari atau sama dengan 5 aktor', 'deskripsi_bukti' => 'SK/undangan yang menyebut ≥5 aktor. (IID 2026: ≥5.)'],
            ['kode' => 27, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Ada pelaksana, tanpa SK', 'deskripsi_bukti' => 'Ada pelaksana namun belum ada SK penetapan.'],
            ['kode' => 27, 'tahun' => 2026, 'bintang' => 2, 'label' => 'SK Kepala Perangkat Daerah', 'deskripsi_bukti' => 'SK penetapan pelaksana dari Kepala OPD.'],
            ['kode' => 27, 'tahun' => 2026, 'bintang' => 3, 'label' => 'SK Kepala Daerah', 'deskripsi_bukti' => 'SK penetapan pelaksana dari Kepala Daerah.'],
            ['kode' => 28, 'tahun' => 2026, 'bintang' => 1, 'label' => '1 - 2 perangkat daerah', 'deskripsi_bukti' => 'SK/ST tim dengan 1-2 perangkat daerah.'],
            ['kode' => 28, 'tahun' => 2026, 'bintang' => 2, 'label' => '3 - 4 perangkat daerah', 'deskripsi_bukti' => 'SK/ST tim dengan 3-4 perangkat daerah.'],
            ['kode' => 28, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Lebih dari atau sama dengan 5 perangkat daerah', 'deskripsi_bukti' => 'SK/ST tim dengan ≥5 perangkat daerah.'],
            ['kode' => 29, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Ada bukti sosialisasi', 'deskripsi_bukti' => 'Foto kegiatan / screenshot media sosial (JPG/JPEG/PNG). (TODO KONFIRMASI: apakah ada tingkat lebih tinggi.)'],
            ['kode' => 30, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Buku cetak / manual', 'deskripsi_bukti' => 'Pedoman teknis berbentuk buku cetak atau manual.'],
            ['kode' => 30, 'tahun' => 2026, 'bintang' => 2, 'label' => 'Buku elektronik', 'deskripsi_bukti' => 'Pedoman teknis berbentuk buku elektronik (PDF/e-book).'],
            ['kode' => 30, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Buku akses online atau video tutorial', 'deskripsi_bukti' => 'Pedoman teknis berbentuk buku akses online atau video tutorial. (IID 2026: buku online ATAU video tutorial.)'],
            ['kode' => 31, 'tahun' => 2026, 'bintang' => 1, 'label' => '1 dari 4 media', 'deskripsi_bukti' => 'Bukti dari 1 media.'],
            ['kode' => 31, 'tahun' => 2026, 'bintang' => 2, 'label' => '2 dari 4 media', 'deskripsi_bukti' => 'Bukti dari 2 media.'],
            ['kode' => 31, 'tahun' => 2026, 'bintang' => 3, 'label' => '3 - 4 dari 4 media', 'deskripsi_bukti' => 'Bukti dari 3-4 media (manual, hotline, media sosial, online).'],
            ['kode' => 32, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Lebih dari atau sama dengan 6 hari', 'deskripsi_bukti' => 'Proses layanan ≥6 hari.'],
            ['kode' => 32, 'tahun' => 2026, 'bintang' => 2, 'label' => '2 - 5 hari', 'deskripsi_bukti' => 'Proses layanan 2-5 hari.'],
            ['kode' => 32, 'tahun' => 2026, 'bintang' => 3, 'label' => '1 hari', 'deskripsi_bukti' => 'Proses layanan selesai dalam 1 hari.'],
            ['kode' => 33, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Berjalan terpisah', 'deskripsi_bukti' => 'Layanan berjalan sendiri-sendiri.'],
            ['kode' => 33, 'tahun' => 2026, 'bintang' => 2, 'label' => 'Satu portal layanan', 'deskripsi_bukti' => 'Layanan berada dalam satu portal.'],
            ['kode' => 33, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Terintegrasi dengan unit organisasi lain', 'deskripsi_bukti' => 'Layanan terintegrasi lintas unit/OPD.'],
            ['kode' => 34, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Direplikasi 1 kali', 'deskripsi_bukti' => '1 dokumen PKS/MoU.'],
            ['kode' => 34, 'tahun' => 2026, 'bintang' => 2, 'label' => 'Direplikasi 2 kali', 'deskripsi_bukti' => '2 dokumen PKS/MoU.'],
            ['kode' => 34, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Direplikasi 3 kali', 'deskripsi_bukti' => '3 dokumen PKS/MoU — satu per daerah replikasi.'],
            ['kode' => 35, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Manual / non-elektronik', 'deskripsi_bukti' => 'Alat kerja manual.'],
            ['kode' => 35, 'tahun' => 2026, 'bintang' => 2, 'label' => 'Perangkat elektronik', 'deskripsi_bukti' => 'Alat kerja berbasis perangkat elektronik (non-daring).'],
            ['kode' => 35, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Sistem online / daring', 'deskripsi_bukti' => 'Alat kerja berbasis sistem online.'],
            ['kode' => 36, 'tahun' => 2026, 'bintang' => 1, 'label' => '1 - 100 penerima', 'deskripsi_bukti' => 'Rekap + laporan penerima manfaat 1-100 orang.'],
            ['kode' => 36, 'tahun' => 2026, 'bintang' => 2, 'label' => '101 - 500 penerima', 'deskripsi_bukti' => 'Rekap + laporan penerima manfaat 101-500 orang. (TODO KONFIRMASI batas dengan BRIDA.)'],
            ['kode' => 36, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Lebih dari atau sama dengan 501 penerima', 'deskripsi_bukti' => 'Rekap + laporan penerima manfaat ≥501 orang. (IID 2026: ≥501; dek panduan: ≥201 — TODO KONFIRMASI.)'],
            ['kode' => 37, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Lebih dari atau sama dengan 9 bulan', 'deskripsi_bukti' => 'Waktu ≥9 bulan.'],
            ['kode' => 37, 'tahun' => 2026, 'bintang' => 2, 'label' => '5 - 8 bulan', 'deskripsi_bukti' => 'Waktu 5-8 bulan.'],
            ['kode' => 37, 'tahun' => 2026, 'bintang' => 3, 'label' => '1 - 4 bulan', 'deskripsi_bukti' => 'Waktu dari proposal sampai penerapan 1-4 bulan.'],
            ['kode' => 39, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Rasio ≤50%', 'deskripsi_bukti' => 'Rekap pengaduan rasio ≤50%.'],
            ['kode' => 39, 'tahun' => 2026, 'bintang' => 2, 'label' => 'Rasio 51 - 90%', 'deskripsi_bukti' => 'Rekap pengaduan rasio 51-90%. (Rentang 86-90 belum terdefinisi di kedua sumber — TODO KONFIRMASI.)'],
            ['kode' => 39, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Rasio penyelesaian ≥91%', 'deskripsi_bukti' => 'Rekap pengaduan dengan rasio ≥91%. (IID 2026: ≥91%; dek panduan: ≥86% — beda sumber.)'],
            ['kode' => 41, 'tahun' => 2026, 'bintang' => 1, 'label' => 'Monev internal', 'deskripsi_bukti' => 'Monev dilakukan internal OPD.'],
            ['kode' => 41, 'tahun' => 2026, 'bintang' => 2, 'label' => 'Survei kepuasan masyarakat (SKM)', 'deskripsi_bukti' => 'Monev melalui SKM.'],
            ['kode' => 41, 'tahun' => 2026, 'bintang' => 3, 'label' => 'Monev eksternal', 'deskripsi_bukti' => 'Monitoring & evaluasi oleh pihak eksternal.'],
        ];
    }

    /** @return array<int, array{tahun:int, nama_predikat:string, skor_min:float, skor_max:float}> */
    private function predikat(): array
    {
        return [
            ['tahun' => 2024, 'nama_predikat' => 'Kurang Inovatif', 'skor_min' => 0.01, 'skor_max' => 34.99],
            ['tahun' => 2024, 'nama_predikat' => 'Inovatif', 'skor_min' => 35, 'skor_max' => 60],
            ['tahun' => 2024, 'nama_predikat' => 'Sangat Inovatif', 'skor_min' => 60.01, 'skor_max' => 100],
            ['tahun' => 2025, 'nama_predikat' => 'Kurang Inovatif', 'skor_min' => 0.01, 'skor_max' => 40],
            ['tahun' => 2025, 'nama_predikat' => 'Inovatif', 'skor_min' => 40.01, 'skor_max' => 65],
            ['tahun' => 2025, 'nama_predikat' => 'Sangat Inovatif', 'skor_min' => 65.01, 'skor_max' => 100],
            ['tahun' => 2026, 'nama_predikat' => 'Kurang Inovatif', 'skor_min' => 0.01, 'skor_max' => 40],
            ['tahun' => 2026, 'nama_predikat' => 'Inovatif', 'skor_min' => 40.01, 'skor_max' => 65],
            ['tahun' => 2026, 'nama_predikat' => 'Sangat Inovatif', 'skor_min' => 65.01, 'skor_max' => 100],
        ];
    }
}
