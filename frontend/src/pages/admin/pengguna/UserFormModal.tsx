import { useEffect, useState } from 'react'
import Modal from '../../../components/ui/Modal'
import Toggle from '../../../components/ui/Toggle'
import { OPD_OPTIONS, ROLE_OPTIONS, type User, type UserRole } from './data'

type FormMode = 'tambah' | 'edit'

interface UserFormModalProps {
  open: boolean
  mode: FormMode
  initialUser?: User | null
  onClose: () => void
  onSubmit: (data: UserFormValues) => void
}

export interface UserFormValues {
  nama: string
  email: string
  opd: string
  peran: UserRole
  aktif: boolean
}

const EMPTY_FORM: UserFormValues = {
  nama: '',
  email: '',
  opd: '',
  peran: 'Inovator',
  aktif: true,
}

export default function UserFormModal({
  open,
  mode,
  initialUser,
  onClose,
  onSubmit,
}: UserFormModalProps) {
  const [form, setForm] = useState<UserFormValues>(EMPTY_FORM)
  const [errors, setErrors] = useState<Partial<Record<keyof UserFormValues, string>>>({})

  // Reset form setiap modal dibuka: isi dari initialUser (mode edit) atau kosong (mode tambah).
  useEffect(() => {
    if (!open) return
    if (mode === 'edit' && initialUser) {
      setForm({
        nama: initialUser.nama,
        email: initialUser.email,
        opd: initialUser.opd,
        peran: initialUser.peran,
        aktif: initialUser.aktif,
      })
    } else {
      setForm(EMPTY_FORM)
    }
    setErrors({})
  }, [open, mode, initialUser])

  const updateField = <K extends keyof UserFormValues>(key: K, value: UserFormValues[K]) => {
    setForm((prev) => ({ ...prev, [key]: value }))
    setErrors((prev) => ({ ...prev, [key]: undefined }))
  }

  const validate = (): boolean => {
    const nextErrors: Partial<Record<keyof UserFormValues, string>> = {}
    if (!form.nama.trim()) nextErrors.nama = 'Nama lengkap wajib diisi.'
    if (!form.email.trim()) {
      nextErrors.email = 'Email dinas wajib diisi.'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
      nextErrors.email = 'Format email tidak valid.'
    }
    if (!form.opd) nextErrors.opd = 'OPD / Instansi wajib dipilih.'
    setErrors(nextErrors)
    return Object.keys(nextErrors).length === 0
  }

  const handleSubmit = () => {
    if (!validate()) return
    onSubmit(form)
  }

  const title = mode === 'tambah' ? 'Tambah Pengguna' : 'Edit Pengguna'
  const subtitle =
    mode === 'tambah'
      ? 'Undangan aktivasi akan dikirim ke email pengguna.'
      : initialUser?.email
  const submitLabel = mode === 'tambah' ? 'Tambah Pengguna' : 'Simpan Perubahan'

  return (
    <Modal
      open={open}
      onClose={onClose}
      title={title}
      subtitle={subtitle}
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
        <Field label="Nama Lengkap" required error={errors.nama}>
          <input
            type="text"
            value={form.nama}
            onChange={(e) => updateField('nama', e.target.value)}
            className={inputClass(!!errors.nama)}
          />
        </Field>

        <Field label="Email Dinas" required error={errors.email}>
          <input
            type="email"
            value={form.email}
            onChange={(e) => updateField('email', e.target.value)}
            placeholder="nama@makassarkota.go.id"
            className={inputClass(!!errors.email)}
          />
        </Field>

        <Field label="OPD / Instansi" required error={errors.opd}>
          <select
            value={form.opd}
            onChange={(e) => updateField('opd', e.target.value)}
            className={inputClass(!!errors.opd)}
          >
            <option value="">— Pilih OPD / Instansi —</option>
            {OPD_OPTIONS.map((opd) => (
              <option key={opd} value={opd}>
                {opd}
              </option>
            ))}
          </select>
        </Field>

        <Field label="Peran">
          <select
            value={form.peran}
            onChange={(e) => updateField('peran', e.target.value as UserRole)}
            className={inputClass(false)}
          >
            {ROLE_OPTIONS.map((role) => (
              <option key={role} value={role}>
                {role}
              </option>
            ))}
          </select>
        </Field>

        <div className="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
          <div>
            <p className="text-sm font-medium text-slate-700">Status Akun</p>
            <p className="text-xs text-slate-500">
              {form.aktif
                ? 'Aktif — pengguna dapat masuk.'
                : 'Nonaktif — pengguna tidak dapat masuk.'}
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