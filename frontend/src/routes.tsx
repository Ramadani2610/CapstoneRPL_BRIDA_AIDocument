import { Navigate, useLocation } from 'react-router-dom'
import type { ReactNode } from 'react'
import { defaultPathForRole, navByKey } from './config/navigation'
import { useRole } from './lib/role'
import AksesDitolakPage from './pages/AksesDitolakPage'
import DashboardAdminPage from './pages/admin/dashboard'
import IndikatorPage from './pages/admin/indikator'
import ManajemenPenggunaPage from './pages/admin/pengguna'
import LogAuditPage from './pages/admin/log-audit'
import DashboardInovatorPage from './pages/inovator/dashboard'
import AntrianReviewPage from './pages/verifikator/antrian'
import GagalDiprosesPage from './pages/verifikator/gagal-diproses'
import RiwayatAuditPage from './pages/verifikator/riwayat'

export const APP_ROUTES = [
  { key: 'dashboard', element: <DashboardAdminPage /> },
  { key: 'indikator', element: <IndikatorPage /> },
  { key: 'antrian', element: <AntrianReviewPage /> },
  { key: 'gagal-diproses', element: <GagalDiprosesPage /> },
  { key: 'riwayat', element: <RiwayatAuditPage /> },
  { key: 'pengguna', element: <ManajemenPenggunaPage /> },
  { key: 'log-audit', element: <LogAuditPage /> },
  { key: 'inovator-dashboard', element: <DashboardInovatorPage /> },
]

export function RequireRole({ roles, children }: { roles: string[]; children: ReactNode }) {
  const { role } = useRole()

  // REVISI: Jika belum login, paksa ke /login
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

  // REVISI: Jika belum login, arahkan ke /login
  if (!role) {
    return <Navigate to="/login" replace />
  }

  return <Navigate to={defaultPathForRole(role)} replace />
}

export function useCurrentNavItem() {
  const { pathname } = useLocation()
  return Object.values(navByKey).find((item) => item.path === pathname) ?? null
}