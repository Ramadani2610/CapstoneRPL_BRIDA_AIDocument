import {
  AlertTriangle,
  ClipboardList,
  CircleHelp,
  FileText,
  LayoutDashboard,
  Users,
} from 'lucide-react'
import { NavLink } from 'react-router-dom'
import type { LucideIcon } from 'lucide-react'
import { NAV, navForRole } from '../config/navigation'
import { useRole } from '../lib/role'

// navigation.ts menyimpan nama ikon sebagai teks supaya file config bebas dari JSX.
const ICONS: Record<string, LucideIcon> = {
  AlertTriangle,
  ClipboardList,
  FileText,
  LayoutDashboard,
  Users,
}

export default function Sidebar() {
  const { role } = useRole()
  const items = navForRole(role)

  return (
    <aside className="hidden w-64 shrink-0 flex-col justify-between border-r border-slate-200 bg-white lg:flex">
      <nav className="space-y-1 p-4">
        {items.map((item) => {
          const Icon = ICONS[item.icon]
          return (
            <NavLink
              key={item.key}
              to={item.path}
              className={({ isActive }) =>
                [
                  'flex items-center gap-3 rounded-lg border-l-4 px-3 py-2.5 text-sm transition',
                  isActive
                    ? 'border-brand-600 bg-brand-50 font-medium text-brand-700'
                    : 'border-transparent text-slate-600 hover:bg-slate-50',
                ].join(' ')
              }
            >
              {Icon ? <Icon size={17} /> : null}
              <span className="flex-1">{item.label}</span>
              {/* Angka badge (mis. jumlah dokumen gagal) nanti diisi dari API. */}
              {item.badgeKey ? null : null}
            </NavLink>
          )
        })}
      </nav>

      <div className="m-4 rounded-xl border border-slate-200 bg-slate-50 p-4">
        <div className="flex items-center gap-2 text-sm font-medium text-slate-700">
          <CircleHelp size={16} className="text-brand-600" />
          Butuh bantuan?
        </div>
        <p className="mt-2 text-xs text-slate-500">Helpdesk BRIDA: (0411) 873 130</p>
        <p className="text-xs text-slate-500">Senin-Jumat, 08.00-18.00</p>
      </div>
    </aside>
  )
}

// Dipakai halaman lain kalau butuh daftar menu (mis. breadcrumb).
export const NAV_ITEMS = NAV
