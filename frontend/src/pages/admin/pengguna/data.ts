// Mock data untuk halaman Kelola Pengguna.
// TODO: ganti dengan pemanggilan API saat backend siap.

export type UserRole = 'Inovator' | 'Verifikator' | 'Administrator'

export interface User {
  id: string
  nama: string
  email: string
  opd: string
  peran: UserRole
  aktif: boolean
  loginTerakhir: string | null
}

export const USERS: User[] = [
  {
    id: 'u-001',
    nama: 'Andi Pratama',
    email: 'andi.pratama@makassarkota.go.id',
    opd: 'Dinas Komunikasi dan Informatika',
    peran: 'Inovator',
    aktif: true,
    loginTerakhir: '26 Sep 2026, 09:12',
  },
  {
    id: 'u-002',
    nama: 'Nurul Hidayah',
    email: 'nurul.hidayah@makassarkota.go.id',
    opd: 'BRIDA Kota Makassar',
    peran: 'Verifikator',
    aktif: true,
    loginTerakhir: '26 Sep 2026, 08:30',
  },
  {
    id: 'u-003',
    nama: 'Muh. Rizal Syam',
    email: 'rizal.syam@makassarkota.go.id',
    opd: 'BRIDA Kota Makassar',
    peran: 'Administrator',
    aktif: true,
    loginTerakhir: '26 Sep 2026, 07:55',
  },
  {
    id: 'u-004',
    nama: 'Sitti Rahmawati',
    email: 'sitti.rahmawati@makassarkota.go.id',
    opd: 'Dinas Kesehatan',
    peran: 'Inovator',
    aktif: true,
    loginTerakhir: '25 Sep 2026, 16:42',
  },
  {
    id: 'u-005',
    nama: 'Dr. Hasanuddin Latief',
    email: 'hasanuddin.latief@makassarkota.go.id',
    opd: 'BRIDA Kota Makassar',
    peran: 'Verifikator',
    aktif: true,
    loginTerakhir: '25 Sep 2026, 14:10',
  },
  {
    id: 'u-006',
    nama: 'Ahmad Fauzi',
    email: 'ahmad.fauzi@makassarkota.go.id',
    opd: 'Dinas Perhubungan',
    peran: 'Inovator',
    aktif: true,
    loginTerakhir: '24 Sep 2026, 11:03',
  },
  {
    id: 'u-007',
    nama: 'Irma Suryani',
    email: 'irma.suryani@makassarkota.go.id',
    opd: 'BRIDA Kota Makassar',
    peran: 'Verifikator',
    aktif: true,
    loginTerakhir: '23 Sep 2026, 10:21',
  },
  {
    id: 'u-008',
    nama: 'Fadli Ramadhan',
    email: 'fadli.ramadhan@makassarkota.go.id',
    opd: 'Dinas Lingkungan Hidup',
    peran: 'Inovator',
    aktif: false,
    loginTerakhir: '12 Agu 2026, 09:47',
  },
  {
    id: 'u-009',
    nama: 'Rini Kartika',
    email: 'rini.kartika@makassarkota.go.id',
    opd: 'Dinas Pendidikan',
    peran: 'Inovator',
    aktif: true,
    loginTerakhir: '22 Sep 2026, 13:30',
  },
  {
    id: 'u-010',
    nama: 'Yusuf Daeng Tompo',
    email: 'yusuf.tompo@makassarkota.go.id',
    opd: 'Kecamatan Tamalate',
    peran: 'Inovator',
    aktif: true,
    loginTerakhir: null,
  },
]

export const OPD_OPTIONS = [
  'BRIDA Kota Makassar',
  'Dinas Komunikasi dan Informatika',
  'Dinas Kesehatan',
  'Dinas Pendidikan',
  'Dinas Perhubungan',
  'Dinas Lingkungan Hidup',
  'Dinas Pariwisata',
  'Dinas Sosial',
  'Kecamatan Tamalate',
  'Kecamatan Mariso',
  'Kecamatan Mamajang',
]

export const ROLE_OPTIONS: UserRole[] = ['Inovator', 'Verifikator', 'Administrator']