// Mock data untuk Dashboard Admin.
// TODO: ganti dengan pemanggilan API saat backend siap.

export const RINGKASAN_INOVASI = {
  totalDiproses: 342,
  disetujui: 214,
  perbaikan: 71,
  ditolak: 22,
  diproses: 35,
  pertumbuhan: '+18% dibanding semester lalu',
}

export const GRAFIK_BULANAN = [
  { bulan: 'Apr', jumlah: 38 },
  { bulan: 'Mei', jumlah: 46 },
  { bulan: 'Jun', jumlah: 52 },
  { bulan: 'Jul', jumlah: 61 },
  { bulan: 'Agu', jumlah: 67 },
  { bulan: 'Sep', jumlah: 78 },
]

export const RINGKASAN_PENGGUNA = {
  total: 148,
  breakdown: [
    { peran: 'Inovator', jumlah: 121 },
    { peran: 'Verifikator', jumlah: 19 },
    { peran: 'Admin', jumlah: 8 },
  ],
}

export const RINGKASAN_INDIKATOR = {
  aktif: 7,
  total: 8,
  parameterAktif: 21,
}

export interface AktivitasItem {
  waktu: string
  tanggal: string
  aktor: string
  keterangan: string
  status: 'analisis-ai' | 'ocr' | 'pengajuan' | 'minta-dokumen' | 'gagal'
}

export const AKTIVITAS_TERBARU: AktivitasItem[] = [
  {
    waktu: '09:41',
    tanggal: '26 Sep',
    aktor: 'SIGAP-AI',
    keterangan: '5 dokumen dianalisis · rekomendasi Lolos (92%)',
    status: 'analisis-ai',
  },
  {
    waktu: '09:38',
    tanggal: '26 Sep',
    aktor: 'Sistem',
    keterangan: 'Ekstraksi teks 40 halaman · keterbacaan rata-rata 97%',
    status: 'ocr',
  },
  {
    waktu: '09:35',
    tanggal: '26 Sep',
    aktor: 'Andi Pratama',
    keterangan: 'Dashboard Command Center Penanganan Banjir',
    status: 'pengajuan',
  },
  {
    waktu: '08:52',
    tanggal: '26 Sep',
    aktor: 'Nurul Hidayah',
    keterangan: 'SK Tim Pelaksana perlu diunggah ulang dengan kualitas',
    status: 'minta-dokumen',
  },
  {
    waktu: '08:47',
    tanggal: '26 Sep',
    aktor: 'Sistem',
    keterangan: 'Scan_BeritaAcara_UjiCoba.pdf — OCR gagal (keterbacaan)',
    status: 'gagal',
  },
]

export const TANGGAL_RINGKASAN = '26 September 2026'