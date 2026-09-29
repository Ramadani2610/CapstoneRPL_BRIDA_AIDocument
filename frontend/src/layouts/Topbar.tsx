import { Bell, ChevronDown, ShieldCheck } from 'lucide-react'
import { useNavigate } from 'react-router-dom'
import { DEMO_PROFILE, ROLE_LABEL, ROLES, initials } from '../config/roles'
import { defaultPathForRole } from '../config/navigation'
import { useRole } from '../lib/role'
import briadaLogo from '../assets/images/logo-sigap.png'

export default function Topbar() {
  const { role, setRole } = useRole()
  const navigate = useNavigate()
  const profile = DEMO_PROFILE[role] ?? { name: 'Pengguna', unit: 'BRIDA Kota Makassar' }

  // Langsung ke menu paling atas milik peran tersebut.
  function switchRole(next: string) {
    setRole(next)
    navigate(defaultPathForRole(next), { replace: true })
  }

  return (
    <header className="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-line bg-white px-6">
      {/* Identitas sistem */}
      <div className="flex items-center gap-3">
        {/* Logo BRIDA di sudut kiri atas */}
        <img src={briadaLogo} alt="Logo BRIDA Kota Makassar" className="h-9 w-auto object-contain" />
        <div className="leading-tight">
          <p className="text-sm font-semibold">
            BRIDA <span className="font-normal text-muted">Kota Makassar</span>
          </p>
          <p className="text-xs text-muted">
            <span className="font-semibold text-ink">SIGAP</span> Sistem Verifikator Dokumen
          </p>
        </div>
      </div>

      <div className="flex items-center gap-4">
        {/* Pengalih peran - SEMENTARA, hanya untuk pengembangan & demo.
            Hapus setelah autentikasi jadi. */}
        <select
          value={role}
          onChange={(event) => switchRole(event.target.value)}
          title="Mode pengembangan: ganti peran untuk mencoba tampilan tiap role"
          className="rounded-md border border-dashed border-line bg-canvas px-2 py-1 text-xs text-muted"
        >
          {Object.values(ROLES).map((value) => (
            <option key={value} value={value}>
              dev: {ROLE_LABEL[value]}
            </option>
          ))}
        </select>

        <span className="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600">
          <ShieldCheck size={14} />
          {ROLE_LABEL[role]}
        </span>

        <button type="button" className="relative text-muted hover:text-ink">
          <Bell size={18} />
          <span className="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-brand-600 text-[10px] font-semibold text-white">
            2
          </span>
        </button>

        <div className="flex items-center gap-2">
          <div className="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 text-xs font-semibold text-white">
            {initials(profile.name)}
          </div>
          <div className="hidden leading-tight sm:block">
            <p className="text-sm font-medium">{profile.name}</p>
            <p className="text-xs text-muted">{profile.unit}</p>
          </div>
          <ChevronDown size={16} className="text-muted" />
        </div>
      </div>
    </header>
  )
}

