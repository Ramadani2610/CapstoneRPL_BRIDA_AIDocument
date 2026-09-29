import { Navigate, useLocation } from 'react-router-dom'
import type { ReactNode } from 'react'
import { defaultPathForRole, navByKey } from './config/navigation'
import { useRole } from './lib/role'
import AksesDitolakPage from './pages/AksesDitolakPage'
import DashboardAdminPage from './pages/admin/dashboard'
import ManajemenPenggunaPage from './pages/admin/pengguna'
import DashboardInovatorPage from './pages/inovator/dashboard'
import PengajuanBaruPage from './pages/inovator/pengajuan-baru'
import RiwayatStatusPage from './pages/inovator/riwayat'
import AntrianReviewPage from './pages/verifikator/antrian'
import GagalDiprosesPage from './pages/verifikator/gagal-diproses'
import RiwayatAuditPage from './pages/verifikator/riwayat'

export const APP_ROUTES = [
  // Inovator
  { key: 'inovator-dashboard', element: <DashboardInovatorPage /> },
  { key: 'inovator-pengajuan-baru', element: <PengajuanBaruPage /> },
  { key: 'inovator-riwayat', element: <RiwayatStatusPage /> },
  // Admin
  { key: 'dashboard', element: <DashboardAdminPage /> },
  { key: 'pengguna', element: <ManajemenPenggunaPage /> },
  // Verifikator
  { key: 'antrian', element: <AntrianReviewPage /> },
  { key: 'gagal-diproses', element: <GagalDiprosesPage /> },
  { key: 'riwayat', element: <RiwayatAuditPage /> },
]

export function RequireRole({ roles, children }: { roles: string[]; children: ReactNode }) {
  const { role } = useRole()

  // Belum login, paksa ke /login
  if (!role) {
    return <Navigate to="/login" replace />
  }

  if (!roles.includes(role)) {
    return <AksesDitolakPage allow={roles} />
  }
  return children
}

export function HomeRedirect() {
  const { role } = useRole()

  if (!role) {
    return <Navigate to="/login" replace />
  }

  return <Navigate to={defaultPathForRole(role)} replace />
}

export function useCurrentNavItem() {
  const { pathname } = useLocation()
  return Object.values(navByKey).find((item) => item.path === pathname) ?? null
}
