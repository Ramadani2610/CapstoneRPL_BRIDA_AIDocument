import { ROLES } from './roles'

/*
  SATU-SATUNYA sumber kebenaran untuk menu sidebar.

  Isi menu diambil dari use case pada SRS:
    Dashboard          -> halaman ringkasan (admin)
    Antrian Review     -> 3.2.11 Melihat Daftar Pengajuan Inovasi
    Gagal Diproses     -> 3.2.18 Menangani Kegagalan dan Retry
    Riwayat Audit      -> 3.2.17 Menelusuri Riwayat Status dan Keputusan
    Manajemen Pengguna -> 3.2.22 - 3.2.25 (khusus admin)

  Catatan: menu verifikator SAMA untuk verifikator dan admin. Jadi sidebar admin
  terasa "lengkap" tanpa perlu bikin sidebar terpisah - cukup perannya ikut
  didaftarkan di sini.

  Menambah menu = tambah 1 baris di sini + 1 baris di src/routes.jsx.
  Menyembunyikan menu = hapus/ubah `roles`-nya di sini saja.
*/
export interface NavItem {
  key: string
  label: string
  path: string
  icon: string
  roles: string[]
  badgeKey?: string
}

export const NAV: NavItem[] = [
  {
    key: 'dashboard',
    label: 'Dashboard',
    path: '/admin/dashboard',
    icon: 'LayoutDashboard',
    roles: [ROLES.ADMIN],
  },
  {
    key: 'antrian',
    label: 'Antrian Review',
    path: '/verifikator/antrian',
    icon: 'ClipboardList',
    roles: [ROLES.VERIFIKATOR, ROLES.ADMIN],
  },
  {
    key: 'gagal-diproses',
    label: 'Gagal Diproses',
    path: '/verifikator/gagal-diproses',
    icon: 'AlertTriangle',
    roles: [ROLES.VERIFIKATOR, ROLES.ADMIN],
    badgeKey: 'gagal', // angka badge diisi dari API, jangan hardcode di sini
  },
  {
    key: 'riwayat',
    label: 'Riwayat Audit',
    path: '/verifikator/riwayat',
    icon: 'FileText',
    roles: [ROLES.VERIFIKATOR, ROLES.ADMIN],
  },
  {
    key: 'pengguna',
    label: 'Manajemen Pengguna',
    path: '/admin/pengguna',
    icon: 'Users',
    roles: [ROLES.ADMIN],
  },
  {
    key: 'inovator-dashboard',
    label: 'Dashboard Pengajuan',
    path: '/inovator/dashboard',
    icon: 'LayoutDashboard',
    roles: [ROLES.INOVATOR],
  },
]

export const navByKey: Record<string, NavItem> = Object.fromEntries(NAV.map((item) => [item.key, item]))

// Menu yang boleh dilihat oleh seorang peran.
export function navForRole(role: string): NavItem[] {
  return NAV.filter((item) => item.roles.includes(role))
}

// Halaman pertama yang dibuka per peran.
export function defaultPathForRole(role: string): string {
  const first = navForRole(role)[0]
  return first ? first.path : '/akses-ditolak'
}
