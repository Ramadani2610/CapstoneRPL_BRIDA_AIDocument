// Data indikator inovasi daerah mengacu pada Panduan Inovasi BRIDA Makassar.
// Sumber: Kemendagri (Indeks Inovasi Daerah / IID 2026).
// Total 20 indikator dengan skoring maksimal 111 poin.
// TODO: ganti dengan pemanggilan API saat backend siap.

export interface OpsiPenilaian {
  bintang: 1 | 2 | 3
  deskripsi: string
}

export interface Eviden {
  deskripsi: string
  formatFile: string
}

export interface Indikator {
  id: string
  kode: string
  nama: string
  deskripsi: string
  opsiPenilaian: OpsiPenilaian[]
  catatanTambahan?: string
  bobot: number
  mandatory: boolean
  eviden: Eviden
  contohBuktiUrl?: string
  aktif: boolean
}

export const INDIKATORS: Indikator[] = [
  {
    id: 'ind-001',
    kode: 'IND-01',
    nama: 'Regulasi Inovasi Daerah',
    deskripsi:
      'Regulasi yang menetapkan nama-nama inovasi daerah yang menjadi landasan operasional penerapan inovasi daerah.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Peraturan Kepala Daerah / Peraturan Daerah' },
      { bintang: 2, deskripsi: 'SK Kepala Daerah' },
      { bintang: 1, deskripsi: 'SK Kepala Perangkat Daerah' },
    ],
    catatanTambahan:
      'Perangkat Daerah menurut PP 18 Tahun 2016: Sekretariat Daerah, Sekretariat DPRD, Inspektorat, Dinas, Badan, Kecamatan.',
    bobot: 3,
    mandatory: true,
    eviden: {
      deskripsi:
        'PERDA atau PERKADA atau SK Kepala Daerah atau SK Kepala Perangkat Daerah serta halaman yang memuat nama inovasi yang sah dan valid pada tahun saat penerapan.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/regulasi-perda.pdf',
    aktif: true,
  },
  {
    id: 'ind-002',
    kode: 'IND-02',
    nama: 'Ketersediaan SDM terhadap Inovasi Daerah',
    deskripsi: 'Jumlah SDM yang mengelola inovasi (tahun terakhir).',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Lebih dari 30 orang' },
      { bintang: 2, deskripsi: '11 - 30 orang' },
      { bintang: 1, deskripsi: '1 - 10 orang' },
    ],
    bobot: 2,
    mandatory: false,
    eviden: {
      deskripsi: 'SK atau Surat Tugas yang ditetapkan oleh Kepala Daerah / Kepala Perangkat Daerah.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/sdm-sk.pdf',
    aktif: true,
  },
  {
    id: 'ind-003',
    kode: 'IND-03',
    nama: 'Dukungan Anggaran',
    deskripsi:
      'Anggaran inovasi daerah dalam APBD dengan tahapan penerapan (penyediaan sarana prasarana, SDM, layanan, bimtek).',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Anggaran dialokasikan pada kegiatan penerapan inovasi di T-0, T-1 dan T-2' },
      { bintang: 2, deskripsi: 'Anggaran dialokasikan pada kegiatan penerapan inovasi di T-1 atau T-2' },
      { bintang: 1, deskripsi: 'Anggaran dialokasikan pada kegiatan penerapan inovasi di T-0 (tahun berjalan)' },
    ],
    catatanTambahan: 'Pilih tahun anggaran yang memuat mata anggaran penerapan inovasi daerah.',
    bobot: 2,
    mandatory: true,
    eviden: {
      deskripsi: 'Dokumen anggaran yang memuat program dan kegiatan inovasi daerah sesuai dengan tahun anggaran.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/anggaran-dpa.pdf',
    aktif: true,
  },
  {
    id: 'ind-004',
    kode: 'IND-04',
    nama: 'Bimtek Inovasi',
    deskripsi: 'Peningkatan kapasitas dan kompetensi pelaksana inovasi daerah.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Dalam 2 tahun terakhir pernah lebih dari 2 kali bimtek (bimtek/training/TOT)' },
      { bintang: 2, deskripsi: 'Dalam 2 tahun terakhir pernah 2 kali bimtek (bimtek/training/TOT)' },
      { bintang: 1, deskripsi: 'Dalam 2 tahun terakhir pernah 1 kali kegiatan transfer pengetahuan (bimtek, sharing, FGD)' },
    ],
    bobot: 1,
    mandatory: false,
    eviden: {
      deskripsi:
        'SK kegiatan / surat tugas, daftar hadir, dan undangan bimtek atau kegiatan transfer pengetahuan beserta bukti dukung frekuensi pelaksanaan bimtek.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/bimtek-undangan.pdf',
    aktif: true,
  },
  {
    id: 'ind-005',
    kode: 'IND-05',
    nama: 'Integrasi Program dan Kegiatan Inovasi dalam RKPD',
    deskripsi: 'Inovasi perangkat daerah telah dituangkan dalam program pembangunan daerah.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Pemerintah daerah sudah menuangkan program inovasi daerah dalam RKPD T-1, T-2 dan T0' },
      { bintang: 2, deskripsi: 'Pemerintah daerah sudah menuangkan program inovasi daerah dalam RKPD T-1 dan T-2' },
      { bintang: 1, deskripsi: 'Pemerintah daerah sudah menuangkan program inovasi daerah dalam RKPD T-1 atau T-2' },
    ],
    catatanTambahan: 'Pilih tahun RKPD yang memuat program kegiatan inovasi daerah.',
    bobot: 2,
    mandatory: false,
    eviden: {
      deskripsi: 'Upload bab, bagian, dan halaman dokumen RKPD yang memuat inovasi daerah dalam program dan kegiatan.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/rkpd-integrasi.pdf',
    aktif: true,
  },
  {
    id: 'ind-006',
    kode: 'IND-06',
    nama: 'Keterlibatan Aktor Inovasi',
    deskripsi: 'Keikutsertaan unsur stakeholder dalam pelaksanaan inovasi daerah (T-1 dan T-2).',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Inovasi melibatkan lebih dari 5 aktor' },
      { bintang: 2, deskripsi: 'Inovasi melibatkan 4 aktor' },
      { bintang: 1, deskripsi: 'Inovasi melibatkan 3 aktor' },
    ],
    catatanTambahan: 'Unsur stakeholder meliputi: Pemerintah, Pelaku Bisnis, Komunitas, Akademisi, Media Massa, dsb.',
    bobot: 1,
    mandatory: false,
    eviden: {
      deskripsi: 'Surat Keputusan Perangkat Daerah atau undangan rapat dalam 2 (dua) tahun terakhir.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/aktor-sk.pdf',
    aktif: true,
  },
  {
    id: 'ind-007',
    kode: 'IND-07',
    nama: 'Pelaksana Inovasi Daerah',
    deskripsi: 'Penetapan tim pelaksana inovasi daerah.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Ada pelaksana dan ditetapkan dengan SK Kepala Daerah' },
      { bintang: 2, deskripsi: 'Ada pelaksana dan ditetapkan dengan SK Kepala Perangkat Daerah' },
      { bintang: 1, deskripsi: 'Ada pelaksana namun tidak ditetapkan dengan SK Kepala Perangkat Daerah' },
    ],
    bobot: 1,
    mandatory: false,
    eviden: {
      deskripsi: 'SK penetapan oleh Kepala Daerah / Kepala OPD.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/pelaksana-sk.pdf',
    aktif: true,
  },
  {
    id: 'ind-008',
    kode: 'IND-08',
    nama: 'Jejaring Inovasi Daerah',
    deskripsi: 'Jumlah perangkat daerah yang terlibat dalam penerapan inovasi (dalam 2 tahun terakhir).',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Inovasi melibatkan 5 atau lebih perangkat daerah' },
      { bintang: 2, deskripsi: 'Inovasi melibatkan 3-4 perangkat daerah' },
      { bintang: 1, deskripsi: 'Inovasi melibatkan 1-2 perangkat daerah atau lebih' },
    ],
    bobot: 1,
    mandatory: true,
    eviden: {
      deskripsi: 'SK/ST Tim Pengelola Penerapan Inovasi Daerah dalam 2 (dua) tahun terakhir.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/jejaring-sk.pdf',
    aktif: true,
  },
  {
    id: 'ind-009',
    kode: 'IND-09',
    nama: 'Sosialisasi Inovasi Daerah',
    deskripsi: 'Penyebarluasan informasi kebijakan inovasi daerah.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Media berita' },
      { bintang: 2, deskripsi: 'Konten melalui media sosial' },
      { bintang: 1, deskripsi: 'Foto kegiatan yang berlatar belakang spanduk kegiatan inovasi yang diterapkan' },
    ],
    bobot: 1,
    mandatory: false,
    eviden: {
      deskripsi:
        'Dokumentasi dan publikasi (foto kegiatan/seminar/display pameran inovasi atau screenshot konten pada media sosial/website atau pemberitaan media massa cetak/elektronik).',
      formatFile: 'JPEG / JPG / PNG',
    },
    contohBuktiUrl: 'https://example.com/bukti/sosialisasi-media.jpg',
    aktif: true,
  },
  {
    id: 'ind-010',
    kode: 'IND-10',
    nama: 'Pedoman Teknis',
    deskripsi: 'Ketentuan dasar penggunaan inovasi daerah berupa buku petunjuk / manual book.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Telah terdapat pedoman teknis berupa buku yang dapat diakses secara online' },
      { bintang: 2, deskripsi: 'Telah terdapat pedoman teknis berupa buku dalam bentuk elektronik' },
      { bintang: 1, deskripsi: 'Telah terdapat pedoman teknis berupa buku manual / cetak' },
    ],
    bobot: 1,
    mandatory: false,
    eviden: {
      deskripsi: 'Dokumen manual book / buku petunjuk (PDF) atau screenshot penggunaan inovasi daerah (JPG/JPEG/PNG).',
      formatFile: 'PDF / JPG / JPEG / PNG',
    },
    contohBuktiUrl: 'https://example.com/bukti/pedoman-manual.pdf',
    aktif: true,
  },
  {
    id: 'ind-011',
    kode: 'IND-11',
    nama: 'Kuantitas / Jumlah Media Informasi Layanan',
    deskripsi: 'Jumlah media yang digunakan dalam penerapan inovasi.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Layanan melalui 3 media atau lebih (3/4 atau 4/4)' },
      { bintang: 2, deskripsi: 'Layanan melalui 2 dari 4 media (2/4)' },
      { bintang: 1, deskripsi: 'Layanan melalui 1 dari 4 media (1/4)' },
    ],
    catatanTambahan:
      'Metode layanan: Manual (tatap muka/jemput bola), Hotline (email/telepon), Media Sosial (Instagram/Facebook/WhatsApp), Layanan Online (website/aplikasi mobile).',
    bobot: 1,
    mandatory: false,
    eviden: {
      deskripsi:
        'Buku tamu dan foto pertemuan pelayanan, picscreen email/no telp layanan, picscreen media sosial yang digunakan, picscreen aplikasi (web & android/iOS).',
      formatFile: 'JPG / JPEG / PNG / PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/media-layanan.jpg',
    aktif: true,
  },
  {
    id: 'ind-012',
    kode: 'IND-12',
    nama: 'Kemudahan Proses Inovasi yang Dihasilkan',
    deskripsi: 'Indikator ini ditujukan untuk mengukur kecepatan layanan yang diperoleh oleh pengguna.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Hasil inovasi diperoleh dalam waktu 1 hari' },
      { bintang: 2, deskripsi: 'Hasil inovasi diperoleh dalam waktu 2-5 hari' },
      { bintang: 1, deskripsi: 'Hasil inovasi diperoleh dalam waktu 6 hari atau lebih' },
    ],
    bobot: 2,
    mandatory: false,
    eviden: {
      deskripsi: 'SOP pelaksanaan inovasi daerah yang memuat durasi waktu layanan.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/sop-layanan.pdf',
    aktif: true,
  },
  {
    id: 'ind-013',
    kode: 'IND-13',
    nama: 'Integrasi Layanan',
    deskripsi:
      'Inovasi dibangun secara terpadu, mengedepankan prinsip-prinsip integrasi fungsi layanan dan interoperabilitas layanan.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'DARING: Ada dukungan melalui web aplikasi/mobile yang layanan sudah terintegrasi dengan unit organisasi lain | LURING: Layanan telah terintegrasi dengan layanan lain pada unit organisasi lain atau dalam lebih dari satu urusan' },
      { bintang: 2, deskripsi: 'DARING: Ada dukungan melalui informasi website, sosial media, web aplikasi/mobile yang telah terintegrasi dalam satu portal pada unit organisasi bersangkutan | LURING: Layanan telah terintegrasi dengan layanan lain pada program atau kegiatan lain pada satu unit organisasi atau dalam satu urusan' },
      { bintang: 1, deskripsi: 'DARING: Ada dukungan melalui informasi website/sosial media/web aplikasi/mobile yang berjalan terpisah | LURING: Layanan inovasi berjalan secara tersendiri (mandiri/independen)' },
    ],
    bobot: 2,
    mandatory: false,
    eviden: {
      deskripsi:
        'DARING: Picscreen dukungan aplikasi layanan/medsos yang terintegrasi (super apps). LURING: Dokumen program terintegrasi atau data yang sudah terintegrasi.',
      formatFile: 'PDF / JPG / PNG',
    },
    contohBuktiUrl: 'https://example.com/bukti/integrasi-portal.pdf',
    aktif: true,
  },
  {
    id: 'ind-014',
    kode: 'IND-14',
    nama: 'Replikasi',
    deskripsi: 'Inovasi daerah telah direplikasi oleh pemerintah daerah lain.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Pernah 3 kali direplikasi di daerah lain yang berbeda' },
      { bintang: 2, deskripsi: 'Pernah 2 kali direplikasi di daerah lain yang berbeda' },
      { bintang: 1, deskripsi: 'Pernah 1 kali direplikasi di daerah lain' },
    ],
    bobot: 3,
    mandatory: false,
    eviden: {
      deskripsi: 'Dokumen PKS/MOU/Surat Pernyataan dari Pemda yang mereplikasi / dokumen replikasi lainnya.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/replikasi-mou.pdf',
    aktif: true,
  },
  {
    id: 'ind-015',
    kode: 'IND-15',
    nama: 'Alat Kerja',
    deskripsi: 'Penggunaan IT dalam inovasi yang diterapkan.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Pelaksanaan kerja sudah didukung sistem informasi online/daring (contoh: pemanfaatan platform media sosial, AI, IoT, super-app)' },
      { bintang: 2, deskripsi: 'Pelaksanaan kerja didukung dengan perangkat elektronik (contoh: mesin EDC, telp)' },
      { bintang: 1, deskripsi: 'Pelaksanaan kerja secara manual/non elektronik (contoh: tatap muka/jemput bola/noken)' },
    ],
    bobot: 2,
    mandatory: false,
    eviden: {
      deskripsi: 'Picscreen platform daring / foto / picscreen perangkat elektronik / No. telp / foto tatap muka dan foto layanan manual.',
      formatFile: 'JPG / JPEG / PNG',
    },
    contohBuktiUrl: 'https://example.com/bukti/alat-kerja.jpg',
    aktif: true,
  },
  {
    id: 'ind-016',
    kode: 'IND-16',
    nama: 'Kemanfaatan Inovasi Daerah',
    deskripsi: 'Jumlah pengguna atau penerima manfaat inovasi daerah.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Jumlah pengguna/penerima manfaat 201 orang keatas atau % peningkatan jumlah unit 50% atau efisiensi belanja 20,1-30% atau efisiensi belanja ≥100% atau jumlah produk 201 orang/lebih' },
      { bintang: 2, deskripsi: 'Jumlah pengguna/penerima manfaat 101-200 orang atau % peningkatan jumlah unit 20,1-50% atau efisiensi belanja 10,1-20% atau peningkatan pendapatan 50-99,99% atau jumlah produk 101-200 orang' },
      { bintang: 1, deskripsi: 'Jumlah pengguna/penerima manfaat 1-100 orang atau % peningkatan jumlah unit 5-20% atau efisiensi belanja 0,1-10% atau peningkatan pendapatan 0,1-49,99% atau jumlah produk 1-100 orang' },
    ],
    bobot: 3,
    mandatory: true,
    eviden: {
      deskripsi:
        'Berupa daftar penerima manfaat inovasi (untuk layanan luring) format PDF atau screenshot jumlah pengguna/penerima manfaat (untuk layanan daring) format JPG/JPEG/PNG.',
      formatFile: 'PDF / JPG / JPEG / PNG',
    },
    contohBuktiUrl: 'https://example.com/bukti/manfaat-penerima.pdf',
    aktif: true,
  },
  {
    id: 'ind-017',
    kode: 'IND-17',
    nama: 'Kecepatan Penciptaan Inovasi Daerah',
    deskripsi: 'Rentang waktu yang digunakan untuk menciptakan inovasi daerah.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Inovasi dapat diciptakan dalam waktu 1-4 bulan' },
      { bintang: 2, deskripsi: 'Inovasi dapat diciptakan dalam waktu 5-8 bulan' },
      { bintang: 1, deskripsi: 'Inovasi dapat diciptakan dalam waktu 9 bulan keatas' },
    ],
    bobot: 2,
    mandatory: false,
    eviden: {
      deskripsi: 'Dokumen / laporan / proposal inovasi daerah yang memuat tahapan-tahapan proses dan durasi penciptaan inovasi daerah.',
      formatFile: 'PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/kecepatan-proposal.pdf',
    aktif: true,
  },
  {
    id: 'ind-018',
    kode: 'IND-18',
    nama: 'Penyelesaian Layanan Pengaduan',
    deskripsi:
      'Rasio pengaduan yang tertangani dalam tahun terakhir, meliputi keluhan, kritik konstruktif, saran, dan pengaduan lainnya terkait layanan inovasi.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: '≥ 86%' },
      { bintang: 2, deskripsi: '51% s.d. 85%' },
      { bintang: 1, deskripsi: '≤ 50% atau tidak ada pengaduan' },
    ],
    bobot: 1,
    mandatory: false,
    eviden: {
      deskripsi:
        'Dokumen foto kegiatan penyelesaian pengaduan / screenshot media layanan pengaduan yang disertai dengan rekapitulasi pengaduan dan persentase rasio penyelesaian pengaduan.',
      formatFile: 'JPG / JPEG / PNG / PDF',
    },
    contohBuktiUrl: 'https://example.com/bukti/pengaduan-rekap.pdf',
    aktif: true,
  },
  {
    id: 'ind-019',
    kode: 'IND-19',
    nama: 'Monitoring dan Evaluasi Inovasi Daerah',
    deskripsi: 'Kepuasan pelaksanaan penggunaan inovasi daerah.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Hasil laporan monev eksternal berdasarkan hasil penelitian/kajian/analisis' },
      { bintang: 2, deskripsi: 'Hasil pengukuran kepuasan pengguna dari evaluasi Survei Kepuasan Masyarakat' },
      { bintang: 1, deskripsi: 'Hasil laporan monev internal Perangkat Daerah' },
    ],
    bobot: 2,
    mandatory: false,
    eviden: {
      deskripsi: 'Screenshot testimoni pengguna (JPEG/JPG/PNG) atau laporan survei kepuasan masyarakat / laporan hasil penelitian (PDF).',
      formatFile: 'PDF / JPG / JPEG / PNG',
    },
    contohBuktiUrl: 'https://example.com/bukti/monev-laporan.pdf',
    aktif: true,
  },
  {
    id: 'ind-020',
    kode: 'IND-20',
    nama: 'Kualitas Inovasi Daerah (Video)',
    deskripsi:
      'Kualitas inovasi daerah dapat dibuktikan dengan video penerapan inovasi daerah. Indikator ini diperiksa secara manual oleh verifikator.',
    opsiPenilaian: [
      { bintang: 3, deskripsi: 'Memenuhi 5 unsur substansi' },
      { bintang: 2, deskripsi: 'Memenuhi 3 atau 4 unsur substansi' },
      { bintang: 1, deskripsi: 'Memenuhi 1 atau 2 unsur substansi' },
    ],
    catatanTambahan:
      'Unsur video inovasi daerah meliputi: (1) Latar belakang inovasi, (2) Penjaringan ide inovasi, (3) Pemilihan ide, (4) Manfaat, (5) Dampak.',
    bobot: 4,
    mandatory: true,
    eviden: {
      deskripsi: 'Video penerapan inovasi dengan durasi maksimal 5 menit (MP4/MOV) atau link Google Drive / YouTube.',
      formatFile: 'MP4 / MOV / Link Drive / YouTube',
    },
    contohBuktiUrl: 'https://www.youtube.com/watch?v=example-inovasi',
    aktif: true,
  },
]