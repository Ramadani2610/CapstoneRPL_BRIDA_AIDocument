import { useNavigate } from 'react-router-dom'
import Badge from '../../../components/ui/Badge'
import Button from '../../../components/ui/Button'
import Card from '../../../components/ui/Card'
import PageHeader from '../../../components/ui/PageHeader'
import { AlertCircleIcon, ArrowRightIcon, EyeIcon, PencilIcon, PlusIcon, SearchIcon, TrashIcon } from '../../../components/icons'
import { DEMO_PROFILE, ROLES } from '../../../config/roles'
import { useRole } from '../../../lib/role'

// MODUL: Dashboard Inovator (3.2.3 Melihat Dashboard)


type StatusKey = 'draft' | 'proses' | 'revisi' | 'selesai'

interface Submission {
  id: string
  title: string
  category: string
  date: string
  status: StatusKey
  done: number
  total: number
}

const STATUS_BADGE: Record<StatusKey, { label: string; variant: StatusKey }> = {
  draft: { label: 'Draft', variant: 'draft' },
  proses: { label: 'Dalam Proses Verifikasi', variant: 'proses' },
  revisi: { label: 'Perlu Perbaikan', variant: 'revisi' },
  selesai: { label: 'Disetujui', variant: 'selesai' },
}

const SUBMISSIONS: Submission[] = [
  { id: 'INV-2026-014', title: 'Lorong Wisata Digital Makassar', category: 'Pelayanan Publik', date: '25 Sep 2026', status: 'draft', done: 1, total: 3 },
  { id: 'INV-2026-011', title: 'Makassar Sehat Mobile (MaSeMo)', category: 'Pelayanan Publik', date: '18 Sep 2026', status: 'revisi', done: 4, total: 4 },
  { id: 'INV-2026-009', title: 'Dashboard Command Center Penanganan Banjir', category: 'Tata Kelola Pemerintahan', date: '20 Sep 2026', status: 'proses', done: 5, total: 5 },
  { id: 'INV-2026-012', title: 'Si-Lapor Sampah Lorong', category: 'Pelayanan Publik', date: '22 Sep 2026', status: 'proses', done: 3, total: 3 },
  { id: 'INV-2026-006', title: 'E-Retribusi Pasar Terpadu', category: 'Tata Kelola Pemerintahan', date: '14 Jul 2026', status: 'selesai', done: 4, total: 4 },
  { id: 'INV-2026-002', title: 'Pelayanan KTP Keliling Terjadwal', category: 'Pelayanan Publik', date: '02 Jun 2026', status: 'selesai', done: 3, total: 3 },
]

function Stat({ label, value, note, emphasis = false }: { label: string; value: number; note: string; emphasis?: boolean }) {
  return (
    <div className="flex-1 px-5 py-5">
      <p className="text-xs font-medium text-muted">{label}</p>
      <p className={'mt-2 text-[30px] font-bold leading-none ' + (emphasis ? 'text-status-revisi-ink' : 'text-ink')}>{value}</p>
      <p className="mt-3 text-xs text-muted">{note}</p>
    </div>
  )
}

function Progress({ done, total }: { done: number; total: number }) {
  const percent = total > 0 ? Math.round((done / total) * 100) : 0
  const complete = total > 0 && done >= total
  return (
    <div className="flex items-center gap-3">
      <div className="h-1.5 w-24 rounded-full bg-status-track">
        <div
          className={'h-1.5 rounded-full ' + (complete ? 'bg-status-fill' : 'bg-brand-600')}
          style={{ width: `${percent}%` }}
        />
      </div>
      <span className="text-xs text-muted">
        {done}/{total}
      </span>
    </div>
  )
}

export default function DashboardInovatorPage() {
  const { role } = useRole()
  const navigate = useNavigate()
  const profile = DEMO_PROFILE[role] ?? DEMO_PROFILE[ROLES.INOVATOR]
  const firstName = profile.name.split(' ')[0]

  const counts = {
    draft: SUBMISSIONS.filter((item) => item.status === 'draft').length,
    proses: SUBMISSIONS.filter((item) => item.status === 'proses').length,
    revisi: SUBMISSIONS.filter((item) => item.status === 'revisi').length,
    selesai: SUBMISSIONS.filter((item) => item.status === 'selesai').length,
  }

  return (
    <div className="space-y-6">
      <PageHeader
        breadcrumb="Dashboard"
        title={`Selamat datang, ${firstName}`}
        subtitle="Pantau progres pengajuan inovasi Anda dan lengkapi dokumen yang diminta verifikator."
        action={
          <Button onClick={() => navigate('/inovator/pengajuan/baru')}>
            <PlusIcon className="size-4" />
            Buat Pengajuan Inovasi Baru
          </Button>
        }
      />

      {/* Pemberitahuan perbaikan dokumen */}
      <div className="flex flex-wrap items-center justify-between gap-4 rounded-xl border border-status-revisi-ink/15 bg-status-revisi/50 px-4 py-4">
        <div className="flex items-start gap-4">
          <AlertCircleIcon className="mt-0.5 size-5 shrink-0 text-status-revisi-ink" />
          <div>
            <p className="text-sm font-semibold text-status-revisi-ink">1 pengajuan perlu perbaikan</p>
            <p className="mt-1 text-sm text-brand-900/70">
              Verifikator meminta revisi dokumen pada “Makassar Sehat Mobile (MaSeMo)”. Batas perbaikan 3 Okt 2026.
            </p>
          </div>
        </div>
        <Button size="sm" className="h-8">
          Perbaiki sekarang
          <ArrowRightIcon className="size-3.5" />
        </Button>
      </div>

      {/* Ringkasan status pengajuan */}
      <Card className="flex flex-col divide-y divide-line overflow-hidden md:flex-row md:divide-x md:divide-y-0">
        <Stat label="Draft" value={counts.draft} note="Belum dikirim" />
        <Stat label="Dalam Proses Verifikasi" value={counts.proses} note="Sedang ditinjau" />
        <Stat label="Perlu Perbaikan" value={counts.revisi} note="Butuh tindakan Anda" emphasis />
        <Stat label="Disetujui" value={counts.selesai} note="Tahun 2026" />
      </Card>

      {/* Daftar pengajuan */}
      <Card className="overflow-hidden">
        <div className="flex flex-wrap items-center justify-between gap-4 border-b border-line px-5 py-4">
          <h2 className="text-base font-semibold text-ink">Daftar Pengajuan</h2>
          <div className="relative w-full max-w-xs">
            <SearchIcon className="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted" />
            <input
              type="search"
              placeholder="Cari judul atau ID pengajuan"
              className="h-10 w-full rounded-lg border border-line bg-white pl-9 pr-3 text-sm text-ink placeholder:text-[#9ca3af] focus:border-brand-400 focus:outline-none"
            />
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full min-w-[900px] text-left">
            <thead className="bg-canvas/60 text-xs font-semibold text-muted">
              <tr>
                <th className="px-4 py-3 font-semibold">Judul Inovasi</th>
                <th className="px-4 py-3 font-semibold">Tanggal</th>
                <th className="px-4 py-3 font-semibold">Status</th>
                <th className="px-4 py-3 font-semibold">Kelengkapan Dokumen</th>
                <th className="px-4 py-3 text-right font-semibold">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-line">
              {SUBMISSIONS.map((item) => {
                const badge = STATUS_BADGE[item.status]
                return (
                  <tr key={item.id} className="hover:bg-brand-50/40">
                    <td className="px-4 py-4">
                      <p className="text-sm font-medium text-ink">{item.title}</p>
                      <p className="mt-1 text-xs text-muted">
                        {item.id} · {item.category}
                      </p>
                    </td>
                    <td className="px-4 py-4 text-sm text-ink">{item.date}</td>
                    <td className="px-4 py-4">
                      <Badge variant={badge.variant}>{badge.label}</Badge>
                    </td>
                    <td className="px-4 py-4">
                      <Progress done={item.done} total={item.total} />
                    </td>
                    <td className="px-4 py-4">
                      <div className="flex items-center justify-end gap-1">
                        <button type="button" title="Lihat detail" className="flex size-9 items-center justify-center rounded-lg text-muted hover:bg-canvas">
                          <EyeIcon className="size-4" />
                        </button>
                        <button type="button" title="Ubah pengajuan" className="flex size-9 items-center justify-center rounded-lg text-muted hover:bg-canvas">
                          <PencilIcon className="size-4" />
                        </button>
                        <button
                          type="button"
                          title={item.status === 'draft' ? 'Hapus draft' : 'Lihat riwayat'}
                          className="flex size-9 items-center justify-center rounded-lg text-muted hover:bg-canvas"
                        >
                          {item.status === 'draft' ? <TrashIcon className="size-4" /> : <HistoryMark />}
                        </button>
                      </div>
                    </td>
                  </tr>
                )
              })}
            </tbody>
          </table>
        </div>
      </Card>
    </div>
  )
}

function HistoryMark() {
  return (
    <span className="text-muted">
      <svg viewBox="0 0 16 16" className="size-4" fill="none" stroke="currentColor" strokeWidth={2} strokeLinecap="round" strokeLinejoin="round">
        <path d="M2 8C2 11.3137 4.68629 14 8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C6.32263 2.00631 4.71265 2.66082 3.50667 3.82667L2 5.33333" />
        <path d="M2 2V5.33H5.33" />
        <path d="M8 4.67V8.00571L10.67 9.34" />
      </svg>
    </span>
  )
}
