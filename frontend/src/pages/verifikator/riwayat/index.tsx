import { useMemo, useState } from 'react'

type AuditActorType = 'Verifikator' | 'AI' | 'Sistem' | 'Inovator' | 'Admin'

type AuditItem = {
  id: number
  date: string
  time: string
  actor: string
  actorType: AuditActorType
  action: string
  object: string
  description: string
}

const auditData: AuditItem[] = [
  {
    id: 1,
    date: '26 Sep 2026',
    time: '09:41',
    actor: 'SIGAP-AI',
    actorType: 'AI',
    action: 'Analisis AI selesai',
    object: 'INV-2026-009',
    description:
      '5 dokumen dianalisis · rekomendasi Lolos (92%)',
  },
  {
    id: 2,
    date: '26 Sep 2026',
    time: '09:38',
    actor: 'Sistem',
    actorType: 'Sistem',
    action: 'OCR selesai',
    object: 'INV-2026-009',
    description:
      'Ekstraksi teks 40 halaman · keterbacaan rata-rata 97%',
  },
  {
    id: 3,
    date: '26 Sep 2026',
    time: '09:35',
    actor: 'Andi Pratama',
    actorType: 'Inovator',
    action: 'Pengajuan dikirim',
    object: 'INV-2026-009',
    description:
      'Dashboard Command Center Penanganan Banjir',
  },
  {
    id: 4,
    date: '26 Sep 2026',
    time: '08:52',
    actor: 'Nurul Hidayah',
    actorType: 'Verifikator',
    action: 'Minta dokumen tambahan',
    object: 'INV-2026-013',
    description:
      'SK Tim Pelaksana perlu diunggah ulang dengan kualitas yang lebih baik',
  },
  {
    id: 5,
    date: '26 Sep 2026',
    time: '08:47',
    actor: 'Sistem',
    actorType: 'Sistem',
    action: 'Pemrosesan gagal',
    object: 'INV-2026-015',
    description:
      'Scan_BeritaAcara_UjiCoba.pdf — OCR gagal diproses',
  },
  {
    id: 6,
    date: '25 Sep 2026',
    time: '16:20',
    actor: 'Dr. Hasanuddin Latief',
    actorType: 'Verifikator',
    action: 'Keputusan: Disetujui',
    object: 'INV-2026-010',
    description:
      'Override rekomendasi AI keyakinan sedang (71%)',
  },
  {
    id: 7,
    date: '25 Sep 2026',
    time: '14:05',
    actor: 'Muh. Rizal Syam',
    actorType: 'Admin',
    action: 'Parameter diperbarui',
    object: 'IND-03-P1',
    description:
      'Kriteria ditambah: nilai anggaran tercantum jelas',
  },
  {
    id: 8,
    date: '25 Sep 2026',
    time: '11:32',
    actor: 'Muh. Rizal Syam',
    actorType: 'Admin',
    action: 'Pengguna ditambahkan',
    object: 'U-010',
    description:
      'Yusuf Daeng Tompo · Inovator · Kecamatan Tamalate',
  },
  {
    id: 9,
    date: '25 Sep 2026',
    time: '10:14',
    actor: 'SIGAP-AI',
    actorType: 'AI',
    action: 'Analisis AI selesai',
    object: 'INV-2026-015',
    description:
      'Keyakinan rendah (54%) · perlu pemeriksaan manual',
  },
  {
    id: 10,
    date: '25 Sep 2026',
    time: '10:02',
    actor: 'Sitti Rahmawati',
    actorType: 'Inovator',
    action: 'Dokumen diganti',
    object: 'INV-2026-015',
    description:
      'SK_Pos yandu_Digital.pdf menggantikan versi sebelumnya',
  },
  {
    id: 11,
    date: '25 Sep 2026',
    time: '15:48',
    actor: 'Sistem',
    actorType: 'Sistem',
    action: 'Retry berhasil',
    object: 'INV-2026-012',
    description:
      'Log_Chatbot_Juli_Agustus.pdf berhasil diproses',
  },
  {
    id: 12,
    date: '25 Sep 2026',
    time: '09:10',
    actor: 'Irma Suryani',
    actorType: 'Verifikator',
    action: 'Keputusan: Ditolak',
    object: 'INV-2026-007',
    description:
      'Inovasi merupakan replikasi tanpa modifikasi dari daerah lain',
  },
  {
    id: 13,
    date: '24 Sep 2026',
    time: '13:25',
    actor: 'Muh. Rizal Syam',
    actorType: 'Admin',
    action: 'Indikator dinonaktifkan',
    object: 'IND-08',
    description:
      'Kualitas Inovasi Daerah — menunggu pembaruan juknis',
  },
  {
    id: 14,
    date: '24 Sep 2026',
    time: '08:40',
    actor: 'Nurul Hidayah',
    actorType: 'Verifikator',
    action: 'Kembalikan untuk perbaikan',
    object: 'INV-2026-011',
    description:
      '2 parameter perlu direvisi, batas 3 Okt 2026',
  },
]

const filters: Array<'Semua' | AuditActorType> = [
  'Semua',
  'Verifikator',
  'AI',
  'Sistem',
  'Inovator',
  'Admin',
]

function getActorStyle(type: AuditActorType) {
  switch (type) {
    case 'AI':
      return 'bg-violet-50 text-violet-700 ring-violet-200'
    case 'Sistem':
      return 'bg-slate-100 text-slate-700 ring-slate-200'
    case 'Inovator':
      return 'bg-emerald-50 text-emerald-700 ring-emerald-200'
    case 'Admin':
      return 'bg-amber-50 text-amber-700 ring-amber-200'
    case 'Verifikator':
      return 'bg-blue-50 text-blue-700 ring-blue-200'
  }
}

export default function RiwayatAuditPage() {
  const [activeFilter, setActiveFilter] = useState<
    'Semua' | AuditActorType
  >('Semua')

  const [search, setSearch] = useState('')
  const [currentPage, setCurrentPage] = useState(1)
  const itemsPerPage = 10

  const filteredData = useMemo(() => {
    const keyword = search.toLowerCase().trim()

    return auditData.filter((item) => {
      const matchesFilter =
        activeFilter === 'Semua' || item.actorType === activeFilter

      const matchesSearch =
        !keyword ||
        item.actor.toLowerCase().includes(keyword) ||
        item.action.toLowerCase().includes(keyword) ||
        item.object.toLowerCase().includes(keyword) ||
        item.description.toLowerCase().includes(keyword)

      return matchesFilter && matchesSearch
    })
  }, [activeFilter, search])

  const totalPages = Math.ceil(filteredData.length / itemsPerPage)

  const paginatedData = filteredData.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage,
  )

  function exportCSV() {
    const header = [
      'Waktu',
      'Aktor',
      'Tipe Aktor',
      'Aksi',
      'Objek',
      'Keterangan',
    ]

    const rows = filteredData.map((item) => [
      `${item.date} ${item.time}`,
      item.actor,
      item.actorType,
      item.action,
      item.object,
      item.description,
    ])

    const csv = [header, ...rows]
      .map((row) =>
        row
          .map((value) => `"${String(value).replace(/"/g, '""')}"`)
          .join(','),
      )
      .join('\n')

    const blob = new Blob([csv], {
      type: 'text/csv;charset=utf-8;',
    })

    const url = URL.createObjectURL(blob)
    const link = document.createElement('a')

    link.href = url
    link.setAttribute('download', 'riwayat-audit.csv')
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    URL.revokeObjectURL(url)
  }

  return (
    <div className="space-y-6">
      {/* Breadcrumb */}
      <div className="flex items-center gap-2 text-sm text-slate-500">
        <span>Antrian Review</span>
        <span>/</span>
        <span className="font-medium text-slate-800">
          Riwayat Audit
        </span>
      </div>

      {/* Header */}
      <div className="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-slate-900">
            Riwayat Audit &amp; Log Keputusan
          </h1>

          <p className="mt-2 max-w-3xl text-sm leading-6 text-slate-500">
            Jejak lengkap setiap tindakan verifikator, inovator, admin,
            dan proses otomatis sistem.
          </p>
        </div>

        <button
          type="button"
          onClick={exportCSV}
          className="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-[#7F1D1D] hover:text-white"
        >
          <svg
            width="17"
            height="17"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            strokeLinecap="round"
            strokeLinejoin="round"
          >
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
            <polyline points="7 10 12 15 17 10" />
            <line x1="12" y1="15" x2="12" y2="3" />
          </svg>
          Ekspor CSV
        </button>
      </div>

      {/* Filter & Search */}
      <div className="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div className="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
          {/* Filter */}
          <div className="flex flex-wrap gap-2">
            {filters.map((filter) => {
              const isActive = activeFilter === filter

              return (
                <button
                  key={filter}
                  type="button"
                  onClick={() => setActiveFilter(filter)}
                  className={[
                    'rounded-full px-4 py-2 text-sm font-medium transition',
                    isActive
                      ? 'bg-[#7F1D1D] text-white'
                      : 'bg-slate-100 text-slate-600 hover:bg-[#7F1D1D] hover:text-white',
                  ].join(' ')}
                >
                  {filter}
                </button>
              )
            })}
          </div>

          {/* Search */}
          <div className="relative w-full xl:max-w-sm">
            <svg
              className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
              width="18"
              height="18"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              strokeWidth="2"
              strokeLinecap="round"
              strokeLinejoin="round"
            >
              <circle cx="11" cy="11" r="8" />
              <path d="m21 21-4.35-4.35" />
            </svg>

            <input
              type="text"
              value={search}
              onChange={(event) => setSearch(event.target.value)}
              placeholder="Cari aksi, ID, atau aktor"
              className="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
            />
          </div>
        </div>
      </div>

      {/* Result info */}
      <div className="flex items-center justify-between">
        <p className="text-sm text-slate-500">
          Menampilkan{' '}
          <span className="font-semibold text-slate-800">
            {paginatedData.length}
          </span>{' '}
          dari{' '}
          <span className="font-semibold text-slate-800">
            {filteredData.length}
          </span>{' '}
          aktivitas
        </p>

        {(activeFilter !== 'Semua' || search) && (
          <button
            type="button"
            onClick={() => {
              setActiveFilter('Semua')
              setSearch('')
            }}
            className="text-sm font-medium text-[#7F1D1D] hover:text-[#5B1515]"
          >
            Reset filter
          </button>
        )}
      </div>

      {/* Table */}
      <div className="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div className="overflow-x-auto">
          <table className="min-w-[1000px] w-full">
            <thead>
              <tr className="border-b border-slate-200 bg-slate-50">
                <th className="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                  Waktu
                </th>
                <th className="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                  Aktor
                </th>
                <th className="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                  Aksi
                </th>
                <th className="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                  Objek
                </th>
                <th className="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                  Keterangan
                </th>
              </tr>
            </thead>

            <tbody className="divide-y divide-slate-100">
              {paginatedData.map((item) => (
                <tr
                  key={item.id}
                  className="transition hover:bg-[#FDF2F2]"
                >
                  {/* Waktu */}
                  <td className="whitespace-nowrap px-5 py-4 align-top">
                    <div className="text-sm font-medium text-slate-800">
                      {item.time}
                    </div>
                    <div className="mt-1 text-xs text-slate-400">
                      {item.date}
                    </div>
                  </td>

                  {/* Aktor */}
                  <td className="px-5 py-4 align-top">
                    <div className="flex flex-col items-start gap-2">
                      <span className="text-sm font-medium text-slate-800">
                        {item.actor}
                      </span>

                      <span
                        className={[
                          'inline-flex rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset',
                          getActorStyle(item.actorType),
                        ].join(' ')}
                      >
                        {item.actorType}
                      </span>
                    </div>
                  </td>

                  {/* Aksi */}
                  <td className="px-5 py-4 align-top">
                    <span className="text-sm font-medium text-slate-700">
                      {item.action}
                    </span>
                  </td>

                  {/* Objek */}
                  <td className="px-5 py-4 align-top">
                    <span className="rounded-md bg-slate-100 px-2 py-1 font-mono text-xs font-medium text-slate-700">
                      {item.object}
                    </span>
                  </td>

                  {/* Keterangan */}
                  <td className="max-w-md px-5 py-4 align-top">
                    <p className="text-sm leading-6 text-slate-500">
                      {item.description}
                    </p>
                  </td>
                </tr>
              ))}

              {filteredData.length === 0 && (
                <tr>
                  <td
                    colSpan={5}
                    className="px-5 py-12 text-center"
                  >
                    <div className="text-sm font-medium text-slate-700">
                      Tidak ada aktivitas ditemukan
                    </div>
                    <p className="mt-1 text-sm text-slate-400">
                      Coba ubah kata kunci pencarian atau filter aktor.
                    </p>
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>

        {/* Pagination */}
        {totalPages > 1 && (
          <div className="flex items-center justify-between border-t border-slate-200 px-5 py-4">
            <p className="text-sm text-slate-500">
              Halaman{' '}
              <span className="font-semibold text-slate-800">
                {currentPage}
              </span>{' '}
              dari{' '}
              <span className="font-semibold text-slate-800">
                {totalPages}
              </span>
            </p>

            <div className="flex items-center gap-2">
              <button
                type="button"
                disabled={currentPage === 1}
                onClick={() =>
                  setCurrentPage((page) => Math.max(page - 1, 1))
                }
                className="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#7F1D1D] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-slate-600"
              >
                ← Sebelumnya
              </button>

              {Array.from(
                { length: totalPages },
                (_, index) => index + 1,
              ).map((page) => (
                <button
                  key={page}
                  type="button"
                  onClick={() => setCurrentPage(page)}
                  className={[
                    'h-9 min-w-9 rounded-lg px-3 text-sm font-medium transition',
                    currentPage === page
                      ? 'bg-[#7F1D1D] text-white'
                      : 'border border-slate-300 bg-white text-slate-600 hover:bg-[#7F1D1D] hover:text-white',
                  ].join(' ')}
                >
                  {page}
                </button>
              ))}

              <button
                type="button"
                disabled={currentPage === totalPages}
                onClick={() =>
                  setCurrentPage((page) =>
                    Math.min(page + 1, totalPages),
                  )
                }
                className="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#7F1D1D] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-slate-600"
              >
                Berikutnya →
              </button>
            </div>
          </div>
        )}
      </div>
    </div>
  )
}