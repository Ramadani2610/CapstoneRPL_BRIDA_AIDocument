import { useState, type ComponentType } from 'react'
import { NavLink, useNavigate } from 'react-router-dom'
import { LogOut } from 'lucide-react'
import { navForRole } from '../config/navigation'
import { useRole } from '../lib/role'
import { DEMO_PROFILE, initials } from '../config/roles'
import {
  AlertCircleIcon,
  ClipboardListIcon,
  FilePlusIcon,
  FileTextIcon,
  FilterIcon,
  GridIcon,
  HistoryIcon,
  ShieldCheckIcon,
  UsersIcon,
} from '../components/icons'

import logoSigap from '../assets/images/logo-sigap.png' 

const ICONS: Record<string, ComponentType<{ className?: string }>> = {
  LayoutDashboard: GridIcon,
  FilePlus: FilePlusIcon,
  History: HistoryIcon,
  ClipboardList: ClipboardListIcon,
  AlertTriangle: AlertCircleIcon,
  FileText: FileTextIcon,
  ScrollText: FileTextIcon,
  Settings2: FilterIcon,
  ShieldCheck: ShieldCheckIcon,
  UsersIcon,
}

interface SidebarProps {
  isOpen?: boolean
  onClose?: () => void
}

export default function Sidebar({ isOpen = false, onClose }: SidebarProps) {
  const { role, setRole } = useRole()
  const navigate = useNavigate()
  const items = navForRole(role)
  const profile = DEMO_PROFILE[role] ?? { name: 'Pengguna', unit: 'BRIDA Kota Makassar' }

  const [showLogoutConfirm, setShowLogoutConfirm] = useState(false)

  function handleLogout() {
    setRole('')
    navigate('/login', { replace: true })
  }

  return (
    <>
      {/* Overlay Latar Gelap Khusus Mobile Saat Sidebar Terbuka */}
      {isOpen && (
        <div
          className="fixed inset-0 z-30 bg-black/50 lg:hidden"
          onClick={onClose}
        />
      )}

      {/* Sidebar Drawer / Fixed Sidebar */}
      <aside
        // PERUBAHAN DISINI: Menggunakan lg:static lg:h-full agar pas di dalam flex container AppLayout
        className={`fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 flex-col border-r border-gray-200 bg-white transition-transform duration-300 ease-in-out lg:static lg:z-0 lg:h-full lg:translate-x-0 ${
          isOpen ? 'translate-x-0' : '-translate-x-full'
        }`}
      >
        {/* Logo BRIDA: Hanya muncul di tampilan mobile */}
        <div className="flex h-20 shrink-0 items-center justify-center border-b border-gray-200 px-6 lg:hidden">
          <img 
            src={logoSigap} 
            alt="Logo BRIDA" 
            className="h-10 w-auto object-contain" 
          />
        </div>

        {/* Navigasi Menu (Tengah - Scrollable jika menu melebihi tinggi layar) */}
        <div className="flex-1 overflow-y-auto py-4">
          <nav className="flex flex-col gap-1 px-4">
            {items.map((item) => {
              const Icon = ICONS[item.icon] ?? GridIcon
              return (
                <NavLink
                  key={item.key}
                  to={item.path}
                  onClick={onClose}
                  className={({ isActive }) =>
                    [
                      'flex h-10 items-center gap-3 rounded-lg px-3 text-sm font-medium transition',
                      isActive 
                        ? 'bg-[#7a161a] text-white' 
                        : 'text-gray-600 hover:bg-gray-100 hover:text-[#7a161a]',
                    ].join(' ')
                  }
                >
                  <Icon className="size-[18px] shrink-0" />
                  <span>{item.label}</span>
                </NavLink>
              )
            })}
          </nav>
        </div>

        {/* Bagian Bawah: Profil & Tombol Keluar */}
        <div className="shrink-0 border-t border-gray-200 bg-gray-50 p-4">
          <div className="flex flex-col gap-4">
            {/* Info Pengguna */}
            <div className="flex items-center gap-3">
              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#7a161a] text-sm font-bold text-white shadow-sm">
                {initials(profile.name)}
              </div>
              <div className="min-w-0 flex-1 leading-tight">
                <p className="truncate text-sm font-semibold text-gray-900">{profile.name}</p>
                <p className="truncate text-xs text-gray-500">{profile.unit}</p>
              </div>
            </div>

            {/* Tombol Keluar */}
            <button
              type="button"
              onClick={() => setShowLogoutConfirm(true)}
              className="flex w-full items-center justify-center gap-2 rounded-lg border border-[#7a161a] bg-white px-4 py-2 text-sm font-medium text-[#7a161a] shadow-sm transition-all hover:bg-[#7a161a] hover:text-white cursor-pointer"
            >
              <LogOut size={16} />
              <span>Keluar</span>
            </button>
          </div>
        </div>
      </aside>

      {/* Pop-up Modal Konfirmasi Keluar */}
      {showLogoutConfirm && (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
          <div className="w-full max-w-sm rounded-xl bg-white p-6 shadow-xl animate-in fade-in zoom-in-95 duration-150">
            <h3 className="mb-2 text-lg font-bold text-gray-900">Konfirmasi Keluar</h3>
            <p className="mb-6 text-sm text-gray-600">
              Apakah Anda yakin ingin keluar dari sesi aplikasi SIGAP Inovasi?
            </p>
            <div className="flex items-center justify-end gap-3">
              <button
                type="button"
                onClick={() => setShowLogoutConfirm(false)}
                className="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 cursor-pointer"
              >
                Batal
              </button>
              <button
                type="button"
                onClick={handleLogout}
                className="rounded-lg bg-[#7a161a] px-4 py-2 text-sm font-semibold text-white shadow-md transition-colors hover:bg-[#5a1013] cursor-pointer"
              >
                Ya, Keluar
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  )
}