import type { ComponentType } from 'react'
import { NavLink } from 'react-router-dom'
import { navForRole } from '../config/navigation'
import { useRole } from '../lib/role'
import {
  AlertCircleIcon,
  ClipboardListIcon,
  FilePlusIcon,
  FileTextIcon,
  GridIcon,
  HistoryIcon,
  InfoIcon,
  UsersIcon,
} from '../components/icons'

/*
  Susunan tampilan sidebar mengikuti frame "Aside" pada desain Figma:
  - putih, lebar 256px, garis pemisah di kanan
  - daftar menu mulai 16px dari tepi, jarak antar item 4px, tinggi item 40px
  - item aktif: latar maroon #7a1c1c, teks putih, sudut membulat 8px
  - kartu "Butuh bantuan?" menempel di bagian bawah sidebar

  Urutan menu tetap seperti sebelumnya (lihat src/config/navigation.ts):
  admin = Dashboard, Antrian Review, Gagal Diproses, Riwayat Audit, Manajemen Pengguna
  verifikator = Antrian Review, Gagal Diproses, Riwayat Audit
  inovator = Dashboard, Buat Pengajuan, Riwayat Status
*/
const ICONS: Record<string, ComponentType<{ className?: string }>> = {
  LayoutDashboard: GridIcon,
  FilePlus: FilePlusIcon,
  History: HistoryIcon,
  ClipboardList: ClipboardListIcon,
  AlertTriangle: AlertCircleIcon,
  FileText: FileTextIcon,
  Users: UsersIcon,
}

export default function Sidebar() {
  const { role } = useRole()
  const items = navForRole(role)

  return (
    <aside className="hidden w-64 shrink-0 flex-col justify-between border-r border-line bg-white lg:flex">
      <nav className="flex flex-col gap-1 p-4">
        {items.map((item) => {
          const Icon = ICONS[item.icon] ?? GridIcon
          return (
            <NavLink
              key={item.key}
              to={item.path}
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

      <div className="m-4 rounded-lg bg-canvas p-3">
        <div className="flex items-center gap-3">
          <InfoIcon className="size-4 shrink-0 text-brand-600" />
          <p className="text-sm font-medium text-ink">Butuh bantuan?</p>
        </div>
        <p className="mt-2 text-xs leading-[1.6] text-muted">
          Helpdesk BRIDA: (0411) 873 110 ·
          <br />
          Senin–Jumat, 08.00–16.00
        </p>
      </div>
    </aside>
  )
}
