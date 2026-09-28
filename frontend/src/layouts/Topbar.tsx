import { Bell, ChevronDown, ShieldCheck } from 'lucide-react'
import { DEMO_PROFILE, ROLE_LABEL, ROLES } from '../config/roles'
import { useRole } from '../lib/role'

function initials(name: string): string {
  return name
    .split(' ')
    .filter((part) => /^[A-Za-z]/.test(part))
    .slice(0, 2)
    .map((part) => part[0].toUpperCase())
    .join('')
}

export default function Topbar() {
  const { role, setRole } = useRole()
  const profile = DEMO_PROFILE[role]

  return (
    <header className="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6">
      {/* Identitas sistem */}
      <div className="flex items-center gap-3">
        <div className="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-600 text-sm font-bold text-white">
          B
        </div>
        <div className="leading-tight">
          <p className="text-sm font-semibold">
            BRIDA <span className="font-normal text-slate-500">Kota Makassar</span>
          </p>
          <p className="text-xs text-slate-500">
            <span className="font-semibold text-slate-700">SIGAP</span> Sistem Verifikator Dokumen
          </p>
        </div>
      </div>

      <div className="flex items-center gap-4">
        {/* Pengalih peran - SEMENTARA, hanya untuk pengembangan & demo.
            Hapus setelah autentikasi jadi. */}
        <select
          value={role}
          onChange={(event) => setRole(event.target.value)}
          title="Mode pengembangan: ganti peran untuk mencoba tampilan tiap role"
          className="rounded-md border border-dashed border-slate-300 bg-slate-50 px-2 py-1 text-xs text-slate-500"
        >
          {Object.values(ROLES).map((value) => (
            <option key={value} value={value}>
              dev: {ROLE_LABEL[value]}
            </option>
          ))}
        </select>

        <span className="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-700">
          <ShieldCheck size={14} />
          {ROLE_LABEL[role]}
        </span>

        <button type="button" className="relative text-slate-500 hover:text-slate-700">
          <Bell size={18} />
          <span className="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-semibold text-white">
            2
          </span>
        </button>

        <div className="flex items-center gap-2">
          <div className="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-xs font-semibold text-slate-600">
            {initials(profile.name)}
          </div>
          <div className="hidden leading-tight sm:block">
            <p className="text-sm font-medium">{profile.name}</p>
            <p className="text-xs text-slate-500">{profile.unit}</p>
          </div>
          <ChevronDown size={16} className="text-slate-400" />
        </div>
      </div>
    </header>
  )
}
