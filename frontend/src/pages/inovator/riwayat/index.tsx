import { useState } from 'react'
import Badge from '../../../components/ui/Badge'
import Button from '../../../components/ui/Button'
import Card from '../../../components/ui/Card'
import PageHeader from '../../../components/ui/PageHeader'
import { ClockIcon, DownloadIcon, FileTextIcon } from '../../../components/icons'

// MODUL: Riwayat Status Pengajuan (3.2.9). Data masih contoh, nanti dari API.

type StatusKey = 'draft' | 'proses' | 'revisi' | 'selesai'
type Tone = StatusKey | 'netral'

interface TimelineItem {
  title: string
  actor: string
  time: string
  tone: Tone
  latest?: boolean
  note?: string
}

interface Pengajuan {
  nama: string
  kode: string
  status: StatusKey
  statusLabel: string
  dibuat: string
  diperbarui: string
  timeline: TimelineItem[]
}

const PENGAJUAN: Pengajuan[] = [
  {
    nama: 'Makassar Sehat Mobile (MaSeMo)',
    kode: 'INV-2026-006',
    status: 'selesai',
    statusLabel: 'Disetujui',
    dibuat: '02 Jul 2026',
    diperbarui: '14 Jul 2026',
    timeline: [
      { title: 'Draft dibuat', actor: 'Andi Pratama', time: '02 Jul 2026, 10:14', tone: 'netral' },
      { title: 'Pengajuan dikirim', actor: 'Andi Pratama', time: '05 Jul 2026, 15:40', tone: 'netral' },
      {
        title: 'Review AI selesai',
        actor: 'SIGAP-AI',
        time: '05 Jul 2026, 15:52',
        tone: 'proses',
        note: 'Rekomendasi AI: 4 dari 5 dokumen terbaca, 1 dokumen perlu peninjauan manual.',
      },
      {
        title: 'Dikembalikan untuk perbaikan',
        actor: 'Nurul Hidayah · Verifikator',
        time: '08 Jul 2026, 09:20',
        tone: 'revisi',
        note: 'Mohon unggah ulang DPA yang memuat kode rekening kegiatan. Batas perbaikan 15 Juli 2026.',
      },
      { title: 'Dokumen perbaikan dikirim', actor: 'Andi Pratama', time: '11 Jul 2026, 13:05', tone: 'netral' },
      {
        title: 'Review AI ulang selesai',
        actor: 'SIGAP-AI',
        time: '11 Jul 2026, 13:11',
        tone: 'proses',
        note: 'Seluruh dokumen berhasil dibaca. Skor kelengkapan naik dari 78 ke 94.',
      },
      {
        title: 'Pengajuan disetujui',
        actor: 'Nurul Hidayah · Verifikator',
        time: '14 Jul 2026, 10:02',
        tone: 'selesai',
        latest: true,
        note: 'Seluruh dokumen valid. Inovasi tercatat dalam basis data inovasi daerah Kota Makassar.',
      },
    ],
  },
  {
    nama: 'Dashboard Command Center Penanganan Banjir',
    kode: 'INV-2026-005',
    status: 'proses',
    statusLabel: 'Sedang Diverifikasi',
    dibuat: '24 Jun 2026',
    diperbarui: '09 Jul 2026',
    timeline: [
      { title: 'Draft dibuat', actor: 'Andi Pratama', time: '24 Jun 2026, 08:31', tone: 'netral' },
      { title: 'Pengajuan dikirim', actor: 'Andi Pratama', time: '28 Jun 2026, 14:02', tone: 'netral' },
      {
        title: 'Review AI selesai',
        actor: 'SIGAP-AI',
        time: '28 Jun 2026, 14:09',
        tone: 'proses',
        note: 'Skor kelengkapan 91. Terdeteksi 2 indikator tanpa bukti pendukung.',
      },
      {
        title: 'Masuk antrian review verifikator',
        actor: 'Sistem',
        time: '09 Jul 2026, 09:15',
        tone: 'proses',
        latest: true,
        note: 'Menunggu peninjauan Nurul Hidayah. Target keputusan 5 hari kerja.',
      },
    ],
  },
  {
    nama: 'Si-Lapor Sampah Lorong',
    kode: 'INV-2026-004',
    status: 'revisi',
    statusLabel: 'Perlu Perbaikan',
    dibuat: '12 Jun 2026',
    diperbarui: '02 Jul 2026',
    timeline: [
      { title: 'Draft dibuat', actor: 'Andi Pratama', time: '12 Jun 2026, 09:05', tone: 'netral' },
      { title: 'Pengajuan dikirim', actor: 'Andi Pratama', time: '15 Jun 2026, 11:20', tone: 'netral' },
      {
        title: 'Dikembalikan untuk perbaikan',
        actor: 'Nurul Hidayah · Verifikator',
        time: '02 Jul 2026, 16:44',
        tone: 'revisi',
        latest: true,
        note: 'Surat pernyataan OPD belum ditandatangani. Batas perbaikan 20 Juli 2026.',
      },
    ],
  },
  {
    nama: 'E-Retribusi Pasar Terpadu',
    kode: 'INV-2026-003',
    status: 'selesai',
    statusLabel: 'Disetujui',
    dibuat: '18 Mei 2026',
    diperbarui: '11 Jun 2026',
    timeline: [
      { title: 'Draft dibuat', actor: 'Andi Pratama', time: '18 Mei 2026, 10:00', tone: 'netral' },
      { title: 'Pengajuan dikirim', actor: 'Andi Pratama', time: '21 Mei 2026, 13:37', tone: 'netral' },
      {
        title: 'Pengajuan disetujui',
        actor: 'Nurul Hidayah · Verifikator',
        time: '11 Jun 2026, 09:48',
        tone: 'selesai',
        latest: true,
        note: 'Dokumen lengkap tanpa catatan perbaikan.',
      },
    ],
  },
  {
    nama: 'Pelayanan KTP Keliling Terjadwal',
    kode: 'INV-2026-002',
    status: 'draft',
    statusLabel: 'Draft',
    dibuat: '06 Mei 2026',
    diperbarui: '06 Mei 2026',
    timeline: [
      {
        title: 'Draft dibuat',
        actor: 'Andi Pratama',
        time: '06 Mei 2026, 15:12',
        tone: 'draft',
        latest: true,
        note: 'Belum dikirim. Menunggu kelengkapan dokumen anggaran.',
      },
    ],
  },
]

const TONE_DOT: Record<Tone, string> = {
  netral: 'bg-[#c2b9b9]',
  draft: 'bg-status-draft-ink',
  proses: 'bg-status-proses-ink',
  revisi: 'bg-status-revisi-ink',
  selesai: 'bg-status-selesai-ink',
}

export default function RiwayatStatusPage() {
  const [index, setIndex] = useState(0)
  const aktif = PENGAJUAN[index]

  return (
    <div className="space-y-6">
      <PageHeader
        breadcrumb="Riwayat Status"
        title="Riwayat Status Pengajuan"
        subtitle="Jejak lengkap setiap perubahan status, dari draft hingga keputusan akhir."
      />

      {/* Pemilih pengajuan */}
      <div className="flex flex-wrap gap-2">
        {PENGAJUAN.map((item, i) => (
          <button
            key={item.kode}
            type="button"
            onClick={() => setIndex(i)}
            className={
              'rounded-full border px-3 py-1.5 text-xs transition ' +
              (i === index
                ? 'border-brand-600 bg-brand-50 font-medium text-brand-600'
                : 'border-line bg-white text-muted hover:border-brand-200 hover:text-brand-600')
            }
          >
            {item.nama}
          </button>
        ))}
      </div>

      <div className="grid gap-6 lg:grid-cols-3">
        <div className="lg:col-span-2">
          <Card className="p-5">
            <h2 className="text-base font-semibold text-ink">Linimasa {aktif.nama}</h2>

            <ol className="mt-5">
              {aktif.timeline.map((item, i) => (
                <li key={item.title} className="relative flex gap-4 pb-6 last:pb-0">
                  {/* Garis penghubung antar tahap */}
                  {i < aktif.timeline.length - 1 ? (
                    <span className="absolute left-[6px] top-6 h-full w-0.5 rounded-full bg-[#d8c9c9]" aria-hidden />
                  ) : null}
                  <span
                    className={
                      'relative z-10 mt-1.5 size-3.5 shrink-0 rounded-full ring-4 ring-white ' + TONE_DOT[item.tone]
                    }
                  />
                  <div className="min-w-0 flex-1">
                    <div className="flex flex-wrap items-center gap-2">
                      <p className="text-sm font-semibold text-ink">{item.title}</p>
                      {item.latest ? <Badge variant={item.tone === 'netral' ? 'draft' : item.tone}>Terbaru</Badge> : null}
                    </div>
                    <p className="mt-1 text-xs text-muted">
                      {item.actor} · {item.time}
                    </p>
                    {item.note ? (
                      <p className="mt-3 rounded-lg border border-line bg-canvas px-3 py-2 text-xs leading-relaxed text-ink">
                        <span className="font-medium">Catatan: </span>
                        {item.note}
                      </p>
                    ) : null}
                  </div>
                </li>
              ))}
            </ol>
          </Card>
        </div>

        <div className="space-y-4">
          <Card className="p-5">
            <h2 className="text-sm font-semibold text-ink">Status saat ini</h2>
            <div className="mt-3">
              <Badge variant={aktif.status}>{aktif.statusLabel}</Badge>
            </div>
            <p className="mt-4 text-sm font-medium text-ink">{aktif.nama}</p>
            <p className="text-xs text-muted">{aktif.kode}</p>

            <dl className="mt-5 space-y-3 border-t border-line pt-4 text-xs">
              <div className="flex items-center justify-between">
                <dt className="text-muted">Jumlah perubahan</dt>
                <dd className="font-medium text-ink">{aktif.timeline.length} tahap</dd>
              </div>
              <div className="flex items-center justify-between">
                <dt className="text-muted">Dibuat</dt>
                <dd className="font-medium text-ink">{aktif.dibuat}</dd>
              </div>
              <div className="flex items-center justify-between">
                <dt className="text-muted">Diperbarui</dt>
                <dd className="font-medium text-ink">{aktif.diperbarui}</dd>
              </div>
            </dl>

            <Button variant="secondary" className="mt-5 w-full">
              <FileTextIcon className="size-4" />
              Lihat Detail Pengajuan
            </Button>
          </Card>

          <Card className="p-5">
            <h2 className="text-sm font-semibold text-ink">Unduhan</h2>
            <ul className="mt-3 space-y-2 text-sm">
              <li>
                <button
                  type="button"
                  disabled={aktif.status !== 'selesai'}
                  className="flex w-full items-center gap-2 text-left text-brand-600 hover:underline disabled:cursor-not-allowed disabled:text-muted disabled:no-underline"
                >
                  <DownloadIcon className="size-4" />
                  Berita acara keputusan
                </button>
              </li>
              <li>
                <button
                  type="button"
                  className="flex w-full items-center gap-2 text-left text-brand-600 hover:underline"
                >
                  <DownloadIcon className="size-4" />
                  Ringkasan hasil verifikasi
                </button>
              </li>
            </ul>
            <p className="mt-4 flex items-start gap-2 text-xs text-muted">
              <ClockIcon className="mt-0.5 size-3.5 shrink-0" />
              Berkas keputusan tersedia setelah pengajuan disetujui, dan dapat diunduh 30 hari setelahnya.
            </p>
          </Card>
        </div>
      </div>
    </div>
  )
}
