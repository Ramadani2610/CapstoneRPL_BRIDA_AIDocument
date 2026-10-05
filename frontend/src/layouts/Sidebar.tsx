import { useState, useRef, useEffect, type ComponentType } from 'react'
import { NavLink, useNavigate } from 'react-router-dom'
import { LogOut, ChevronUp } from 'lucide-react'
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
  InfoIcon,
  ShieldCheckIcon,
  UsersIcon,
} from '../components/icons'

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
  Users: UsersIcon,
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

  const [isProfileMenuOpen, setIsProfileMenuOpen] = useState(false)
  const profileMenuRef = useRef<HTMLDivElement>(null)

  // Menutup menu keluar jika pengguna mengklik di luar area profil
  useEffect(() => {
    function handleClickOutside(event: MouseEvent) {
      if (profileMenuRef.current && !profileMenuRef.current.contains(event.target as Node)) {
        setIsProfileMenuOpen(false)
      }
    }
    document.addEventListener('mousedown', handleClickOutside)
    return () => document.removeEventListener('mousedown', handleClickOutside)
  }, [])

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

      {/* Sidebar Drawer */}
      <aside
        className={`fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 flex-col justify-between border-r border-line bg-white transition-transform duration-300 ease-in-out lg:static lg:z-0 lg:translate-x-0 ${
          isOpen ? 'translate-x-0' : '-translate-x-full'
        }`}
      >
        {/* Navigasi Menu Atas */}
        <div className="flex flex-col overflow-y-auto">
          <nav className="flex flex-col gap-1 p-4">
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
                      isActive ? 'bg-brand-600 text-white' : 'text-ink/80 hover:bg-brand-50 hover:text-brand-600',
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

        {/* Bagian Bawah: Bantuan & Kartu Profil */}
        <div className="p-4 flex flex-col gap-3 border-t border-line">
          {/* Box Bantuan */}
          <div className="rounded-lg bg-canvas p-3">
            <div className="flex items-center gap-3">
              <InfoIcon className="size-4 shrink-0 text-brand-600" />
              <p className="text-sm font-medium text-ink">Butuh bantuan?</p>
            </div>
            <p className="mt-1.5 text-xs leading-[1.6] text-muted">
              Helpdesk BRIDA: (0411) 873 110 ·
              <br />
              Senin–Jumat, 08.00–16.00
            </p>
          </div>

          {/* Kartu Profil & Dropdown Keluar */}
          <div className="relative" ref={profileMenuRef}>
            {/* Pop-up Menu Keluar (Muncul ke Atas) */}
            {isProfileMenuOpen && (
              <div className="absolute bottom-full left-0 mb-2 w-full rounded-lg bg-white p-1 shadow-lg ring-1 ring-black/5 z-50">
                <button
                  type="button"
                  onClick={handleLogout}
                  className="flex w-full items-center gap-2.5 rounded-md px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors cursor-pointer"
                >
                  <LogOut size={16} className="text-red-500" />
                  <span className="font-medium">Keluar</span>
                </button>
              </div>
            )}

            {/* Tombol Profil di Bagian Bawah Sidebar */}
            <button
              type="button"
              onClick={() => setIsProfileMenuOpen(!isProfileMenuOpen)}
              className={`flex w-full items-center justify-between gap-2.5 rounded-lg border border-gray-200 p-2 text-left transition-all hover:bg-gray-50 cursor-pointer ${
                isProfileMenuOpen ? 'bg-gray-100 border-gray-300' : 'bg-white'
              }`}
            >
              <div className="flex items-center gap-2.5 min-w-0">
                <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#7a161a] text-xs font-semibold text-white">
                  {initials(profile.name)}
                </div>
                <div className="min-w-0 flex-1 leading-tight">
                  <p className="truncate text-sm font-medium text-gray-900">{profile.name}</p>
                  <p className="truncate text-xs text-gray-500">{profile.unit}</p>
                </div>
              </div>
              <ChevronUp
                size={16}
                className={`text-gray-400 shrink-0 transition-transform duration-200 ${
                  isProfileMenuOpen ? 'rotate-180' : ''
                }`}
              />
            </button>
          </div>
        </div>
      </aside>
    </>
  )
}