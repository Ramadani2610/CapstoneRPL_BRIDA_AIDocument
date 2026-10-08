<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifikatorController extends Controller
{
    public function riwayat()
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

        return view('verifikator.riwayat', [
            'auditData' => $auditData,
        ]);
    }
}