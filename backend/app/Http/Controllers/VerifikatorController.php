<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifikatorController extends Controller
{
    public function dashboard()
    {
        $reviewItems = [
            [
                'id' => 1,
                'judul' => 'Dashboard Command Center Penanganan Banjir',
                'kodeInovasi' => 'INV-2026-009',
                'opd' => 'Dinas Komunikasi dan Informatika',
                'tglDiajukan' => '20 Sep 2026',
                'jumlahDokumen' => 5,
                'aiRecommendation' => [
                    'type' => 'lolos',
                    'label' => 'Saran AI: Lolos',
                    'score' => 92,
                ],
                'statusReview' => 'Menunggu Review',
                'indikator' => 'IND-01',
            ],
            [
                'id' => 2,
                'judul' => 'Si-Lapor Sampah Lorong',
                'kodeInovasi' => 'INV-2026-012',
                'opd' => 'Dinas Komunikasi dan Informatika',
                'tglDiajukan' => '22 Sep 2026',
                'jumlahDokumen' => 3,
                'aiRecommendation' => [
                    'type' => 'lolos',
                    'label' => 'Saran AI: Lolos',
                    'score' => 88,
                ],
                'statusReview' => 'Menunggu Review',
                'indikator' => 'IND-05',
            ],
            [
                'id' => 3,
                'judul' => 'Posyandu Digital Terintegrasi',
                'kodeInovasi' => 'INV-2026-015',
                'opd' => 'Dinas Kesehatan',
                'tglDiajukan' => '25 Sep 2026',
                'jumlahDokumen' => 3,
                'aiRecommendation' => [
                    'type' => 'keyakinan_rendah',
                    'label' => 'Saran AI: Keyakinan Rendah',
                    'score' => 54,
                ],
                'statusReview' => 'Menunggu Review',
                'indikator' => 'IND-06',
            ],
            [
                'id' => 4,
                'judul' => 'Bank Sampah Lorong Garden',
                'kodeInovasi' => 'INV-2026-008',
                'opd' => 'Dinas Lingkungan Hidup',
                'tglDiajukan' => '23 Sep 2026',
                'jumlahDokumen' => 2,
                'aiRecommendation' => [
                    'type' => 'keyakinan_rendah',
                    'label' => 'Saran AI: Keyakinan Rendah',
                    'score' => 62,
                ],
                'statusReview' => 'Menunggu Review',
                'indikator' => 'IND-07',
            ],
        ];

        return view('verifikator.dashboard', [
            'reviewItems' => $reviewItems,
        ]);
    }

    public function antrianReview()
    {
        $failedDocuments = [
            [
                'id' => 1,
                'fileName' => 'Scan_BeritaAcara_UjiCoba.pdf',
                'fileSize' => '7,4 MB',
                'submissionId' => 'INV-2026-015',
                'innovationName' => 'Posyandu Digital Terintegrasi',
                'indicator' => 'IND-06 · 5 bulan atau kurang',
                'errorType' => 'OCR Gagal',
                'description' => 'Keterbacaan teks hanya 41%. Dokumen hasil pindai buram atau miring.',
                'attempt' => 'Percobaan 1/3',
                'failedAt' => 'Gagal 26 Sep 2026, 08:47',
                'icon' => 'ocr',
                'canRetry' => true,
                'retryLabel' => 'Retry AI Processing',
            ],
            [
                'id' => 2,
                'fileName' => 'DPA_Disidik_2026.pdf',
                'fileSize' => '9,6 MB',
                'submissionId' => 'INV-2026-013',
                'innovationName' => 'Beasiswa Makassar Cerdas Online',
                'indicator' => 'IND-03 · APBD tahun berjalan',
                'errorType' => 'Timeout AI',
                'description' => 'Analisis AI melewati batas waktu 120 detik (dokumen 48 halaman).',
                'attempt' => 'Percobaan 2/3',
                'failedAt' => 'Gagal 26 Sep 2026, 07:31',
                'icon' => 'timeout',
                'canRetry' => true,
                'retryLabel' => 'Retry AI Processing',
            ],
            [
                'id' => 3,
                'fileName' => 'Laporan_Pengguna_Q2.pdf',
                'fileSize' => '2,4 MB',
                'submissionId' => 'INV-2026-008',
                'innovationName' => 'Bank Sampah Lorong Garden',
                'indicator' => 'IND-07 · Lebih dari 200 penerima manfaat',
                'errorType' => 'File Terproteksi',
                'description' => 'File dilindungi kata sandi sehingga tidak dapat dibaca sistem.',
                'attempt' => 'Percobaan 1/3',
                'failedAt' => 'Gagal 25 Sep 2026, 16:05',
                'icon' => 'protected',
                'canRetry' => false,
                'retryLabel' => 'Minta Unggah Ulang',
            ],
            [
                'id' => 4,
                'fileName' => 'Dokumentasi_Bimtek_Juni.pdf',
                'fileSize' => '5,1 MB',
                'submissionId' => 'INV-2026-012',
                'innovationName' => 'Si-Lapor Sampah Lorong',
                'indicator' => 'IND-05 · 2 kali',
                'errorType' => 'Tanpa Lapisan Teks',
                'description' => 'Halaman 2–9 hanya berisi gambar tanpa lapisan teks.',
                'attempt' => 'Percobaan 1/3',
                'failedAt' => 'Gagal 25 Sep 2026, 11:18',
                'icon' => 'text',
                'canRetry' => true,
                'retryLabel' => 'Retry AI Processing',
            ],
            [
                'id' => 5,
                'fileName' => 'SK_Tim_Pelaksana_scan.pdf',
                'fileSize' => '3,3 MB',
                'submissionId' => 'INV-2026-013',
                'innovationName' => 'Beasiswa Makassar Cerdas Online',
                'indicator' => 'IND-02 · 11–30 SDM',
                'errorType' => 'OCR Gagal',
                'description' => 'Keterbacaan 58%. Stempel menutupi sebagian teks utama.',
                'attempt' => 'Percobaan 3/3',
                'failedAt' => 'Gagal 24 Sep 2026, 14:40',
                'icon' => 'ocr',
                'canRetry' => false,
                'retryLabel' => 'Minta Unggah Ulang',
                'lastAttempt' => true,
            ],
            [
                'id' => 6,
                'fileName' => 'Berita_Acara_Sosialisasi.pdf',
                'fileSize' => '4,7 MB',
                'submissionId' => 'INV-2026-010',
                'innovationName' => 'Makassar Smart Parking',
                'indicator' => 'IND-04 · Minimal 3 lokasi uji coba',
                'errorType' => 'Timeout AI',
                'description' => 'Analisis AI melewati batas waktu 120 detik karena struktur dokumen tidak dapat diproses secara optimal.',
                'attempt' => 'Percobaan 1/3',
                'failedAt' => 'Gagal 23 Sep 2026, 10:26',
                'icon' => 'timeout',
                'canRetry' => true,
                'retryLabel' => 'Retry AI Processing',
            ],
        ];

        return view('verifikator.antrian-review', [
            'failedDocuments' => $failedDocuments,
        ]);
    }

    public function riwayatAudit()
    {
        $auditData = [
            [
                'id' => 1,
                'date' => '26 Sep 2026',
                'time' => '09:41',
                'actor' => 'SIGAP-AI',
                'actorType' => 'AI',
                'action' => 'Analisis AI selesai',
                'object' => 'INV-2026-009',
                'description' => '5 dokumen dianalisis · rekomendasi Lolos (92%)',
            ],
            [
                'id' => 2,
                'date' => '26 Sep 2026',
                'time' => '09:38',
                'actor' => 'Sistem',
                'actorType' => 'Sistem',
                'action' => 'OCR selesai',
                'object' => 'INV-2026-009',
                'description' => 'Ekstraksi teks 40 halaman · keterbacaan rata-rata 97%',
            ],
            [
                'id' => 3,
                'date' => '26 Sep 2026',
                'time' => '09:35',
                'actor' => 'Andi Pratama',
                'actorType' => 'Inovator',
                'action' => 'Pengajuan dikirim',
                'object' => 'INV-2026-009',
                'description' => 'Dashboard Command Center Penanganan Banjir',
            ],
            [
                'id' => 4,
                'date' => '26 Sep 2026',
                'time' => '08:52',
                'actor' => 'Nurul Hidayah',
                'actorType' => 'Verifikator',
                'action' => 'Minta dokumen tambahan',
                'object' => 'INV-2026-013',
                'description' => 'SK Tim Pelaksana perlu diunggah ulang dengan kualitas yang lebih baik',
            ],
            [
                'id' => 5,
                'date' => '26 Sep 2026',
                'time' => '08:47',
                'actor' => 'Sistem',
                'actorType' => 'Sistem',
                'action' => 'Pemrosesan gagal',
                'object' => 'INV-2026-015',
                'description' => 'Scan_BeritaAcara_UjiCoba.pdf — OCR gagal diproses',
            ],
            [
                'id' => 6,
                'date' => '25 Sep 2026',
                'time' => '16:20',
                'actor' => 'Dr. Hasanuddin Latief',
                'actorType' => 'Verifikator',
                'action' => 'Keputusan: Disetujui',
                'object' => 'INV-2026-010',
                'description' => 'Override rekomendasi AI keyakinan sedang (71%)',
            ],
            [
                'id' => 7,
                'date' => '25 Sep 2026',
                'time' => '14:05',
                'actor' => 'Muh. Rizal Syam',
                'actorType' => 'Admin',
                'action' => 'Parameter diperbarui',
                'object' => 'IND-03-P1',
                'description' => 'Kriteria ditambah: nilai anggaran tercantum jelas',
            ],
            [
                'id' => 8,
                'date' => '25 Sep 2026',
                'time' => '11:32',
                'actor' => 'Muh. Rizal Syam',
                'actorType' => 'Admin',
                'action' => 'Pengguna ditambahkan',
                'object' => 'U-010',
                'description' => 'Yusuf Daeng Tompo · Inovator · Kecamatan Tamalate',
            ],
            [
                'id' => 9,
                'date' => '25 Sep 2026',
                'time' => '10:14',
                'actor' => 'SIGAP-AI',
                'actorType' => 'AI',
                'action' => 'Analisis AI selesai',
                'object' => 'INV-2026-015',
                'description' => 'Keyakinan rendah (54%) · perlu pemeriksaan manual',
            ],
            [
                'id' => 10,
                'date' => '25 Sep 2026',
                'time' => '10:02',
                'actor' => 'Sitti Rahmawati',
                'actorType' => 'Inovator',
                'action' => 'Dokumen diganti',
                'object' => 'INV-2026-015',
                'description' => 'SK_Pos yandu_Digital.pdf menggantikan versi sebelumnya',
            ],
            [
                'id' => 11,
                'date' => '25 Sep 2026',
                'time' => '15:48',
                'actor' => 'Sistem',
                'actorType' => 'Sistem',
                'action' => 'Retry berhasil',
                'object' => 'INV-2026-012',
                'description' => 'Log_Chatbot_Juli_Agustus.pdf berhasil diproses',
            ],
            [
                'id' => 12,
                'date' => '25 Sep 2026',
                'time' => '09:10',
                'actor' => 'Irma Suryani',
                'actorType' => 'Verifikator',
                'action' => 'Keputusan: Ditolak',
                'object' => 'INV-2026-007',
                'description' => 'Inovasi merupakan replikasi tanpa modifikasi dari daerah lain',
            ],
            [
                'id' => 13,
                'date' => '24 Sep 2026',
                'time' => '13:25',
                'actor' => 'Muh. Rizal Syam',
                'actorType' => 'Admin',
                'action' => 'Indikator dinonaktifkan',
                'object' => 'IND-08',
                'description' => 'Kualitas Inovasi Daerah — menunggu pembaruan juknis',
            ],
            [
                'id' => 14,
                'date' => '24 Sep 2026',
                'time' => '08:40',
                'actor' => 'Nurul Hidayah',
                'actorType' => 'Verifikator',
                'action' => 'Kembalikan untuk perbaikan',
                'object' => 'INV-2026-011',
                'description' => '2 parameter perlu direvisi, batas 3 Okt 2026',
            ],
        ];

        return view('verifikator.riwayat-audit', [
            'auditData' => $auditData,
        ]);
    }



}