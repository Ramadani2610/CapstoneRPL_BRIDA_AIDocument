import { Navigate, useLocation } from 'react-router-dom'
import { defaultPathForRole, navByKey } from './config/navigation'
import { useRole } from './lib/role'
import AksesDitolakPage from './pages/AksesDitolakPage'
import DashboardAdminPage from './pages/admin/dashboard'
import ManajemenPenggunaPage from './pages/admin/pengguna'
import DashboardInovatorPage from './pages/inovator/dashboard'
import AntrianReviewPage from './pages/verifikator/antrian'
import GagalDiprosesPage from './pages/verifikator/gagal-diproses'
import RiwayatAuditPage from './pages/verifikator/riwayat'

/*
  Daftar halaman aplikasi.

  `key` harus sama dengan key di src/config/navigation.js.
  Path dan daftar peran TIDAK ditulis ulang di sini - diambil dari navigation.js,
  supaya menu dan hak akses tidak pernah beda.

  Menambah halaman: tambah entri di sini + di navigation.js.
*/
export const APP_ROUTES = [
  { key: 'dashboard', element: <DashboardAdminPage /> },
  { key: 'antrian', element: <AntrianReviewPage /> },
  { key: 'gagal-diproses', element: <GagalDiprosesPage /> },
  { key: 'riwayat', element: <RiwayatAuditPage /> },
  { key: 'pengguna', element: <ManajemenPenggunaPage /> },
  { key: 'inovator-dashboard', element: <DashboardInovatorPage /> },
]

// Setiap route dibungkus ini: kalau peran tidak berhak, tampilkan halaman tolak.
export function RequireRole({ roles, children }) {
  const { role } = useRole()
  if (!roles.includes(role)) {
    return <AksesDitolakPage allow={roles} />
  }
  return children
}

// "/" diarahkan ke halaman pertama sesuai peran yang sedang aktif.
export function HomeRedirect() {
  const { role } = useRole()
  return <Navigate to={defaultPathForRole(role)} replace />
}

// Berguna untuk breadcrumb: ambil data menu dari path yang sedang dibuka.
export function useCurrentNavItem() {
  const { pathname } = useLocation()
  return Object.values(navByKey).find((item) => item.path === pathname) ?? null
}
