// Mock data untuk halaman Kelola Indikator & Parameter.
// TODO: ganti dengan pemanggilan API saat backend siap.

export type IndikatorKategori =
  | 'Satuan Pemerintah Daerah'
  | 'Sumber Daya Manusia'
  | 'Anggaran'
  | 'Teknologi Informasi'
  | 'Pelayanan Publik'

export interface ContohDokumen {
  nama: string
  // Catatan: untuk MVP ini, file disimpan sebagai nama saja.
  // Backend nanti akan handle upload sesungguhnya.
}

export interface Parameter {
  id: string
  kode: string
  nama: string
  deskripsi: string
  kriteria: string[]
  contohBenar: ContohDokumen | null
  contohSalah: ContohDokumen | null
}

export interface Indikator {
  id: string
  kode: string
  nama: string
  kategori: IndikatorKategori
  deskripsi: string
  aktif: boolean
  parameter: Parameter[]
}

export const KATEGORI_OPTIONS: IndikatorKategori[] = [
  'Satuan Pemerintah Daerah',
  'Sumber Daya Manusia',
  'Anggaran',
  'Teknologi Informasi',
  'Pelayanan Publik',
]

export const INDIKATORS: Indikator[] = [
  {
    id: 'ind-001',
    kode: 'IND-01',
    nama: 'Regulasi Inovasi Daerah',
    kategori: 'Satuan Pemerintah Daerah',
    deskripsi:
      'Regulasi yang menetapkan sistem, prosedur, dan tata cara penerapan inovasi daerah.',
    aktif: true,
    parameter: [
      {
        id: 'p-001',
        kode: 'P1',
        nama: 'Peraturan Kepala Daerah / Peraturan Daerah',
        deskripsi: 'Dokumen Perwali/Perda yang telah diundangkan',
        kriteria: [
          'Dokumen Perwali/Perda yang telah diundangkan',
          'Memuat nama inovasi secara eksplisit',
          'Tercatat dalam Berita Daerah Kota Makassar',
        ],
        contohBenar: { nama: 'Contoh_Perwali_Inovasi.pdf' },
        contohSalah: { nama: 'Contoh_Draft_Perwali.pdf' },
      },
      {
        id: 'p-002',
        kode: 'P2',
        nama: 'SK Kepala Perangkat Daerah',
        deskripsi: 'SK memuat nomor dan tanggal penetapan',
        kriteria: [
          'SK memuat nomor dan tanggal penetapan',
          'Ditandatangani Kepala Perangkat Daerah beserta cap dinas',
          'Diterbitkan paling lama 2 tahun terakhir',
        ],
        contohBenar: { nama: 'Contoh_SK_Perangkat_Daerah.pdf' },
        contohSalah: { nama: 'Contoh_SK_Kedaluwarsa.pdf' },
      },
      {
        id: 'p-003',
        kode: 'P3',
        nama: 'Nota Dinas / Surat Edaran',
        deskripsi: 'Dokumen pendukung internal',
        kriteria: [
          'Ditandatangani pejabat minimal eselon III',
          'Menyebutkan nama inovasi dan pelaksana',
        ],
        contohBenar: null,
        contohSalah: null,
      },
    ],
  },
  {
    id: 'ind-002',
    kode: 'IND-02',
    nama: 'Ketersediaan SDM terhadap Inovasi Daerah',
    kategori: 'Sumber Daya Manusia',
    deskripsi:
      'Ketersediaan sumber daya manusia yang ditugaskan dalam pelaksanaan inovasi daerah.',
    aktif: true,
    parameter: [
      {
        id: 'p-004',
        kode: 'P1',
        nama: 'SK Tim Pelaksana Inovasi',
        deskripsi: 'SK yang memuat susunan tim pelaksana',
        kriteria: ['Memuat daftar nama dan jabatan pelaksana', 'Ditandatangani Kepala Daerah atau Kepala OPD'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-005',
        kode: 'P2',
        nama: 'Sertifikat Pelatihan',
        deskripsi: 'Bukti peningkatan kapasitas SDM',
        kriteria: ['Dikeluarkan oleh lembaga pelatihan resmi', 'Relevan dengan tema inovasi'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-006',
        kode: 'P3',
        nama: 'Surat Penugasan',
        deskripsi: 'Surat penugasan khusus pelaksanaan inovasi',
        kriteria: ['Memuat lingkup tugas yang jelas', 'Masa berlaku tercantum'],
        contohBenar: null,
        contohSalah: null,
      },
    ],
  },
  {
    id: 'ind-003',
    kode: 'IND-03',
    nama: 'Dukungan Anggaran',
    kategori: 'Anggaran',
    deskripsi: 'Alokasi anggaran yang disediakan untuk mendukung pelaksanaan inovasi.',
    aktif: true,
    parameter: [
      {
        id: 'p-007',
        kode: 'P1',
        nama: 'DPA/RKA OPD',
        deskripsi: 'Dokumen pelaksanaan anggaran',
        kriteria: ['Mencantumkan nilai anggaran untuk inovasi', 'Disahkan oleh pejabat berwenang'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-008',
        kode: 'P2',
        nama: 'Laporan Realisasi Anggaran',
        deskripsi: 'Bukti pencairan dan penggunaan anggaran',
        kriteria: ['Memuat rincian penggunaan', 'Disertai bukti transaksi'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-009',
        kode: 'P3',
        nama: 'Nota Dinas Pengajuan Anggaran',
        deskripsi: 'Dokumen pengajuan anggaran inovasi',
        kriteria: ['Memuat rincian kebutuhan', 'Ditandatangani pejabat terkait'],
        contohBenar: null,
        contohSalah: null,
      },
    ],
  },
  {
    id: 'ind-004',
    kode: 'IND-04',
    nama: 'Penggunaan Teknologi Informasi',
    kategori: 'Teknologi Informasi',
    deskripsi: 'Pemanfaatan teknologi informasi dalam pelaksanaan inovasi daerah.',
    aktif: true,
    parameter: [
      {
        id: 'p-010',
        kode: 'P1',
        nama: 'Dokumentasi Sistem/Aplikasi',
        deskripsi: 'Dokumentasi teknis sistem yang digunakan',
        kriteria: ['Mencakup arsitektur sistem', 'Memuat panduan penggunaan'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-011',
        kode: 'P2',
        nama: 'Screenshot Antarmuka',
        deskripsi: 'Tampilan antarmuka pengguna',
        kriteria: ['Jelas dan mudah dibaca', 'Menampilkan fitur utama'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-012',
        kode: 'P3',
        nama: 'Log Aktivitas Sistem',
        deskripsi: 'Rekaman aktivitas penggunaan sistem',
        kriteria: ['Periode minimal 3 bulan', 'Menunjukkan utilisasi aktif'],
        contohBenar: null,
        contohSalah: null,
      },
    ],
  },
  {
    id: 'ind-005',
    kode: 'IND-05',
    nama: 'Bimtek Inovasi',
    kategori: 'Sumber Daya Manusia',
    deskripsi: 'Bimbingan teknis yang diberikan terkait inovasi daerah.',
    aktif: true,
    parameter: [
      {
        id: 'p-013',
        kode: 'P1',
        nama: 'Undangan Bimtek',
        deskripsi: 'Surat undangan kegiatan bimtek',
        kriteria: ['Memuat agenda kegiatan', 'Mencantumkan narasumber'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-014',
        kode: 'P2',
        nama: 'Daftar Hadir Peserta',
        deskripsi: 'Rekaman kehadiran peserta bimtek',
        kriteria: ['Ditandatangani peserta', 'Menyebutkan tanggal dan lokasi'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-015',
        kode: 'P3',
        nama: 'Materi Bimtek',
        deskripsi: 'Materi yang disampaikan dalam bimtek',
        kriteria: ['Relevan dengan tema inovasi', 'Disusun sistematis'],
        contohBenar: null,
        contohSalah: null,
      },
    ],
  },
  {
    id: 'ind-006',
    kode: 'IND-06',
    nama: 'Kecepatan Penciptaan Inovasi',
    kategori: 'Pelayanan Publik',
    deskripsi: 'Rentang waktu dari gagasan hingga penerapan inovasi.',
    aktif: true,
    parameter: [
      {
        id: 'p-016',
        kode: 'P1',
        nama: 'Timeline Pengembangan',
        deskripsi: 'Jadwal pengembangan inovasi',
        kriteria: ['Memuat tahapan jelas', 'Tanggal milestone tercantum'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-017',
        kode: 'P2',
        nama: 'Berita Acara Serah Terima',
        deskripsi: 'BAST hasil inovasi',
        kriteria: ['Ditandatangani kedua pihak', 'Tanggal serah terima jelas'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-018',
        kode: 'P3',
        nama: 'Laporan Progres',
        deskripsi: 'Laporan progres pengembangan',
        kriteria: ['Dibuat berkala', 'Memuat capaian konkret'],
        contohBenar: null,
        contohSalah: null,
      },
    ],
  },
  {
    id: 'ind-007',
    kode: 'IND-07',
    nama: 'Kemanfaatan Inovasi',
    kategori: 'Pelayanan Publik',
    deskripsi: 'Dampak dan manfaat inovasi bagi masyarakat.',
    aktif: true,
    parameter: [
      {
        id: 'p-019',
        kode: 'P1',
        nama: 'Survei Kepuasan Masyarakat',
        deskripsi: 'Hasil survei penerima manfaat',
        kriteria: ['Metodologi survei jelas', 'Sampel representatif'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-020',
        kode: 'P2',
        nama: 'Testimoni Pengguna',
        deskripsi: 'Testimoni dari penerima manfaat',
        kriteria: ['Diverifikasi keasliannya', 'Minimal 10 testimoni'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-021',
        kode: 'P3',
        nama: 'Data Pengguna Aktif',
        deskripsi: 'Statistik pengguna inovasi',
        kriteria: ['Tren pertumbuhan positif', 'Periode minimal 6 bulan'],
        contohBenar: null,
        contohSalah: null,
      },
    ],
  },
  {
    id: 'ind-008',
    kode: 'IND-08',
    nama: 'Kualitas Inovasi Daerah',
    kategori: 'Pelayanan Publik',
    deskripsi: 'Tingkat kualitas inovasi berdasarkan standar yang ditetapkan.',
    aktif: false,
    parameter: [
      {
        id: 'p-022',
        kode: 'P1',
        nama: 'Hasil Evaluasi Mutu',
        deskripsi: 'Hasil evaluasi mutu inovasi',
        kriteria: ['Dilakukan oleh tim independen', 'Mengacu standar nasional'],
        contohBenar: null,
        contohSalah: null,
      },
      {
        id: 'p-023',
        kode: 'P2',
        nama: 'Sertifikat Akreditasi',
        deskripsi: 'Sertifikat akreditasi dari lembaga berwenang',
        kriteria: ['Masih berlaku', 'Dari lembaga terakreditasi'],
        contohBenar: null,
        contohSalah: null,
      },
    ],
  },
]