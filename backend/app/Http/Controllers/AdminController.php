<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        // FIXME: $ringkasan_inovasi = Submission::selectRaw('count(*) as total, sum(case when status=? then 1 else 0 end) as disetujui, ...')->first();
        $ringkasan_inovasi = [
            'total_diproses' => 342,
            'disetujui' => 214,
            'perbaikan' => 71,
            'ditolak' => 22,
            'diproses' => 35,
            'pertumbuhan' => '+18% dibanding semester lalu',
        ];

        // FIXME: ambil 6 bulan terakhir dari Submission groupBy month
        $grafik_bulanan = collect([
            (object) ['bulan' => 'Apr', 'jumlah' => 38],
            (object) ['bulan' => 'Mei', 'jumlah' => 46],
            (object) ['bulan' => 'Jun', 'jumlah' => 52],
            (object) ['bulan' => 'Jul', 'jumlah' => 61],
            (object) ['bulan' => 'Agu', 'jumlah' => 67],
            (object) ['bulan' => 'Sep', 'jumlah' => 78],
        ]);

        // FIXME: $pengguna_total = User::count(); $breakdown = User::groupBy('role')->get();
        $ringkasan_pengguna = [
            'total' => 148,
            'breakdown' => [
                ['peran' => 'Inovator', 'jumlah' => 121],
                ['peran' => 'Verifikator', 'jumlah' => 19],
                ['peran' => 'Admin', 'jumlah' => 8],
            ],
        ];

        // FIXME: Indicator::where('dalam_scope', true)->count() + IndicatorTier::count() nanti.
        $ringkasan_indikator = [
            'aktif' => 7,
            'total' => 8,
            'parameter_aktif' => 21,
        ];

        // FIXME: $aktivitas_terbaru = AuditLog::latest()->take(5)->get();
        $aktivitas_terbaru = collect([
            (object) ['waktu' => '09:41', 'tanggal' => '26 Sep', 'aktor' => 'SIGAP-AI', 'keterangan' => '5 dokumen dianalisis · rekomendasi Lolos (92%)', 'status' => 'analisis-ai'],
            (object) ['waktu' => '09:38', 'tanggal' => '26 Sep', 'aktor' => 'Sistem', 'keterangan' => 'Ekstraksi teks 40 halaman · keterbacaan rata-rata 97%', 'status' => 'ocr'],
            (object) ['waktu' => '09:35', 'tanggal' => '26 Sep', 'aktor' => 'Andi Pratama', 'keterangan' => 'Dashboard Command Center Penanganan Banjir', 'status' => 'pengajuan'],
            (object) ['waktu' => '08:52', 'tanggal' => '26 Sep', 'aktor' => 'Nurul Hidayah', 'keterangan' => 'SK Tim Pelaksana perlu diunggah ulang dengan kualitas', 'status' => 'minta-dokumen'],
            (object) ['waktu' => '08:47', 'tanggal' => '26 Sep', 'aktor' => 'Sistem', 'keterangan' => 'Scan_BeritaAcara_UjiCoba.pdf — OCR gagal (keterbacaan)', 'status' => 'gagal'],
        ]);

        $tanggal_ringkasan = '26 September 2026';

        return view('admin.dashboard', compact(
            'ringkasan_inovasi',
            'grafik_bulanan',
            'ringkasan_pengguna',
            'ringkasan_indikator',
            'aktivitas_terbaru',
            'tanggal_ringkasan',
        ));
    }

    public function indikator(): View
    {
        // FIXME: $indikators = Indicator::with(['tiers' => fn ($q) => $q->where('tahun', 2026)->orderBy('bintang')])->orderBy('urutan')->get();
        $indikators = $this->dummyIndikators()->map(function ($ind) {
            $extra = $this->indikatorExtras()[$ind->kode] ?? [];
            $ind->catatan_tambahan = $extra['catatan_tambahan'] ?? null;
            $ind->contoh_bukti_url = $extra['contoh_bukti_url'] ?? null;
            $ind->eviden_deskripsi = $extra['eviden_deskripsi'] ?? '';
            $ind->eviden_format = $extra['eviden_format'] ?? '';
            $ind->aktif = true;
            return $ind;
        });

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

        $opd_options = $this->opdOptions();
        $role_options = ['admin' => 'Administrator', 'verifikator' => 'Verifikator', 'inovator' => 'Inovator'];

        return view('admin.pengguna.index', compact('users', 'count_per_role', 'opd_options', 'role_options'));
    }

    public function storePengguna(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'instansi' => 'required|string|max:255',
            'role' => 'required|in:admin,verifikator,inovator',
            'aktif' => 'sometimes|boolean',
        ]);

        // FIXME: User::create([...$validated, 'password' => Hash::make(Str::random(16))]);
        return back()->with('success', "Pengguna {$validated['name']} berhasil ditambahkan (dummy — perlu backend).");
    }

    public function updatePengguna(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'instansi' => 'required|string|max:255',
            'role' => 'required|in:admin,verifikator,inovator',
            'aktif' => 'sometimes|boolean',
        ]);

        // FIXME: User::findOrFail($id)->update($validated);
        return back()->with('success', "Perubahan pengguna {$validated['name']} tersimpan (dummy — perlu backend).");
    }

    public function deletePengguna(int $id): RedirectResponse
    {
        // FIXME: User::findOrFail($id)->delete();
        return back()->with('success', "Pengguna #{$id} berhasil dihapus (dummy — perlu backend).");
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

    /**
     * FIXME: 4 field extra berikut BELUM ADA di DB rekan.
     * Minta rekan tambah 4 kolom via migration setelah merge:
     *   $table->text('catatan_tambahan')->nullable();
     *   $table->string('contoh_bukti_url')->nullable();
     *   $table->text('eviden_deskripsi')->nullable();
     *   $table->string('eviden_format')->nullable();
     * Nilai diambil dari frontend/src/pages/admin/indikator/data.ts (React source of truth).
     */
    private function indikatorExtras(): array
    {
        return [
            21 => [
                'eviden_deskripsi' => 'PERDA atau PERKADA atau SK Kepala Daerah atau SK Kepala Perangkat Daerah serta halaman yang memuat nama inovasi yang sah dan valid pada tahun saat penerapan.',
                'eviden_format' => 'PDF',
                'catatan_tambahan' => 'Perangkat Daerah menurut PP 18 Tahun 2016: Sekretariat Daerah, Sekretariat DPRD, Inspektorat, Dinas, Badan, Kecamatan.',
                'contoh_bukti_url' => 'https://example.com/bukti/regulasi-perda.pdf',
            ],
            22 => [
                'eviden_deskripsi' => 'SK atau Surat Tugas yang ditetapkan oleh Kepala Daerah / Kepala Perangkat Daerah.',
                'eviden_format' => 'PDF',
                'contoh_bukti_url' => 'https://example.com/bukti/sdm-sk.pdf',
            ],
            23 => [
                'eviden_deskripsi' => 'Dokumen anggaran yang memuat program dan kegiatan inovasi daerah sesuai dengan tahun anggaran.',
                'eviden_format' => 'PDF',
                'catatan_tambahan' => 'Pilih tahun anggaran yang memuat mata anggaran penerapan inovasi daerah.',
                'contoh_bukti_url' => 'https://example.com/bukti/anggaran-dpa.pdf',
            ],
            24 => [
                'eviden_deskripsi' => 'SK kegiatan / surat tugas, daftar hadir, dan undangan bimtek atau kegiatan transfer pengetahuan beserta bukti dukung frekuensi pelaksanaan bimtek.',
                'eviden_format' => 'PDF',
                'contoh_bukti_url' => 'https://example.com/bukti/bimtek-undangan.pdf',
            ],
            25 => [
                'eviden_deskripsi' => 'Upload bab, bagian, dan halaman dokumen RKPD yang memuat inovasi daerah dalam program dan kegiatan.',
                'eviden_format' => 'PDF',
                'catatan_tambahan' => 'Pilih tahun RKPD yang memuat program kegiatan inovasi daerah.',
                'contoh_bukti_url' => 'https://example.com/bukti/rkpd-integrasi.pdf',
            ],
            26 => [
                'eviden_deskripsi' => 'Surat Keputusan Perangkat Daerah atau undangan rapat dalam 2 (dua) tahun terakhir.',
                'eviden_format' => 'PDF',
                'catatan_tambahan' => 'Unsur stakeholder meliputi: Pemerintah, Pelaku Bisnis, Komunitas, Akademisi, Media Massa, dsb.',
                'contoh_bukti_url' => 'https://example.com/bukti/aktor-sk.pdf',
            ],
            27 => [
                'eviden_deskripsi' => 'SK penetapan oleh Kepala Daerah / Kepala OPD.',
                'eviden_format' => 'PDF',
                'contoh_bukti_url' => 'https://example.com/bukti/pelaksana-sk.pdf',
            ],
            28 => [
                'eviden_deskripsi' => 'SK/ST Tim Pengelola Penerapan Inovasi Daerah dalam 2 (dua) tahun terakhir.',
                'eviden_format' => 'PDF',
                'contoh_bukti_url' => 'https://example.com/bukti/jejaring-sk.pdf',
            ],
            29 => [
                'eviden_deskripsi' => 'Dokumentasi dan publikasi (foto kegiatan/seminar/display pameran inovasi atau screenshot konten pada media sosial/website atau pemberitaan media massa cetak/elektronik).',
                'eviden_format' => 'JPEG / JPG / PNG',
                'contoh_bukti_url' => 'https://example.com/bukti/sosialisasi-media.jpg',
            ],
            30 => [
                'eviden_deskripsi' => 'Dokumen manual book / buku petunjuk (PDF) atau screenshot penggunaan inovasi daerah (JPG/JPEG/PNG).',
                'eviden_format' => 'PDF / JPG / JPEG / PNG',
                'contoh_bukti_url' => 'https://example.com/bukti/pedoman-manual.pdf',
            ],
            31 => [
                'eviden_deskripsi' => 'Buku tamu dan foto pertemuan pelayanan, picscreen email/no telp layanan, picscreen media sosial yang digunakan, picscreen aplikasi (web & android/iOS).',
                'eviden_format' => 'JPG / JPEG / PNG / PDF',
                'catatan_tambahan' => 'Metode layanan: Manual (tatap muka/jemput bola), Hotline (email/telepon), Media Sosial (Instagram/Facebook/WhatsApp), Layanan Online (website/aplikasi mobile).',
                'contoh_bukti_url' => 'https://example.com/bukti/media-layanan.jpg',
            ],
            32 => [
                'eviden_deskripsi' => 'SOP pelaksanaan inovasi daerah yang memuat durasi waktu layanan.',
                'eviden_format' => 'PDF',
                'contoh_bukti_url' => 'https://example.com/bukti/sop-layanan.pdf',
            ],
            33 => [
                'eviden_deskripsi' => 'DARING: Picscreen dukungan aplikasi layanan/medsos yang terintegrasi (super apps). LURING: Dokumen program terintegrasi atau data yang sudah terintegrasi.',
                'eviden_format' => 'PDF / JPG / PNG',
                'contoh_bukti_url' => 'https://example.com/bukti/integrasi-portal.pdf',
            ],
            34 => [
                'eviden_deskripsi' => 'Dokumen PKS/MOU/Surat Pernyataan dari Pemda yang mereplikasi / dokumen replikasi lainnya.',
                'eviden_format' => 'PDF',
                'contoh_bukti_url' => 'https://example.com/bukti/replikasi-mou.pdf',
            ],
            35 => [
                'eviden_deskripsi' => 'Picscreen platform daring / foto / picscreen perangkat elektronik / No. telp / foto tatap muka dan foto layanan manual.',
                'eviden_format' => 'JPG / JPEG / PNG',
                'contoh_bukti_url' => 'https://example.com/bukti/alat-kerja.jpg',
            ],
            36 => [
                'eviden_deskripsi' => 'Berupa daftar penerima manfaat inovasi (untuk layanan luring) format PDF atau screenshot jumlah pengguna/penerima manfaat (untuk layanan daring) format JPG/JPEG/PNG.',
                'eviden_format' => 'PDF / JPG / JPEG / PNG',
                'contoh_bukti_url' => 'https://example.com/bukti/manfaat-penerima.pdf',
            ],
            37 => [
                'eviden_deskripsi' => 'Dokumen / laporan / proposal inovasi daerah yang memuat tahapan-tahapan proses dan durasi penciptaan inovasi daerah.',
                'eviden_format' => 'PDF',
                'contoh_bukti_url' => 'https://example.com/bukti/kecepatan-proposal.pdf',
            ],
            39 => [
                'eviden_deskripsi' => 'Dokumen foto kegiatan penyelesaian pengaduan / screenshot media layanan pengaduan yang disertai dengan rekapitulasi pengaduan dan persentase rasio penyelesaian pengaduan.',
                'eviden_format' => 'JPG / JPEG / PNG / PDF',
                'contoh_bukti_url' => 'https://example.com/bukti/pengaduan-rekap.pdf',
            ],
            41 => [
                'eviden_deskripsi' => 'Screenshot testimoni pengguna (JPEG/JPG/PNG) atau laporan survei kepuasan masyarakat / laporan hasil penelitian (PDF).',
                'eviden_format' => 'PDF / JPG / JPEG / PNG',
                'contoh_bukti_url' => 'https://example.com/bukti/monev-laporan.pdf',
            ],
            44 => [
                'eviden_deskripsi' => 'Video penerapan inovasi dengan durasi maksimal 5 menit (MP4/MOV) atau link Google Drive / YouTube.',
                'eviden_format' => 'MP4 / MOV / Link Drive / YouTube',
                'catatan_tambahan' => 'Unsur video inovasi daerah meliputi: (1) Latar belakang inovasi, (2) Penjaringan ide inovasi, (3) Pemilihan ide, (4) Manfaat, (5) Dampak.',
                'contoh_bukti_url' => 'https://www.youtube.com/watch?v=example-inovasi',
            ],
        ];
    }

    /** Dropdown OPD/Instansi — mirror frontend/src/pages/admin/pengguna/data.ts::OPD_OPTIONS. */
    private function opdOptions(): array
    {
        return [
            'BRIDA Kota Makassar',
            'Dinas Komunikasi dan Informatika',
            'Dinas Kesehatan',
            'Dinas Pendidikan',
            'Dinas Perhubungan',
            'Dinas Lingkungan Hidup',
            'Dinas Pariwisata',
            'Dinas Sosial',
            'BAPPEDA',
            'Kecamatan Tamalate',
            'Kecamatan Mariso',
            'Kecamatan Mamajang',
        ];
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
