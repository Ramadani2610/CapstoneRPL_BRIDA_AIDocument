import { AlertTriangle, ArrowRight, ChevronLeft, ChevronRight, Clock, Search } from 'lucide-react'
import { useMemo, useState } from 'react'
import Badge from '../../../components/ui/Badge'
import Button from '../../../components/ui/Button'
import Card from '../../../components/ui/Card'
import { DEMO_PROFILE } from '../../../config/roles'
import { useRole } from '../../../lib/role'

/*
  MODUL: Antrian Review (verifikator)
  Acuan: SRS 3.2.11 Melihat Daftar Pengajuan Inovasi

  Halaman ini berfungsi sebagai CONTOH POLA untuk modul lain:
  hero + tab filter + tabel + pagination, memakai komponen dari components/ui.
  Silakan tiru susunannya, tapi jangan ubah file di luar folder ini.

  DATA MASIH DUMMY. Ganti `PENGAJUAN` dengan hasil api.get('/documents')
  (lihat src/lib/api.js) begitu endpoint backend siap.
*/
const PENGAJUAN = [
  {
    id: 'INV-2025-009',
    judul: 'Dashboard Command Center Penanganan Banjir',
    opd: 'Dinas Komunikasi dan Informatika',
    diajukan: '20 Sep 2025',
    dokumen: 5,
    aiStatus: 'lolos',
    aiLabel: 'Lolos',
    aiSkor: 92,
    status: 'menunggu',
    tab: 'menunggu',
  },
  {
    id: 'INV-2025-002',
    judul: 'Si-Lapor Sampah Lorong',
    opd: 'Dinas Komunikasi dan Informatika',
    diajukan: '22 Sep 2025',
    dokumen: 3,
    aiStatus: 'lolos',
    aiLabel: 'Lolos',
    aiSkor: 88,
    status: 'menunggu',
    tab: 'menunggu',
  },
  {
    id: 'INV-2025-025',
    judul: 'Posyandu Digital Terintegrasi',
    opd: 'Dinas Kesehatan',
    diajukan: '25 Sep 2025',
    dokumen: 3,
    aiStatus: 'rendah',
    aiLabel: 'Keyakinan Rendah',
    aiSkor: 64,
    status: 'menunggu',
    tab: 'menunggu',
  },
  {
    id: 'INV-2025-008',
    judul: 'Bank Sampah Lorong Garden',
    opd: 'Dinas Lingkungan Hidup',
    diajukan: '23 Sep 2025',
    dokumen: 2,
    aiStatus: 'rendah',
    aiLabel: 'Keyakinan Rendah',
    aiSkor: 62,
    status: 'menunggu',
    tab: 'menunggu',
  },
  {
    id: 'INV-2025-014',
    judul: 'Sistem Antrean Puskesmas Digital',
    opd: 'Dinas Kesehatan',
    diajukan: '18 Sep 2025',
    dokumen: 4,
    aiStatus: 'rendah',
    aiLabel: 'Keyakinan Rendah',
    aiSkor: 58,
    status: 'tambahan',
    tab: 'tambahan',
  },
  {
    id: 'INV-2025-019',
    judul: 'Kampung Wisata Digital Paotere',
    opd: 'Dinas Pariwisata',
    diajukan: '15 Sep 2025',
    dokumen: 2,
    aiStatus: 'rendah',
    aiLabel: 'Keyakinan Rendah',
    aiSkor: 55,
    status: 'tambahan',
    tab: 'tambahan',
  },
  {
    id: 'INV-2025-001',
    judul: 'E-Katalog UMKM Kota Makassar',
    opd: 'Dinas Perdagangan',
    diajukan: '02 Sep 2025',
    dokumen: 6,
    aiStatus: 'lolos',
    aiLabel: 'Lolos',
    aiSkor: 89,
    status: 'selesai',
    tab: 'selesai',
  },
  {
    id: 'INV-2025-005',
    judul: 'Peta Digital Titik Rawan Banjir',
    opd: 'Dinas Pekerjaan Umum',
    diajukan: '05 Sep 2025',
    dokumen: 3,
    aiStatus: 'lolos',
    aiLabel: 'Lolos',
    aiSkor: 81,
    status: 'selesai',
    tab: 'selesai',
  },
  {
    id: 'INV-2025-011',
    judul: 'Layanan Adminduk Terpadu',
    opd: 'Dinas Kependudukan dan Catatan Sipil',
    diajukan: '08 Sep 2025',
    dokumen: 4,
    aiStatus: 'lolos',
    aiLabel: 'Lolos',
    aiSkor: 78,
    status: 'selesai',
    tab: 'selesai',
  },
]

const TABS = [
  { key: 'menunggu', label: 'Menunggu Review' },
  { key: 'tambahan', label: 'Perlu Dokumen Tambahan' },
  { key: 'selesai', label: 'Selesai' },
]

const AI_VARIANT = { lolos: 'success', rendah: 'warning' }

export default function AntrianReviewPage() {
  const { role } = useRole()
  const [activeTab, setActiveTab] = useState('menunggu')
  const [query, setQuery] = useState('')

  const jumlahPerTab = useMemo(
    () =>
      TABS.reduce((total, tab) => {
        total[tab.key] = PENGAJUAN.filter((item) => item.tab === tab.key).length
        return total
      }, {}),
    [],
  )

  const baris = useMemo(() => {
    const kata = query.trim().toLowerCase()
    return PENGAJUAN.filter((item) => item.tab === activeTab).filter((item) => {
      if (!kata) return true
      return (
        item.judul.toLowerCase().includes(kata) ||
        item.id.toLowerCase().includes(kata) ||
        item.opd.toLowerCase().includes(kata)
      )
    })
  }, [activeTab, query])

  // Nanti diambil dari API. Sekarang pakai angka contoh.
  const gagalDiproses = 5

  return (
    <div className="space-y-5">
      {/* Hero / banner ringkasan */}
      <section className="rounded-xl bg-brand-600 p-6 text-white">
        <p className="text-sm text-white/80">
          Selamat pagi, {DEMO_PROFILE[role]?.name?.split(' ')[0] ?? 'Pengguna'}
        </p>
        <h1 className="mt-1 text-2xl font-semibold">Antrian Review Dokumen</h1>
        <p className="mt-1 max-w-2xl text-sm text-white/80">
          {jumlahPerTab.menunggu} pengajuan menunggu review Anda. Rekomendasi AI membantu,
          keputusan tetap di tangan Anda.
        </p>

        <div className="mt-5 max-w-xl">
          <div className="flex items-center gap-2 rounded-lg bg-white px-3 py-2.5">
            <Search size={16} className="text-slate-400" />
            <input
              value={query}
              onChange={(event) => setQuery(event.target.value)}
              placeholder="Cari judul, ID, OPD, atau inovator"
              className="w-full bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
            />
          </div>
        </div>
      </section>

      {/* Tab filter status */}
      <div className="flex flex-wrap items-center justify-between gap-3">
        <div className="flex flex-wrap gap-2">
          {TABS.map((tab) => {
            const aktif = tab.key === activeTab
            return (
              <button
                key={tab.key}
                type="button"
                onClick={() => setActiveTab(tab.key)}
                className={[
                  'inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm transition',
                  aktif
                    ? 'bg-brand-600 font-medium text-white'
                    : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50',
                ].join(' ')}
              >
                {tab.label}
                <span
                  className={[
                    'rounded-full px-2 py-0.5 text-xs',
                    aktif ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500',
                  ].join(' ')}
                >
                  {jumlahPerTab[tab.key]}
                </span>
              </button>
            )
          })}
        </div>

        <button
          type="button"
          className="inline-flex items-center gap-1.5 text-sm font-medium text-brand-700 hover:underline"
        >
          <AlertTriangle size={15} />
          {gagalDiproses} dokumen gagal diproses AI
          <ArrowRight size={15} />
        </button>
      </div>

      {/* Tabel pengajuan */}
      <Card>
        <div className="overflow-x-auto">
          <table className="w-full text-left text-sm">
            <thead className="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
              <tr>
                <th className="px-4 py-3 font-medium">Pengajuan</th>
                <th className="px-4 py-3 font-medium">Diajukan</th>
                <th className="px-4 py-3 font-medium">Dokumen</th>
                <th className="px-4 py-3 font-medium">Rekomendasi AI</th>
                <th className="px-4 py-3 font-medium">Status Review</th>
                <th className="px-4 py-3 font-medium">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100">
              {baris.map((item) => (
                <tr key={item.id} className="hover:bg-slate-50/60">
                  <td className="px-4 py-3">
                    <p className="font-medium text-slate-800">{item.judul}</p>
                    <p className="text-xs text-slate-500">
                      {item.id} &middot; {item.opd}
                    </p>
                  </td>
                  <td className="px-4 py-3 text-slate-600">{item.diajukan}</td>
                  <td className="px-4 py-3 text-slate-600">{item.dokumen}</td>
                  <td className="px-4 py-3">
                    <Badge variant={AI_VARIANT[item.aiStatus] ?? 'neutral'}>
                      Saran AI: {item.aiLabel} ({item.aiSkor})
                    </Badge>
                  </td>
                  <td className="px-4 py-3">
                    <Badge variant="info" icon={Clock}>
                      {item.status === 'selesai'
                        ? 'Selesai'
                        : item.status === 'tambahan'
                          ? 'Perlu Dokumen Tambahan'
                          : 'Menunggu Review'}
                    </Badge>
                  </td>
                  <td className="px-4 py-3">
                    <Button size="sm">Review</Button>
                  </td>
                </tr>
              ))}

              {baris.length === 0 ? (
                <tr>
                  <td colSpan={6} className="px-4 py-10 text-center text-sm text-slate-500">
                    Tidak ada pengajuan pada filter ini.
                  </td>
                </tr>
              ) : null}
            </tbody>
          </table>
        </div>

        <div className="flex items-center justify-between border-t border-slate-100 px-4 py-3 text-xs text-slate-500">
          <span>
            Menampilkan {baris.length} dari {jumlahPerTab[activeTab]} pengajuan
          </span>
          <div className="flex items-center gap-1">
            <button type="button" className="rounded p-1 hover:bg-slate-100">
              <ChevronLeft size={16} />
            </button>
            <span className="rounded bg-brand-600 px-2.5 py-1 text-white">1</span>
            <button type="button" className="rounded p-1 hover:bg-slate-100">
              <ChevronRight size={16} />
            </button>
          </div>
        </div>
      </Card>
    </div>
  )
}
