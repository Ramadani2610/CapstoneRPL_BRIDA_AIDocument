<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * Admin pages controller.
 *
 * FIXME: semua data di sini memakai dummy via collect() karena Models (Submission,
 * User, Indicator, IndicatorTier) belum di-merge dari branch feat/blade-backend.
 * Saat merge, ganti baris yang ditandai FIXME: dengan query Eloquent asli — nama
 * field sudah dicocokkan dengan kolom DB rekan supaya patch-nya 1-baris per method.
 */
class AdminController extends Controller
{
    public function dashboard(): View
    {
        // FIXME: $stats = [ 'total_submission' => Submission::count(), 'pending_review' => Submission::whereIn('status', [...])->count(), ... ];
        $stats = [
            'total_submission' => 42,
            'pending_review' => 8,
            'approved' => 26,
            'rejected' => 4,
            'total_user' => 12,
            'total_indikator' => 20,
        ];

        // FIXME: ambil 6 bulan terakhir dari Submission groupBy month + status
        $chart_data = [
            'labels' => ['Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov'],
            'approved' => [12, 15, 18, 22, 19, 21],
            'rejected' => [2, 3, 4, 2, 5, 3],
        ];

        // FIXME: $aktivitas_terbaru = AuditLog::latest()->take(5)->get();
        $aktivitas_terbaru = collect([
            (object) ['id' => 1, 'aksi' => 'Setujui pengajuan #SUB-2024', 'user' => 'Rian Sudaryanto', 'waktu' => Carbon::now()->subMinutes(15)],
            (object) ['id' => 2, 'aksi' => 'Tolak pengajuan #SUB-2019', 'user' => 'Rina Mariska', 'waktu' => Carbon::now()->subHours(2)],
            (object) ['id' => 3, 'aksi' => 'Minta dokumen tambahan #SUB-2021', 'user' => 'Rian Sudaryanto', 'waktu' => Carbon::now()->subHours(5)],
            (object) ['id' => 4, 'aksi' => 'Setujui pengajuan #SUB-2018', 'user' => 'Novi Yuliyanti', 'waktu' => Carbon::now()->subDay()],
            (object) ['id' => 5, 'aksi' => 'Tambah akun inovator Dinas Pariwisata', 'user' => 'Administrator', 'waktu' => Carbon::now()->subDays(2)],
        ]);

        return view('admin.dashboard', compact('stats', 'chart_data', 'aktivitas_terbaru'));
    }

    public function indikator(): View
    {
        // FIXME: $indikators = Indicator::with(['tiers' => fn ($q) => $q->where('tahun', 2026)->orderBy('bintang')])->where('tahun scope...')->orderBy('urutan')->get();
        $indikators = $this->dummyIndikators();

        return view('admin.indikator.index', compact('indikators'));
    }

    public function pengguna(): View
    {
        // FIXME: $users = User::orderBy('name')->get();
        $users = $this->dummyUsers();

        $count_per_role = [
            'admin' => $users->where('role', 'admin')->count(),
            'verifikator' => $users->where('role', 'verifikator')->count(),
            'inovator' => $users->where('role', 'inovator')->count(),
            'semua' => $users->count(),
        ];

        return view('admin.pengguna.index', compact('users', 'count_per_role'));
    }

    public function togglePenggunaStatus(int $id): RedirectResponse
    {
        // FIXME: $user = User::findOrFail($id); $user->update(['aktif' => ! $user->aktif]);
        return back()->with('success', "Status pengguna #{$id} berhasil diubah (dummy — perlu backend).");
    }

    // ============================================================
    // Dummy data helpers — isi persis dari MasterSeeder & UserSeeder rekan
    // ============================================================

    private function dummyIndikators(): Collection
    {
        return collect([
            (object) ['kode' => 21, 'nama' => 'Regulasi Inovasi Daerah', 'deskripsi' => null, 'bobot' => 3, 'wajib' => true, 'tipe_bukti' => 'pdf', 'urutan' => 1, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'SK Kepala Perangkat Daerah', 'deskripsi_bukti' => 'Salinan SK dari Kepala OPD pembuat inovasi.'],
                (object) ['bintang' => 2, 'label' => 'SK Kepala Daerah', 'deskripsi_bukti' => 'Salinan SK dari Kepala Daerah (Wali Kota).'],
                (object) ['bintang' => 3, 'label' => 'Peraturan Daerah / Peraturan Kepala Daerah', 'deskripsi_bukti' => 'Salinan Perda / Perkada yang mengatur inovasi daerah tersebut.'],
            ])],
            (object) ['kode' => 22, 'nama' => 'Ketersediaan SDM terhadap Inovasi', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf', 'urutan' => 2, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => '1 - 10 orang', 'deskripsi_bukti' => 'SK/daftar SDM 1 sampai 10 orang.'],
                (object) ['bintang' => 2, 'label' => '11 - 30 orang', 'deskripsi_bukti' => 'SK/daftar SDM 11 sampai 30 orang.'],
                (object) ['bintang' => 3, 'label' => 'Lebih dari 30 orang', 'deskripsi_bukti' => 'SK/daftar SDM lebih dari 30 orang.'],
            ])],
            (object) ['kode' => 23, 'nama' => 'Dukungan Anggaran', 'deskripsi' => null, 'bobot' => 2, 'wajib' => true, 'tipe_bukti' => 'pdf', 'urutan' => 3, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Tahun T-0 saja', 'deskripsi_bukti' => 'Dokumen anggaran tahun berjalan saja.'],
                (object) ['bintang' => 2, 'label' => 'Tahun T-1 atau T-2', 'deskripsi_bukti' => 'Dokumen anggaran tahun sebelumnya (1-2 dokumen).'],
                (object) ['bintang' => 3, 'label' => 'Tahun T-0, T-1 dan T-2', 'deskripsi_bukti' => 'Tiga dokumen anggaran — satu untuk tiap tahun.'],
            ])],
            (object) ['kode' => 24, 'nama' => 'BIMTEK Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf', 'urutan' => 4, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => '1 kali', 'deskripsi_bukti' => 'Bukti 1 kali kegiatan bimtek.'],
                (object) ['bintang' => 2, 'label' => '2 kali', 'deskripsi_bukti' => 'Bukti 2 kali kegiatan bimtek.'],
                (object) ['bintang' => 3, 'label' => '3 tahun (T-2, T-1, T-0) atau lebih dari 2 kali', 'deskripsi_bukti' => 'Bukti bimtek pada tiga tahun atau lebih dari 2 kali kegiatan.'],
            ])],
            (object) ['kode' => 25, 'nama' => 'Integrasi Program & Kegiatan dalam RKPD', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf', 'urutan' => 5, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Tahun T-1 atau T-2', 'deskripsi_bukti' => 'Dokumen RKPD salah satu dari dua tahun sebelumnya.'],
                (object) ['bintang' => 2, 'label' => 'Tahun T-1 dan T-2', 'deskripsi_bukti' => 'Dokumen RKPD dua tahun sebelumnya.'],
                (object) ['bintang' => 3, 'label' => 'Tahun T-1, T-2 dan T-0', 'deskripsi_bukti' => 'Dokumen RKPD tiga tahun (T-0, T-1, T-2).'],
            ])],
            (object) ['kode' => 26, 'nama' => 'Keterlibatan Aktor Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf', 'urutan' => 6, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => '3 aktor', 'deskripsi_bukti' => 'SK/undangan dengan 3 aktor.'],
                (object) ['bintang' => 2, 'label' => '4 aktor', 'deskripsi_bukti' => 'SK/undangan dengan 4 aktor.'],
                (object) ['bintang' => 3, 'label' => '≥ 5 aktor', 'deskripsi_bukti' => 'SK/undangan dengan 5 atau lebih aktor.'],
            ])],
            (object) ['kode' => 27, 'nama' => 'Pelaksana Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf', 'urutan' => 7, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Ada pelaksana, tanpa SK', 'deskripsi_bukti' => 'Ada pelaksana namun belum ada SK penetapan.'],
                (object) ['bintang' => 2, 'label' => 'SK Kepala Perangkat Daerah', 'deskripsi_bukti' => 'SK penetapan pelaksana dari Kepala OPD.'],
                (object) ['bintang' => 3, 'label' => 'SK Kepala Daerah', 'deskripsi_bukti' => 'SK penetapan pelaksana dari Kepala Daerah.'],
            ])],
            (object) ['kode' => 28, 'nama' => 'Jejaring Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => true, 'tipe_bukti' => 'pdf', 'urutan' => 8, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => '1 - 2 perangkat daerah', 'deskripsi_bukti' => 'SK/ST tim dengan 1-2 perangkat daerah.'],
                (object) ['bintang' => 2, 'label' => '3 - 4 perangkat daerah', 'deskripsi_bukti' => 'SK/ST tim dengan 3-4 perangkat daerah.'],
                (object) ['bintang' => 3, 'label' => '≥ 5 perangkat daerah', 'deskripsi_bukti' => 'SK/ST tim dengan 5 atau lebih perangkat daerah.'],
            ])],
            (object) ['kode' => 29, 'nama' => 'Sosialisasi Inovasi', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'foto', 'urutan' => 9, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Ada bukti sosialisasi', 'deskripsi_bukti' => 'Foto kegiatan / screenshot media sosial (JPG/JPEG/PNG).'],
            ])],
            (object) ['kode' => 30, 'nama' => 'Pedoman Teknis', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf_atau_gambar', 'urutan' => 10, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Buku cetak / manual', 'deskripsi_bukti' => 'Pedoman teknis berbentuk buku cetak atau manual.'],
                (object) ['bintang' => 2, 'label' => 'Buku elektronik', 'deskripsi_bukti' => 'Pedoman teknis berbentuk buku elektronik (PDF/e-book).'],
                (object) ['bintang' => 3, 'label' => 'Buku akses online atau video tutorial', 'deskripsi_bukti' => 'Pedoman teknis berbentuk buku akses online atau video tutorial.'],
            ])],
            (object) ['kode' => 31, 'nama' => 'Kuantitas Media', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'foto', 'urutan' => 11, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => '1 dari 4 media', 'deskripsi_bukti' => 'Bukti dari 1 media.'],
                (object) ['bintang' => 2, 'label' => '2 dari 4 media', 'deskripsi_bukti' => 'Bukti dari 2 media.'],
                (object) ['bintang' => 3, 'label' => '3 - 4 dari 4 media', 'deskripsi_bukti' => 'Bukti dari 3-4 media (manual, hotline, media sosial, online).'],
            ])],
            (object) ['kode' => 32, 'nama' => 'Kemudahan Proses', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf', 'urutan' => 12, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => '≥ 6 hari', 'deskripsi_bukti' => 'Proses layanan ≥6 hari.'],
                (object) ['bintang' => 2, 'label' => '2 - 5 hari', 'deskripsi_bukti' => 'Proses layanan 2-5 hari.'],
                (object) ['bintang' => 3, 'label' => '1 hari', 'deskripsi_bukti' => 'Proses layanan selesai dalam 1 hari.'],
            ])],
            (object) ['kode' => 33, 'nama' => 'Integrasi Layanan', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'foto', 'urutan' => 13, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Berjalan terpisah', 'deskripsi_bukti' => 'Layanan berjalan sendiri-sendiri.'],
                (object) ['bintang' => 2, 'label' => 'Satu portal layanan', 'deskripsi_bukti' => 'Layanan berada dalam satu portal.'],
                (object) ['bintang' => 3, 'label' => 'Terintegrasi dengan unit organisasi lain', 'deskripsi_bukti' => 'Layanan terintegrasi lintas unit/OPD.'],
            ])],
            (object) ['kode' => 34, 'nama' => 'Replikasi', 'deskripsi' => null, 'bobot' => 3, 'wajib' => false, 'tipe_bukti' => 'pdf', 'urutan' => 14, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Direplikasi 1 kali', 'deskripsi_bukti' => '1 dokumen PKS/MoU.'],
                (object) ['bintang' => 2, 'label' => 'Direplikasi 2 kali', 'deskripsi_bukti' => '2 dokumen PKS/MoU.'],
                (object) ['bintang' => 3, 'label' => 'Direplikasi 3 kali', 'deskripsi_bukti' => '3 dokumen PKS/MoU — satu per daerah replikasi.'],
            ])],
            (object) ['kode' => 35, 'nama' => 'Alat Kerja', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'foto', 'urutan' => 15, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Manual / non-elektronik', 'deskripsi_bukti' => 'Alat kerja manual.'],
                (object) ['bintang' => 2, 'label' => 'Perangkat elektronik', 'deskripsi_bukti' => 'Alat kerja berbasis perangkat elektronik (non-daring).'],
                (object) ['bintang' => 3, 'label' => 'Sistem online / daring', 'deskripsi_bukti' => 'Alat kerja berbasis sistem online.'],
            ])],
            (object) ['kode' => 36, 'nama' => 'Kemanfaatan', 'deskripsi' => null, 'bobot' => 3, 'wajib' => true, 'tipe_bukti' => 'pdf_atau_gambar', 'urutan' => 16, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => '1 - 100 penerima', 'deskripsi_bukti' => 'Rekap + laporan penerima manfaat 1-100 orang.'],
                (object) ['bintang' => 2, 'label' => '101 - 500 penerima', 'deskripsi_bukti' => 'Rekap + laporan penerima manfaat 101-500 orang.'],
                (object) ['bintang' => 3, 'label' => '≥ 501 penerima', 'deskripsi_bukti' => 'Rekap + laporan penerima manfaat ≥501 orang.'],
            ])],
            (object) ['kode' => 37, 'nama' => 'Kecepatan', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf', 'urutan' => 17, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => '≥ 9 bulan', 'deskripsi_bukti' => 'Waktu ≥9 bulan.'],
                (object) ['bintang' => 2, 'label' => '5 - 8 bulan', 'deskripsi_bukti' => 'Waktu 5-8 bulan.'],
                (object) ['bintang' => 3, 'label' => '1 - 4 bulan', 'deskripsi_bukti' => 'Waktu dari proposal sampai penerapan 1-4 bulan.'],
            ])],
            (object) ['kode' => 39, 'nama' => 'Penyelesaian Pengaduan', 'deskripsi' => null, 'bobot' => 1, 'wajib' => false, 'tipe_bukti' => 'pdf_atau_gambar', 'urutan' => 18, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Rasio ≤ 50%', 'deskripsi_bukti' => 'Rekap pengaduan rasio ≤50%.'],
                (object) ['bintang' => 2, 'label' => 'Rasio 51 - 90%', 'deskripsi_bukti' => 'Rekap pengaduan rasio 51-90%.'],
                (object) ['bintang' => 3, 'label' => 'Rasio ≥ 91%', 'deskripsi_bukti' => 'Rekap pengaduan dengan rasio ≥91%.'],
            ])],
            (object) ['kode' => 41, 'nama' => 'Monev', 'deskripsi' => null, 'bobot' => 2, 'wajib' => false, 'tipe_bukti' => 'pdf_atau_gambar', 'urutan' => 19, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Monev internal', 'deskripsi_bukti' => 'Monev dilakukan internal OPD.'],
                (object) ['bintang' => 2, 'label' => 'Survei kepuasan masyarakat (SKM)', 'deskripsi_bukti' => 'Monev melalui SKM.'],
                (object) ['bintang' => 3, 'label' => 'Monev eksternal', 'deskripsi_bukti' => 'Monitoring & evaluasi oleh pihak eksternal.'],
            ])],
            (object) ['kode' => 44, 'nama' => 'Kualitas Inovasi (video — di luar scope)', 'deskripsi' => null, 'bobot' => 4, 'wajib' => true, 'tipe_bukti' => 'video', 'urutan' => 20, 'tiers' => collect([
                (object) ['bintang' => 1, 'label' => 'Memenuhi 1 atau 2 unsur substansi', 'deskripsi_bukti' => 'Video dengan 1-2 unsur substansi inovasi.'],
                (object) ['bintang' => 2, 'label' => 'Memenuhi 3 atau 4 unsur substansi', 'deskripsi_bukti' => 'Video dengan 3-4 unsur substansi inovasi.'],
                (object) ['bintang' => 3, 'label' => 'Memenuhi 5 unsur substansi', 'deskripsi_bukti' => 'Video memenuhi 5 unsur: latar belakang, penjaringan ide, pemilihan ide, manfaat, dampak.'],
            ])],
        ]);
    }

    private function dummyUsers(): Collection
    {
        return collect([
            (object) ['id' => 1, 'name' => 'Administrator', 'email' => 'admin@brida.test', 'role' => 'admin', 'instansi' => 'BRIDA Kota Makassar', 'aktif' => true, 'login_terakhir' => Carbon::now()->subHours(3)],
            (object) ['id' => 2, 'name' => 'Novi Yuliyanti', 'email' => 'novi.yuliyanti@brida.test', 'role' => 'admin', 'instansi' => 'BRIDA Kota Makassar', 'aktif' => true, 'login_terakhir' => Carbon::now()->subMinutes(45)],
            (object) ['id' => 3, 'name' => 'Verifikator Satu', 'email' => 'verifikator@brida.test', 'role' => 'verifikator', 'instansi' => 'BRIDA Kota Makassar', 'aktif' => true, 'login_terakhir' => Carbon::now()->subHours(2)],
            (object) ['id' => 4, 'name' => 'Rian Sudaryanto', 'email' => 'rian.sudaryanto@brida.test', 'role' => 'verifikator', 'instansi' => 'BRIDA Kota Makassar', 'aktif' => true, 'login_terakhir' => Carbon::now()->subMinutes(20)],
            (object) ['id' => 5, 'name' => 'Rina Mariska', 'email' => 'rina.mariska@brida.test', 'role' => 'verifikator', 'instansi' => 'BRIDA Kota Makassar', 'aktif' => false, 'login_terakhir' => Carbon::now()->subDays(7)],
            (object) ['id' => 6, 'name' => 'Inovator Satu', 'email' => 'inovator@brida.test', 'role' => 'inovator', 'instansi' => 'Dinas Kominfo', 'aktif' => true, 'login_terakhir' => Carbon::now()->subHours(5)],
            (object) ['id' => 7, 'name' => 'Dewi Lestari', 'email' => 'dewi.lestari@kominfo.makassar.go.id', 'role' => 'inovator', 'instansi' => 'Dinas Kominfo', 'aktif' => true, 'login_terakhir' => Carbon::now()->subHours(8)],
            (object) ['id' => 8, 'name' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@dinkes.makassar.go.id', 'role' => 'inovator', 'instansi' => 'Dinas Kesehatan', 'aktif' => true, 'login_terakhir' => Carbon::now()->subDay()],
            (object) ['id' => 9, 'name' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@disdik.makassar.go.id', 'role' => 'inovator', 'instansi' => 'Dinas Pendidikan', 'aktif' => true, 'login_terakhir' => Carbon::now()->subDays(2)],
            (object) ['id' => 10, 'name' => 'Bagas Prakoso', 'email' => 'bagas.prakoso@bappeda.makassar.go.id', 'role' => 'inovator', 'instansi' => 'BAPPEDA', 'aktif' => true, 'login_terakhir' => Carbon::now()->subDays(4)],
            (object) ['id' => 11, 'name' => 'Yohana Natalia', 'email' => 'yohana.natalia@disdik.makassar.go.id', 'role' => 'inovator', 'instansi' => 'Dinas Pendidikan', 'aktif' => true, 'login_terakhir' => Carbon::now()->subDays(1)],
            (object) ['id' => 12, 'name' => 'Faisal Rahman', 'email' => 'faisal.rahman@dispar.makassar.go.id', 'role' => 'inovator', 'instansi' => 'Dinas Pariwisata', 'aktif' => false, 'login_terakhir' => Carbon::now()->subDays(30)],
        ]);
    }
}
