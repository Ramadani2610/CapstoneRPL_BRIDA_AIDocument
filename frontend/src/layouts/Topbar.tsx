import { Bell, ShieldCheck, Menu } from 'lucide-react'
import { useNavigate } from 'react-router-dom'
import { DEMO_PROFILE, ROLE_LABEL, initials } from '../config/roles'
import { useRole } from '../lib/role'
import briadaLogo from '../assets/images/logo-sigap.png'

interface TopbarProps {
  onToggleSidebar?: () => void
}

export default function Topbar({ onToggleSidebar }: TopbarProps) {
  const { role } = useRole()
  const navigate = useNavigate()
  const profile = DEMO_PROFILE[role] ?? { name: 'Pengguna', unit: 'BRIDA Kota Makassar' }

  return (
    <header className="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-line bg-white px-4 sm:px-6">
      {/* Sisi Kiri: Tombol Garis 3 (Mobile) + Logo BRIDA */}
      <div className="flex items-center gap-3">
        <button
          type="button"
          onClick={onToggleSidebar}
          className="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 active:bg-gray-200 lg:hidden"
          aria-label="Buka Sidebar"
        >
          <Menu size={20} />
        </button>

        <img src={briadaLogo} alt="Logo BRIDA Kota Makassar" className="h-8 sm:h-9 w-auto object-contain" />
      </div>

      {/* Sisi Kanan: Badge Role, Notifikasi, & Ikon Profil */}
      <div className="flex items-center gap-3 sm:gap-4">
        {/* Badge Peran */}
        <span className="hidden sm:inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600">
          <ShieldCheck size={14} />
          {ROLE_LABEL[role]}
        </span>

        {/* Tombol Notifikasi */}
        <button type="button" className="relative text-muted hover:text-ink">
          <Bell size={18} />
          <span className="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-brand-600 text-[10px] font-semibold text-white">
            2
          </span>
        </button>

        {/* Ikon Profil Sahaja (Langsung Navigasi ke Halaman Profil) */}
        <button
          type="button"
          onClick={() => navigate('/profil')}
          title="Lihat Profil"
          className="flex h-9 w-9 items-center justify-center rounded-lg bg-[#7a161a] text-xs font-semibold text-white transition-all hover:bg-[#5a1013] active:scale-95 cursor-pointer"
        >
          {initials(profile.name)}
        </button>
      </div>
    </header>
  )
}