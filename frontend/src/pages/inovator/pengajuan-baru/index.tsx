import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import Badge from '../../../components/ui/Badge'
import Button from '../../../components/ui/Button'
import Card from '../../../components/ui/Card'
import PageHeader from '../../../components/ui/PageHeader'
import { CheckIcon } from '../../../components/icons'

// MODUL: Pengajuan Baru (3.2.1 - 3.2.6), baru langkah 1 yang dibuat.

const STEPS = [
  { no: 1, label: 'Info Dasar' },
  { no: 2, label: 'Pilih Indikator' },
  { no: 3, label: 'Upload Dokumen' },
  { no: 4, label: 'Tinjau & Kirim' },
]

const KATEGORI = ['Pilih kategori', 'Tata Kelola Pemerintahan', 'Pelayanan Publik', 'Bentuk Inovasi Daerah Lainnya']

const OPD = [
  'Pilih OPD',
  'BRIDA Kota Makassar',
  'Dinas Komunikasi dan Informatika',
  'Dinas Kesehatan',
  'Dinas Pendidikan',
  'Dinas Perhubungan',
  'Dinas Lingkungan Hidup',
  'Dinas Pekerjaan Umum',
  'Dinas Perdagangan',
  'Dinas Kependudukan dan Pencatatan Sipil',
  'Kecamatan Tamalate',
  'Kecamatan Panakkukang',
]

function Stepper({ active, onStep }: { active: number; onStep?: (step: number) => void }) {
  return (
    <Card className="px-5 py-4">
      <ol className="flex items-center">
        {STEPS.map((step, index) => {
          const done = step.no < active
          const current = step.no === active
          return (
            <li key={step.no} className={'flex items-center ' + (index < STEPS.length - 1 ? 'flex-1' : '')}>
              <button
                type="button"
                onClick={() => onStep?.(step.no)}
                className="flex items-center gap-2 rounded-lg text-left"
              >
                <span
                  className={
                    'flex size-8 shrink-0 items-center justify-center rounded-full text-sm font-semibold ' +
                    (current
                      ? 'bg-brand-600 text-white'
                      : done
                        ? 'bg-status-selesai text-status-selesai-ink'
                        : 'bg-canvas text-muted')
                  }
                >
                  {done ? <CheckIcon className="size-4" /> : step.no}
                </span>
                <span className={'whitespace-nowrap text-sm ' + (current ? 'font-semibold text-ink' : 'text-muted')}>
                  {step.label}
                </span>
              </button>
              {index < STEPS.length - 1 ? <span className="mx-4 h-px flex-1 bg-[#ded3d3]" /> : null}
            </li>
          )
        })}
      </ol>
    </Card>
  )
}

function Field({
  label,
  required = false,
  hint,
  children,
}: {
  label: string
  required?: boolean
  hint?: string
  children: React.ReactNode
}) {
  return (
    <label className="block">
      <span className="text-sm font-medium text-ink">
        {label} {required ? <span className="text-status-revisi-ink">*</span> : null}
      </span>
      {hint ? <span className="mt-1 block text-xs text-muted">{hint}</span> : null}
      <div className="mt-2">{children}</div>
    </label>
  )
}

const inputClass =
  'h-10 w-full rounded-lg border border-line bg-white px-3 text-sm text-ink placeholder:text-[#9ca3af] focus:border-brand-400 focus:outline-none'

export default function PengajuanBaruPage() {
  const navigate = useNavigate()
  const [judul, setJudul] = useState('')
  const [deskripsi, setDeskripsi] = useState('')
  const [kategori, setKategori] = useState(KATEGORI[0])
  const [namaInovator, setNamaInovator] = useState('')
  const [opd, setOpd] = useState(OPD[0])

  const kelengkapan = [
    { label: 'Judul inovasi (min. 10 karakter)', ok: judul.trim().length >= 10 },
    { label: 'Kategori inovasi', ok: kategori !== KATEGORI[0] },
    { label: 'Deskripsi (min. 50 karakter)', ok: deskripsi.trim().length >= 50 },
    { label: 'Nama inovator atau tim', ok: namaInovator.trim().length > 0 },
    { label: 'Perangkat daerah pengusul', ok: opd !== OPD[0] },
  ]
  const jumlahLengkap = kelengkapan.filter((item) => item.ok).length
  const stepSelesai = jumlahLengkap === kelengkapan.length

  return (
    <div className="space-y-6">
      <PageHeader
        breadcrumb="Pengajuan Baru"
        title="Buat Pengajuan Inovasi"
        subtitle="Isi informasi dasar inovasi. Perubahan tersimpan otomatis sebagai draft."
        action={
          <span className="inline-flex items-center gap-2 rounded-full bg-canvas px-3 py-1.5 text-xs text-muted">
            <span className="size-2 rounded-full bg-status-proses-ink" />
            Tersimpan sebagai Draft
          </span>
        }
      />

      <Stepper active={1} onStep={(step) => step === 1 && navigate('/inovator/pengajuan/baru')} />

      <div className="grid gap-6 lg:grid-cols-3">
        <div className="space-y-6 lg:col-span-2">
          <Card className="p-5">
            <h2 className="text-base font-semibold text-ink">Informasi Inovasi</h2>

            <div className="mt-5 space-y-5">
              <Field label="Judul Inovasi" required>
                <input
                  className={inputClass}
                  placeholder="Contoh: Lorong Wisata Digital Makassar"
                  value={judul}
                  onChange={(event) => setJudul(event.target.value)}
                />
              </Field>

              <Field label="Kategori" required>
                <select
                  className={inputClass}
                  value={kategori}
                  onChange={(event) => setKategori(event.target.value)}
                >
                  {KATEGORI.map((item) => (
                    <option key={item}>{item}</option>
                  ))}
                </select>
              </Field>

              <Field label="Tanggal Mulai Uji Coba" hint="Digunakan untuk indikator kecepatan inovasi.">
                <input type="date" className={inputClass} />
              </Field>

              <Field
                label="Deskripsi Inovasi"
                required
                hint={`${deskripsi.length}/1000 karakter · jelaskan masalah, solusi, dan dampak.`}
              >
                <textarea
                  rows={5}
                  maxLength={1000}
                  value={deskripsi}
                  onChange={(event) => setDeskripsi(event.target.value)}
                  className="w-full rounded-lg border border-line bg-white px-3 py-2 text-sm text-ink placeholder:text-[#9ca3af] focus:border-brand-400 focus:outline-none"
                />
              </Field>
            </div>

            <h3 className="mt-8 text-base font-semibold text-ink">Inovator</h3>
            <div className="mt-5 grid gap-5 md:grid-cols-2">
              <Field label="Nama Inovator / Tim" required>
                <input
                  className={inputClass}
                  placeholder="Nama penanggung jawab inovasi"
                  value={namaInovator}
                  onChange={(event) => setNamaInovator(event.target.value)}
                />
              </Field>
              <Field label="Perangkat Daerah (OPD)" required>
                <select className={inputClass} value={opd} onChange={(event) => setOpd(event.target.value)}>
                  {OPD.map((item) => (
                    <option key={item}>{item}</option>
                  ))}
                </select>
              </Field>
            </div>
          </Card>

          <Card className="p-5">
            <h2 className="text-base font-semibold text-ink">
              Info Pendukung <span className="text-sm font-normal text-muted">(opsional)</span>
            </h2>

            <div className="mt-5 space-y-5">
              <Field label="Tautan Video / Dokumentasi">
                <input className={inputClass} placeholder="https://" />
              </Field>
              <Field label="Catatan Tambahan">
                <textarea
                  rows={3}
                  className="w-full rounded-lg border border-line bg-white px-3 py-2 text-sm text-ink placeholder:text-[#9ca3af] focus:border-brand-400 focus:outline-none"
                  placeholder="Informasi lain yang membantu verifikator memahami inovasi"
                />
              </Field>
            </div>
          </Card>

          <div className="flex flex-wrap items-center justify-between gap-3">
            <Button variant="secondary">Simpan Draft</Button>
            <Button disabled={!stepSelesai} onClick={() => navigate('/inovator/dashboard')}>
              Lanjut Pilih Indikator
            </Button>
          </div>
        </div>

        <div className="space-y-4">
          <Card className="p-5">
            <div className="flex items-center justify-between">
              <h2 className="text-sm font-semibold text-ink">Kelengkapan Info Dasar</h2>
              <Badge variant={stepSelesai ? 'selesai' : 'draft'}>
                {jumlahLengkap}/{kelengkapan.length}
              </Badge>
            </div>
            <ul className="mt-4 space-y-3">
              {kelengkapan.map((item) => (
                <li key={item.label} className="flex items-start gap-2 text-sm text-ink">
                  <CheckIcon
                    className={'mt-0.5 size-4 shrink-0 ' + (item.ok ? 'text-status-selesai-ink' : 'text-line')}
                  />
                  {item.label}
                </li>
              ))}
            </ul>
          </Card>

          <Card className="p-5">
            <p className="text-sm text-muted">
              Kategori menentukan indikator yang relevan. Pilih{' '}
              <span className="font-medium text-ink">Tata Kelola Pemerintahan</span> untuk inovasi internal, dan{' '}
              <span className="font-medium text-ink">Pelayanan Publik</span> untuk layanan langsung ke warga.
            </p>
          </Card>
        </div>
      </div>
    </div>
  )
}
