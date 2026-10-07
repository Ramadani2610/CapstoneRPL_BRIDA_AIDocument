import { useEffect, useState } from 'react'
import Modal from '../../../components/ui/Modal'
import Toggle from '../../../components/ui/Toggle'
import { KATEGORI_OPTIONS, type Indikator, type IndikatorKategori } from './data'

type FormMode = 'tambah' | 'edit'

export interface IndikatorFormValues {
  kode: string
  nama: string
  kategori: IndikatorKategori
  deskripsi: string
  aktif: boolean
}

interface IndikatorFormModalProps {
  open: boolean
  mode: FormMode
  initialIndikator?: Indikator | null
  onClose: () => void
  onSubmit: (data: IndikatorFormValues) => void
}

const EMPTY_FORM: IndikatorFormValues = {
  kode: '',
  nama: '',
  kategori: 'Satuan Pemerintah Daerah',
  deskripsi: '',
  aktif: true,
}

export default function IndikatorFormModal({
  open,
  mode,
  initialIndikator,
  onClose,
  onSubmit,
}: IndikatorFormModalProps) {
  const [form, setForm] = useState<IndikatorFormValues>(EMPTY_FORM)
  const [errors, setErrors] = useState<Partial<Record<keyof IndikatorFormValues, string>>>({})

  useEffect(() => {
    if (!open) return
    if (mode === 'edit' && initialIndikator) {
      setForm({
        kode: initialIndikator.kode,
        nama: initialIndikator.nama,
        kategori: initialIndikator.kategori,
        deskripsi: initialIndikator.deskripsi,
        aktif: initialIndikator.aktif,
      })
    } else {
      setForm(EMPTY_FORM)
    }
    setErrors({})
  }, [open, mode, initialIndikator])

  const updateField = <K extends keyof IndikatorFormValues>(
    key: K,
    value: IndikatorFormValues[K],
  ) => {
    setForm((prev) => ({ ...prev, [key]: value }))
    setErrors((prev) => ({ ...prev, [key]: undefined }))
  }

  const validate = (): boolean => {
    const nextErrors: Partial<Record<keyof IndikatorFormValues, string>> = {}
    if (!form.kode.trim()) nextErrors.kode = 'Kode wajib diisi.'
    if (!form.nama.trim()) nextErrors.nama = 'Nama indikator wajib diisi.'
    setErrors(nextErrors)
    return Object.keys(nextErrors).length === 0
  }

  const handleSubmit = () => {
    if (!validate()) return
    onSubmit(form)
  }

  const title = mode === 'tambah' ? 'Tambah Indikator' : 'Edit Indikator'
  const submitLabel = mode === 'tambah' ? 'Simpan Indikator' : 'Simpan Perubahan'

  return (
    <Modal
      open={open}
      onClose={onClose}
      title={title}
      footer={
        <>
          <button
            type="button"
            onClick={onClose}
            className="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
          >
            Batal
          </button>
          <button
            type="button"
            onClick={handleSubmit}
            className="rounded-lg bg-brand-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-800"
          >
            {submitLabel}
          </button>
        </>
      }
    >
      <div className="space-y-4">
        <div className="grid grid-cols-[120px_1fr] gap-3">
          <Field label="Kode" required error={errors.kode}>
            <input
              type="text"
              value={form.kode}
              onChange={(e) => updateField('kode', e.target.value)}
              placeholder="IND-09"
              className={inputClass(!!errors.kode)}
            />
          </Field>
          <Field label="Nama Indikator" required error={errors.nama}>
            <input
              type="text"
              value={form.nama}
              onChange={(e) => updateField('nama', e.target.value)}
              className={inputClass(!!errors.nama)}
            />
          </Field>
        </div>

        <Field label="Kategori">
          <select
            value={form.kategori}
            onChange={(e) => updateField('kategori', e.target.value as IndikatorKategori)}
            className={inputClass(false)}
          >
            {KATEGORI_OPTIONS.map((k) => (
              <option key={k} value={k}>
                {k}
              </option>
            ))}
          </select>
        </Field>

        <Field label="Deskripsi">
          <textarea
            value={form.deskripsi}
            onChange={(e) => updateField('deskripsi', e.target.value)}
            rows={3}
            className={[inputClass(false), 'resize-none'].join(' ')}
          />
        </Field>

        <div className="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
          <div>
            <p className="text-sm font-medium text-slate-700">Status Indikator</p>
            <p className="text-xs text-slate-500">
              {form.aktif
                ? 'Aktif — dapat dipilih oleh inovator.'
                : 'Nonaktif — tidak dapat dipilih oleh inovator.'}
            </p>
          </div>
          <Toggle checked={form.aktif} onChange={(next) => updateField('aktif', next)} />
        </div>
      </div>
    </Modal>
  )
}

interface FieldProps {
  label: string
  required?: boolean
  error?: string
  children: React.ReactNode
}

function Field({ label, required, error, children }: FieldProps) {
  return (
    <div>
      <label className="mb-1 block text-sm font-medium text-slate-700">
        {label}
        {required ? <span className="ml-0.5 text-rose-600">*</span> : null}
      </label>
      {children}
      {error ? <p className="mt-1 text-xs text-rose-600">{error}</p> : null}
    </div>
  )
}

function inputClass(hasError: boolean): string {
  return [
    'w-full rounded-lg border bg-white px-3 py-2 text-sm text-slate-700 transition',
    'focus:outline-none focus:ring-1',
    hasError
      ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500'
      : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500',
  ].join(' ')
}