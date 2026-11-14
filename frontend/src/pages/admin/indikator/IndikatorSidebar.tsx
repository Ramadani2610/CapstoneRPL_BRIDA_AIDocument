import { Search } from 'lucide-react'
import { useMemo, useState } from 'react'
import type { Indikator } from './data'

interface IndikatorSidebarProps {
  indikators: Indikator[]
  selectedId: string | null
  onSelect: (id: string) => void
}

export default function IndikatorSidebar({
  indikators,
  selectedId,
  onSelect,
}: IndikatorSidebarProps) {
  const [query, setQuery] = useState('')

  const filtered = useMemo(() => {
    const q = query.trim().toLowerCase()
    if (!q) return indikators
    return indikators.filter(
      (ind) =>
        ind.nama.toLowerCase().includes(q) ||
        ind.kode.toLowerCase().includes(q),
    )
  }, [indikators, query])

  return (
    <div className="flex h-full flex-col rounded-2xl border border-slate-200 bg-white">
      <div className="border-b border-slate-100 p-4">
        <div className="relative">
          <Search
            size={16}
            className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
          />
          <input
            type="text"
            value={query}
            onChange={(e) => setQuery(e.target.value)}
            placeholder="Cari indikator"
            className="w-full rounded-lg border border-slate-200 bg-white py-2 pl-9 pr-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500"
          />
        </div>
      </div>

      <div className="flex-1 overflow-y-auto">
        {filtered.length === 0 ? (
          <div className="p-6 text-center text-sm text-slate-500">
            Tidak ada indikator yang cocok.
          </div>
        ) : (
          <ul className="divide-y divide-slate-100">
            {filtered.map((ind) => {
              const isActive = ind.id === selectedId
              return (
                <li key={ind.id}>
                  <button
                    type="button"
                    onClick={() => onSelect(ind.id)}
                    className={[
                      'w-full border-l-4 px-4 py-3 text-left transition',
                      isActive
                        ? 'border-brand-700 bg-brand-50'
                        : 'border-transparent hover:bg-slate-50',
                    ].join(' ')}
                  >
                    <div className="flex items-start gap-3">
                      <span className="rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-mono font-semibold text-slate-600">
                        {ind.kode}
                      </span>
                      <div className="min-w-0 flex-1">
                        <p
                          className={[
                            'text-sm font-medium',
                            isActive ? 'text-brand-800' : 'text-slate-800',
                          ].join(' ')}
                        >
                          {ind.nama}
                        </p>
                        <p className="mt-1 flex items-center gap-1 text-xs text-slate-500">
                          <span
                            className={[
                              'h-1.5 w-1.5 rounded-full',
                              ind.aktif ? 'bg-emerald-500' : 'bg-slate-300',
                            ].join(' ')}
                          />
                          Bobot {ind.bobot} · {ind.aktif ? 'Aktif' : 'Nonaktif'}
                        </p>
                      </div>
                    </div>
                  </button>
                </li>
              )
            })}
          </ul>
        )}
      </div>
    </div>
  )
}