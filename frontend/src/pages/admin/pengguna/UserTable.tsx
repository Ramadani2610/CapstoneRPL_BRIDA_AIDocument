import { Pencil, Search, Trash2 } from 'lucide-react'
import { useMemo, useState } from 'react'
import Avatar from '../../../components/ui/Avatar'
import Toggle from '../../../components/ui/Toggle'
import type { User, UserRole } from './data'

interface UserTableProps {
  users: User[]
  onToggleActive: (userId: string, nextValue: boolean) => void
  onEdit: (user: User) => void
  onDelete: (user: User) => void
}

type TabKey = 'Semua' | UserRole

const TABS: TabKey[] = ['Semua', 'Inovator', 'Verifikator', 'Administrator']

const ROLE_BADGE: Record<UserRole, string> = {
  Inovator: 'bg-sky-50 text-sky-700',
  Verifikator: 'bg-amber-50 text-amber-700',
  Administrator: 'bg-rose-50 text-rose-700',
}

export default function UserTable({
  users,
  onToggleActive,
  onEdit,
  onDelete,
}: UserTableProps) {
  const [activeTab, setActiveTab] = useState<TabKey>('Semua')
  const [query, setQuery] = useState('')

  const countByRole = useMemo(() => {
    const result: Record<TabKey, number> = {
      Semua: users.length,
      Inovator: 0,
      Verifikator: 0,
      Administrator: 0,
    }
    users.forEach((u) => {
      result[u.peran] += 1
    })
    return result
  }, [users])

  const filtered = useMemo(() => {
    const q = query.trim().toLowerCase()
    return users.filter((u) => {
      const matchTab = activeTab === 'Semua' || u.peran === activeTab
      if (!matchTab) return false
      if (!q) return true
      return (
        u.nama.toLowerCase().includes(q) ||
        u.email.toLowerCase().includes(q) ||
        u.opd.toLowerCase().includes(q)
      )
    })
  }, [users, activeTab, query])

  return (
    <div className="rounded-2xl border border-slate-200 bg-white">
      <div className="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 px-5 py-4">
        <div className="flex flex-wrap gap-2">
          {TABS.map((tab) => {
            const isActive = tab === activeTab
            return (
              <button
                key={tab}
                type="button"
                onClick={() => setActiveTab(tab)}
                className={[
                  'rounded-full px-3 py-1.5 text-sm font-medium transition',
                  isActive
                    ? 'bg-brand-700 text-white'
                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200',
                ].join(' ')}
              >
                {tab}
                <span
                  className={[
                    'ml-1.5 text-xs',
                    isActive ? 'text-white/80' : 'text-slate-500',
                  ].join(' ')}
                >
                  {countByRole[tab]}
                </span>
              </button>
            )
          })}
        </div>

        <div className="relative w-full sm:w-72">
          <Search
            size={16}
            className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
          />
          <input
            type="text"
            value={query}
            onChange={(e) => setQuery(e.target.value)}
            placeholder="Cari nama, email, atau OPD"
            className="w-full rounded-lg border border-slate-200 bg-white py-2 pl-9 pr-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500"
          />
        </div>
      </div>

      <div className="overflow-x-auto">
        <table className="w-full text-sm">
          <thead>
            <tr className="border-b border-slate-100 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
              <th className="px-5 py-3">Pengguna</th>
              <th className="px-5 py-3">OPD / Instansi</th>
              <th className="px-5 py-3">Peran</th>
              <th className="px-5 py-3">Status</th>
              <th className="px-5 py-3">Login Terakhir</th>
              <th className="px-5 py-3 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            {filtered.length === 0 ? (
              <tr>
                <td colSpan={6} className="px-5 py-10 text-center text-sm text-slate-500">
                  Tidak ada pengguna yang cocok dengan pencarian.
                </td>
              </tr>
            ) : (
              filtered.map((user) => (
                <tr key={user.id} className="border-b border-slate-50 last:border-0">
                  <td className="px-5 py-3">
                    <div className="flex items-center gap-3">
                      <Avatar name={user.nama} size="md" />
                      <div className="min-w-0">
                        <p className="font-medium text-slate-800">{user.nama}</p>
                        <p className="truncate text-xs text-slate-500">{user.email}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-5 py-3 text-slate-700">{user.opd}</td>
                  <td className="px-5 py-3">
                    <span
                      className={[
                        'rounded-full px-2.5 py-0.5 text-xs font-medium',
                        ROLE_BADGE[user.peran],
                      ].join(' ')}
                    >
                      {user.peran}
                    </span>
                  </td>
                  <td className="px-5 py-3">
                    <div className="flex items-center gap-2">
                      <Toggle
                        checked={user.aktif}
                        onChange={(next) => onToggleActive(user.id, next)}
                        size="sm"
                      />
                      <span
                        className={[
                          'text-xs font-medium',
                          user.aktif ? 'text-slate-700' : 'text-slate-400',
                        ].join(' ')}
                      >
                        {user.aktif ? 'Aktif' : 'Nonaktif'}
                      </span>
                    </div>
                  </td>
                  <td className="px-5 py-3 text-xs text-slate-500">
                    {user.loginTerakhir ?? (
                      <span className="italic text-slate-400">Belum pernah</span>
                    )}
                  </td>
                  <td className="px-5 py-3">
                    <div className="flex items-center justify-end gap-1">
                      <button
                        type="button"
                        onClick={() => onEdit(user)}
                        className="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                        aria-label={`Edit ${user.nama}`}
                      >
                        <Pencil size={15} />
                      </button>
                      <button
                        type="button"
                        onClick={() => onDelete(user)}
                        className="rounded-lg p-2 text-slate-500 transition hover:bg-rose-50 hover:text-rose-700"
                        aria-label={`Hapus ${user.nama}`}
                      >
                        <Trash2 size={15} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>
      </div>

      <div className="border-t border-slate-100 px-5 py-3 text-xs text-slate-500">
        Menampilkan {filtered.length} dari {users.length} pengguna
      </div>
    </div>
  )
}