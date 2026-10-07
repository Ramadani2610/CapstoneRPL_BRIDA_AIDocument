import { CheckCircle2, Pencil, Trash2, XCircle } from 'lucide-react'
import type { Parameter } from './data'

interface ParameterTableProps {
  parameters: Parameter[]
  onEdit: (parameter: Parameter) => void
  onDelete: (parameter: Parameter) => void
}

export default function ParameterTable({
  parameters,
  onEdit,
  onDelete,
}: ParameterTableProps) {
  if (parameters.length === 0) {
    return (
      <div className="rounded-lg border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
        <p className="text-sm text-slate-500">
          Belum ada parameter. Klik "+ Tambah Parameter" untuk menambahkan.
        </p>
      </div>
    )
  }

  return (
    <div className="overflow-x-auto rounded-lg border border-slate-200">
      <table className="w-full text-sm">
        <thead>
          <tr className="border-b border-slate-200 bg-slate-50 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
            <th className="px-4 py-2.5 w-16">Kode</th>
            <th className="px-4 py-2.5">Parameter & Kriteria Pemenuhan</th>
            <th className="px-4 py-2.5 w-44">Contoh Dokumen</th>
            <th className="px-4 py-2.5 w-20 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          {parameters.map((p) => (
            <tr key={p.id} className="border-b border-slate-100 last:border-0 align-top">
              <td className="px-4 py-3">
                <span className="rounded bg-slate-100 px-1.5 py-0.5 text-xs font-mono font-semibold text-slate-600">
                  {p.kode}
                </span>
              </td>
              <td className="px-4 py-3">
                <p className="font-medium text-slate-800">{p.nama}</p>
                {p.kriteria.length > 0 ? (
                  <ul className="mt-1 space-y-0.5 text-xs text-slate-600">
                    {p.kriteria.map((k, idx) => (
                      <li key={idx}>{k}</li>
                    ))}
                  </ul>
                ) : null}
              </td>
              <td className="px-4 py-3">
                <DocStatus label="Contoh benar" present={!!p.contohBenar} tone="success" />
                <DocStatus label="Contoh salah" present={!!p.contohSalah} tone="danger" />
              </td>
              <td className="px-4 py-3">
                <div className="flex items-center justify-end gap-1">
                  <button
                    type="button"
                    onClick={() => onEdit(p)}
                    className="rounded-lg p-1.5 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                    aria-label={`Edit ${p.nama}`}
                  >
                    <Pencil size={14} />
                  </button>
                  <button
                    type="button"
                    onClick={() => onDelete(p)}
                    className="rounded-lg p-1.5 text-slate-500 transition hover:bg-rose-50 hover:text-rose-700"
                    aria-label={`Hapus ${p.nama}`}
                  >
                    <Trash2 size={14} />
                  </button>
                </div>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}

interface DocStatusProps {
  label: string
  present: boolean
  tone: 'success' | 'danger'
}

function DocStatus({ label, present, tone }: DocStatusProps) {
  if (!present) {
    return (
      <p className="text-xs italic text-slate-400">
        Belum ada {label.toLowerCase()}
      </p>
    )
  }
  const Icon = tone === 'success' ? CheckCircle2 : XCircle
  const colorClass = tone === 'success' ? 'text-emerald-600' : 'text-rose-600'
  return (
    <p className={['flex items-center gap-1 text-xs', colorClass].join(' ')}>
      <Icon size={13} />
      {label}
    </p>
  )
}