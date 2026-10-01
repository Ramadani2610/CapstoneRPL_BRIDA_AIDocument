import { ChevronRight, Home, Settings2, Users } from 'lucide-react'
import { Link } from 'react-router-dom'
import { Bar, BarChart, Cell, ResponsiveContainer, Tooltip, XAxis } from 'recharts'
import StatCard from '../../../components/ui/StatCard'
import {
  AKTIVITAS_TERBARU,
  GRAFIK_BULANAN,
  RINGKASAN_INDIKATOR,
  RINGKASAN_INOVASI,
  RINGKASAN_PENGGUNA,
  TANGGAL_RINGKASAN,
  type AktivitasItem,
} from './data'

// Palet badge aktivitas - selaras dengan Figma.
const BADGE_STYLE: Record<AktivitasItem['status'], string> = {
  'analisis-ai': 'bg-sky-50 text-sky-700',
  ocr: 'bg-slate-100 text-slate-700',
  pengajuan: 'bg-rose-50 text-rose-700',
  'minta-dokumen': 'bg-amber-50 text-amber-700',
  gagal: 'bg-rose-100 text-rose-700',
}

const BADGE_LABEL: Record<AktivitasItem['status'], string> = {
  'analisis-ai': 'Analisis AI selesai',
  ocr: 'OCR selesai',
  pengajuan: 'Pengajuan dikirim',
  'minta-dokumen': 'Minta dokumen tambahan',
  gagal: 'Pemrosesan gagal',
}

function getInitials(name: string): string {
  const words = name.trim().split(/\s+/)
  if (words.length >= 2) {
    return (words[0][0] + words[1][0]).toUpperCase()
  }
  return name.replace(/[^a-zA-Z]/g, '').slice(0, 2).toUpperCase()
}

export default function DashboardAdminPage() {
  return (
    <div className="space-y-6">
      <Breadcrumb />
      <Heading />

      <div className="grid gap-6 lg:grid-cols-3">
        <KartuInovasi />
        <KartuPenggunaDanIndikator />
      </div>

      <div className="grid gap-6 lg:grid-cols-3">
        <KartuShortcut />
        <KartuAktivitas />
      </div>
    </div>
  )
}

function Breadcrumb() {
  return (
    <nav className="flex items-center gap-2 text-sm text-slate-500">
      <Home size={15} />
      <ChevronRight size={14} />
      <span className="text-slate-700">Dashboard</span>
    </nav>
  )
}

function Heading() {
  return (
    <div>
      <h1 className="text-2xl font-semibold text-slate-900">Ringkasan Sistem</h1>
      <p className="mt-1 text-sm text-slate-500">
        Kondisi pemrosesan dokumen inovasi dan konfigurasi SIGAP per {TANGGAL_RINGKASAN}.
      </p>
    </div>
  )
}

function KartuInovasi() {
  return (
    <StatCard
      className="lg:col-span-2"
      title="Total Inovasi Diproses"
      value={RINGKASAN_INOVASI.totalDiproses}
      trend={`📈 ${RINGKASAN_INOVASI.pertumbuhan}`}
      breakdown={[
        { label: 'Disetujui', value: RINGKASAN_INOVASI.disetujui, tone: 'success' },
        { label: 'Perbaikan', value: RINGKASAN_INOVASI.perbaikan, tone: 'warning' },
        { label: 'Ditolak', value: RINGKASAN_INOVASI.ditolak, tone: 'danger' },
        { label: 'Diproses', value: RINGKASAN_INOVASI.diproses },
      ]}
    >
      <div className="h-48 w-full">
        <ResponsiveContainer width="100%" height="100%">
          <BarChart data={GRAFIK_BULANAN} margin={{ top: 20, right: 10, left: 10, bottom: 0 }}>
            <XAxis
              dataKey="bulan"
              axisLine={false}
              tickLine={false}
              tick={{ fill: '#64748b', fontSize: 12 }}
            />
            <Tooltip
              cursor={{ fill: 'rgba(0,0,0,0.03)' }}
              contentStyle={{
                borderRadius: 8,
                border: '1px solid #e2e8f0',
                fontSize: 12,
              }}
            />
            <Bar dataKey="jumlah" radius={[6, 6, 0, 0]} label={{ position: 'top', fontSize: 12, fill: '#334155' }}>
              {GRAFIK_BULANAN.map((item, index) => (
                <Cell
                  key={item.bulan}
                  fill={index === GRAFIK_BULANAN.length - 1 ? '#991b1b' : '#fecaca'}
                />
              ))}
            </Bar>
          </BarChart>
        </ResponsiveContainer>
      </div>
    </StatCard>
  )
}

function KartuPenggunaDanIndikator() {
  return (
    <div className="space-y-6">
      <StatCard title="Total Pengguna" value={RINGKASAN_PENGGUNA.total}>
        <BreakdownBar />
        <ul className="mt-3 space-y-1 text-xs text-slate-600">
          {RINGKASAN_PENGGUNA.breakdown.map((item) => (
            <li key={item.peran} className="flex items-center justify-between">
              <span className="flex items-center gap-2">
                <span className="h-2 w-2 rounded-full bg-brand-600" />
                {item.peran}
              </span>
              <span className="font-medium text-slate-700">{item.jumlah}</span>
            </li>
          ))}
        </ul>
      </StatCard>

      <StatCard
        title="Indikator Aktif"
        value={
          <span>
            {RINGKASAN_INDIKATOR.aktif}
            <span className="text-xl text-slate-400"> / {RINGKASAN_INDIKATOR.total}</span>
          </span>
        }
        trend={`${RINGKASAN_INDIKATOR.parameterAktif} parameter penilaian aktif`}
      />
    </div>
  )
}

function BreakdownBar() {
  const total = RINGKASAN_PENGGUNA.total
  const inovatorPct = (RINGKASAN_PENGGUNA.breakdown[0].jumlah / total) * 100

  return (
    <div className="mt-3 h-2 w-full overflow-hidden rounded-full bg-slate-100">
      <div
        className="h-full rounded-full bg-gradient-to-r from-brand-800 via-rose-400 to-rose-200"
        style={{ width: `${inovatorPct + 20}%` }}
      />
    </div>
  )
}

function KartuShortcut() {
  const shortcuts = [
    {
      icon: Users,
      title: 'Kelola Akun Pengguna',
      description: 'Tambah pengguna, atur peran, dan status akun.',
      href: '/admin/pengguna',
    },
    {
      icon: Settings2,
      title: 'Konfigurasi Indikator & Parameter',
      description: 'Atur kriteria pemenuhan dan contoh dokumen.',
      href: '/admin/indikator',
    },
  ]

  return (
    <div className="space-y-4">
      {shortcuts.map((item) => (
        <Link
          key={item.href}
          to={item.href}
          className="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 transition hover:border-brand-300 hover:bg-brand-50"
        >
          <div className="rounded-xl bg-slate-100 p-3 text-slate-600 group-hover:bg-white group-hover:text-brand-700">
            <item.icon size={20} />
          </div>
          <div className="min-w-0 flex-1">
            <p className="text-sm font-semibold text-slate-800 group-hover:text-brand-700">
              {item.title}
            </p>
            <p className="mt-1 text-xs text-slate-500">{item.description}</p>
          </div>
          <ChevronRight size={18} className="mt-2 text-slate-400" />
        </Link>
      ))}
    </div>
  )
}

function KartuAktivitas() {
  return (
    <div className="rounded-2xl border border-slate-200 bg-white p-6 lg:col-span-2">
      <div className="flex items-center justify-between">
        <h2 className="text-sm font-semibold text-slate-800">Aktivitas Terbaru</h2>
        <Link to="/admin/log-audit" className="text-xs font-medium text-brand-700 hover:underline">
          Lihat semua
        </Link>
      </div>
      <ul className="mt-4 divide-y divide-slate-100">
        {AKTIVITAS_TERBARU.map((item, index) => (
          <li key={index} className="flex items-start gap-4 py-3">
            <div className="w-20 shrink-0 text-xs text-slate-500">
              <p className="font-medium text-slate-700">{item.tanggal}</p>
              <p>{item.waktu}</p>
            </div>
            <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-600">
              {getInitials(item.aktor)}
            </div>
            <div className="min-w-0 flex-1">
              <p className="text-sm text-slate-800">
                <span className="font-semibold">{item.aktor}</span>
                <span className="text-slate-500"> — {item.keterangan}</span>
              </p>
            </div>
            <span
              className={[
                'shrink-0 rounded-full px-2.5 py-0.5 text-xs font-medium',
                BADGE_STYLE[item.status],
              ].join(' ')}
            >
              • {BADGE_LABEL[item.status]}
            </span>
          </li>
        ))}
      </ul>
    </div>
  )
}