import { Pencil, Plus, Trash2 } from 'lucide-react'
import type { Indikator } from './data'

interface IndikatorDetailProps {
  indikator: Indikator | null
  children?: React.ReactNode
  onEdit: (indikator: Indikator) => void
  onDelete: (indikator: Indikator) => void
  onTambahParameter: (indikator: Indikator) => void
}

export default function IndikatorDetail({
  indikator,
  children,
  onEdit,
  onDelete,
  onTambahParameter,
}: IndikatorDetailProps) {
  if (!indikator) {
    return (
      <div className="flex h-full items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-white p-10">
        <p className="text-sm text-slate-500">
          Pilih indikator di sebelah kiri untuk melihat detail.
        </p>
      </div>
    )
  }

  return (
    <div className="rounded-2xl border border-slate-200 bg-white">
      <div className="border-b border-slate-100 p-6">
        <div className="flex items-start justify-between gap-4">
          <div className="min-w-0 flex-1">
            <div className="mb-2 flex items-center gap-2">
              <span className="rounded bg-slate-100 px-2 py-0.5 text-xs font-mono font-semibold text-slate-600">
                {indikator.kode}
              </span>
              <span className="text-xs text-slate-500">{indikator.kategori}</span>
              <span
                className={[
                  'flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium',
                  indikator.aktif
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'bg-slate-100 text-slate-500',
                ].join(' ')}
              >
                <span
                  className={[
                    'h-1.5 w-1.5 rounded-full',
                    indikator.aktif ? 'bg-emerald-500' : 'bg-slate-400',
                  ].join(' ')}
                />
                {indikator.aktif ? 'Aktif' : 'Nonaktif'}
              </span>
            </div>
            <h2 className="text-xl font-semibold text-slate-900">
              {indikator.nama}
            </h2>
            <p className="mt-2 text-sm text-slate-600">{indikator.deskripsi}</p>
          </div>

          <div className="flex shrink-0 items-center gap-2">
            <button
              type="button"
              onClick={() => onEdit(indikator)}
              className="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
            >
              <Pencil size={14} />
              Edit Indikator
            </button>
            <button
              type="button"
              onClick={() => onDelete(indikator)}
              className="rounded-lg border border-slate-200 bg-white p-2 text-slate-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700"
              aria-label="Hapus indikator"
            >
              <Trash2 size={14} />
            </button>
          </div>
        </div>
      </div>

      <div className="p-6">
        <div className="mb-4 flex items-center justify-between">
          <h3 className="text-sm font-semibold text-slate-800">
            Parameter ({indikator.parameter.length})
          </h3>
          <button
            type="button"
            onClick={() => onTambahParameter(indikator)}
            className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-brand-800"
          >
            <Plus size={14} />
            Tambah Parameter
          </button>
        </div>

       {children ?? (
         <div className="rounded-lg border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
             <p className="text-sm text-slate-500">
                 Belum ada parameter. Klik "+ Tambah Parameter" untuk menambahkan.
             </p>
         </div>
        )}
      </div>
    </div>
  )
}