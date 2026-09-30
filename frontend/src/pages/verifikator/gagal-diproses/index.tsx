import { useState } from 'react'

type FailedDocument = {
  id: number
  fileName: string
  fileSize: string
  submissionId: string
  innovationName: string
  indicator: string
  errorType: string
  description: string
  attempt: string
  failedAt: string
  icon: 'ocr' | 'timeout' | 'protected' | 'text'
  canRetry: boolean
  retryLabel: string
  lastAttempt?: boolean
}

const failedDocuments: FailedDocument[] = [
  {
    id: 1,
    fileName: 'Scan_BeritaAcara_UjiCoba.pdf',
    fileSize: '7,4 MB',
    submissionId: 'INV-2026-015',
    innovationName: 'Posyandu Digital Terintegrasi',
    indicator: 'IND-06 · 5 bulan atau kurang',
    errorType: 'OCR Gagal',
    description:
      'Keterbacaan teks hanya 41%. Dokumen hasil pindai buram atau miring.',
    attempt: 'Percobaan 1/3',
    failedAt: 'Gagal 26 Sep 2026, 08:47',
    icon: 'ocr',
    canRetry: true,
    retryLabel: 'Retry AI Processing',
  },
  {
    id: 2,
    fileName: 'DPA_Disidik_2026.pdf',
    fileSize: '9,6 MB',
    submissionId: 'INV-2026-013',
    innovationName: 'Beasiswa Makassar Cerdas Online',
    indicator: 'IND-03 · APBD tahun berjalan',
    errorType: 'Timeout AI',
    description:
      'Analisis AI melewati batas waktu 120 detik (dokumen 48 halaman).',
    attempt: 'Percobaan 2/3',
    failedAt: 'Gagal 26 Sep 2026, 07:31',
    icon: 'timeout',
    canRetry: true,
    retryLabel: 'Retry AI Processing',
  },
  {
    id: 3,
    fileName: 'Laporan_Pengguna_Q2.pdf',
    fileSize: '2,4 MB',
    submissionId: 'INV-2026-008',
    innovationName: 'Bank Sampah Lorong Garden',
    indicator: 'IND-07 · Lebih dari 200 penerima manfaat',
    errorType: 'File Terproteksi',
    description:
      'File dilindungi kata sandi sehingga tidak dapat dibaca sistem.',
    attempt: 'Percobaan 1/3',
    failedAt: 'Gagal 25 Sep 2026, 16:05',
    icon: 'protected',
    canRetry: false,
    retryLabel: 'Minta Unggah Ulang',
  },
  {
    id: 4,
    fileName: 'Dokumentasi_Bimtek_Juni.pdf',
    fileSize: '5,1 MB',
    submissionId: 'INV-2026-012',
    innovationName: 'Si-Lapor Sampah Lorong',
    indicator: 'IND-05 · 2 kali',
    errorType: 'Tanpa Lapisan Teks',
    description:
      'Halaman 2–9 hanya berisi gambar tanpa lapisan teks.',
    attempt: 'Percobaan 1/3',
    failedAt: 'Gagal 25 Sep 2026, 11:18',
    icon: 'text',
    canRetry: true,
    retryLabel: 'Retry AI Processing',
  },
  {
    id: 5,
    fileName: 'SK_Tim_Pelaksana_scan.pdf',
    fileSize: '3,3 MB',
    submissionId: 'INV-2026-013',
    innovationName: 'Beasiswa Makassar Cerdas Online',
    indicator: 'IND-02 · 11–30 SDM',
    errorType: 'OCR Gagal',
    description:
      'Keterbacaan 58%. Stempel menutupi sebagian teks utama.',
    attempt: 'Percobaan 3/3',
    failedAt: 'Gagal 24 Sep 2026, 14:40',
    icon: 'ocr',
    canRetry: false,
    retryLabel: 'Minta Unggah Ulang',
    lastAttempt: true,
  },
  {
    id: 6,
    fileName: 'Berita_Acara_Sosialisasi.pdf',
    fileSize: '4,7 MB',
    submissionId: 'INV-2026-010',
    innovationName: 'Makassar Smart Parking',
    indicator: 'IND-04 · Minimal 3 lokasi uji coba',
    errorType: 'Timeout AI',
    description:
      'Analisis AI melewati batas waktu 120 detik karena struktur dokumen tidak dapat diproses secara optimal.',
    attempt: 'Percobaan 1/3',
    failedAt: 'Gagal 23 Sep 2026, 10:26',
    icon: 'timeout',
    canRetry: true,
    retryLabel: 'Retry AI Processing',
  },
]

function ErrorIcon({
  type,
}: {
  type: FailedDocument['icon']
}) {
  if (type === 'timeout') {
    return (
      <svg
        width="23"
        height="23"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        strokeWidth="1.8"
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <circle cx="12" cy="12" r="8.5" />
        <path d="M12 7v5l3 2" />
      </svg>
    )
  }

  if (type === 'protected') {
    return (
      <svg
        width="23"
        height="23"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        strokeWidth="1.8"
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <rect x="4" y="10" width="16" height="10" rx="2" />
        <path d="M8 10V7a4 4 0 0 1 8 0v3" />
      </svg>
    )
  }

  if (type === 'text') {
    return (
      <svg
        width="23"
        height="23"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        strokeWidth="1.8"
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <rect x="5" y="3" width="14" height="18" rx="2" />
        <path d="M9 8h6" />
        <path d="M9 12h6" />
        <path d="M9 16h3" />
      </svg>
    )
  }

  return (
    <svg
      width="23"
      height="23"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      strokeWidth="1.8"
      strokeLinecap="round"
      strokeLinejoin="round"
    >
      <path d="M9 3h6" />
      <path d="M10 3v3L5.5 10.5A2 2 0 0 0 5 12v6a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-6a2 2 0 0 0-.5-1.5L14 6V3" />
      <path d="M8 13h8" />
      <path d="M9 17h6" />
    </svg>
  )
}

function RetryIcon() {
  return (
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
      <path d="M21 12a9 9 0 1 1-2.64-6.36" />
      <polyline points="21 3 21 9 15 9" />
    </svg>
  )
}

function UploadIcon() {
  return (
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
      <rect x="3" y="5" width="18" height="14" rx="2" />
      <path d="m3 7 9 6 9-6" />
    </svg>
  )
}

export default function GagalDiprosesPage() {
  const [processingIds, setProcessingIds] = useState<number[]>([])

  const [currentPage, setCurrentPage] = useState(1)
  const itemsPerPage = 5

  const totalPages = Math.max(
  1,
  Math.ceil(failedDocuments.length / itemsPerPage),
)

  const paginatedDocuments = failedDocuments.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage,
  )

  function handleRetry(id: number) {
    setProcessingIds((current) => [...current, id])

    // Simulasi proses retry untuk sementara.
    // Nanti bagian ini dapat diganti dengan API Laravel.
    setTimeout(() => {
      setProcessingIds((current) =>
        current.filter((itemId) => itemId !== id),
      )
    }, 1500)
  }

  function handleRetryAll() {
    const retryableIds = failedDocuments
      .filter((item) => item.canRetry)
      .map((item) => item.id)

    setProcessingIds(retryableIds)

    setTimeout(() => {
      setProcessingIds([])
    }, 1500)
  }

  function handleRequestUpload(fileName: string) {
    window.alert(
      `Permintaan unggah ulang untuk ${fileName} akan dikirim ke inovator.`,
    )
  }

  const retryableCount = failedDocuments.filter(
    (item) => item.canRetry,
  ).length

  return (
    <div className="space-y-6">
      {/* Breadcrumb */}
      <div className="flex items-center gap-2 text-sm text-slate-400">
        <svg
          width="17"
          height="17"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          strokeWidth="1.8"
          strokeLinecap="round"
          strokeLinejoin="round"
        >
          <path d="m3 11 9-8 9 8" />
          <path d="M5 10v10h14V10" />
          <path d="M9 20v-6h6v6" />
        </svg>

        <span>Antrian Review</span>

        <span className="text-slate-300">›</span>

        <span className="font-medium text-slate-700">
          Gagal Diproses
        </span>
      </div>

      {/* Header */}
      <div className="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
        <div>
          <h1 className="text-[27px] font-bold tracking-tight text-slate-900">
            Dokumen Gagal Diproses
          </h1>

          <p className="mt-1.5 max-w-4xl text-[15px] leading-6 text-slate-500">
            Dokumen di bawah gagal melalui OCR atau analisis AI sehingga
            belum memiliki rekomendasi. Proses ulang, atau minta inovator
            mengunggah versi baru.
          </p>
        </div>

        <button
          type="button"
          onClick={handleRetryAll}
          disabled={processingIds.length > 0}
          className="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#7F1D1D] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#681818] disabled:cursor-not-allowed disabled:opacity-70"
        >
          <RetryIcon />

          {processingIds.length > 0
            ? 'Memproses...'
            : `Retry Semua (${retryableCount})`}
        </button>
      </div>

      {/* Result info */}
      <div className="flex items-center justify-between">
        <p className="text-sm text-slate-500">
          Menampilkan{' '}
          <span className="font-semibold text-slate-800">
            {paginatedDocuments.length}
          </span>{' '}
          dari{' '}
          <span className="font-semibold text-slate-800">
            {failedDocuments.length}
          </span>{' '}
          dokumen gagal diproses
        </p>
      </div>

      {/* Failed document list */}
      <div className="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        {paginatedDocuments.map((item, index) => {
          const isProcessing = processingIds.includes(item.id)

          return (
            <div
              key={item.id}
              className={[
                'flex flex-col gap-5 px-5 py-5 transition',
                index !== paginatedDocuments.length - 1
                  ? 'border-b border-slate-200'
                  : '',
              ].join(' ')}
            >
              <div className="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                {/* Left content */}
                <div className="flex min-w-0 flex-1 items-start gap-4">
                  {/* Error icon */}
                  <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-[#F9DADA] text-[#8B2525]">
                    <ErrorIcon type={item.icon} />
                  </div>

                  {/* Information */}
                  <div className="min-w-0 flex-1">
                    {/* File name */}
                    <div className="flex flex-wrap items-baseline gap-2">
                      <h2 className="text-[15px] font-bold text-slate-800">
                        {item.fileName}
                      </h2>

                      <span className="text-xs text-slate-400">
                        {item.fileSize}
                      </span>
                    </div>

                    {/* Submission information */}
                    <p className="mt-1 text-[13px] text-slate-500">
                      <span className="font-medium text-slate-500">
                        {item.submissionId}
                      </span>

                      <span className="mx-1.5">·</span>

                      {item.innovationName}

                      <span className="mx-1.5">·</span>

                      {item.indicator}
                    </p>

                    {/* Error description */}
                    <div className="mt-2.5 flex flex-wrap items-center gap-2">
                      <span className="inline-flex items-center gap-1.5 rounded-full bg-[#F9DADA] px-2.5 py-1 text-xs font-medium text-[#8B2525]">
                        <span className="h-1.5 w-1.5 rounded-full bg-[#8B2525]" />
                        {item.errorType}
                      </span>

                      <span className="text-sm text-slate-600">
                        {item.description}
                      </span>
                    </div>

                    {/* Attempt */}
                    <div className="mt-2 text-xs text-slate-500">
                      {item.attempt}

                      <span className="mx-1.5">·</span>

                      <span
                        className={
                          item.lastAttempt
                            ? 'font-medium text-[#8B2525]'
                            : ''
                        }
                      >
                        {item.failedAt}
                      </span>

                      {item.lastAttempt && (
                        <>
                          <span className="mx-1.5">·</span>
                          <span className="font-medium text-[#8B2525]">
                            Batas percobaan tercapai
                          </span>
                        </>
                      )}
                    </div>
                  </div>
                </div>

                {/* Action */}
                <div className="flex shrink-0 justify-end xl:pl-6">
                  {item.canRetry ? (
                    <button
                      type="button"
                      disabled={isProcessing}
                      onClick={() => handleRetry(item.id)}
                      className="inline-flex min-w-[185px] items-center justify-center gap-2 rounded-lg bg-[#7F1D1D] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#681818] disabled:cursor-not-allowed disabled:opacity-70"
                    >
                      <RetryIcon />

                      {isProcessing
                        ? 'Memproses...'
                        : item.retryLabel}
                    </button>
                  ) : (
                    <button
                      type="button"
                      onClick={() =>
                        handleRequestUpload(item.fileName)
                      }
                      className="inline-flex min-w-[185px] items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-[#8B2525] hover:bg-[#FFF7F7] hover:text-[#7F1D1D]"
                    >
                      <UploadIcon />
                      {item.retryLabel}
                    </button>
                  )}
                </div>
              </div>
            </div>
          )
        })}
      </div>

      {/* Pagination */}
      <div className="flex flex-col gap-3 border-t border-slate-200 bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
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
              disabled={totalPages === 1}
              onClick={() => setCurrentPage(page)}
              className={[
                'h-9 min-w-9 rounded-lg px-3 text-sm font-medium transition',
                currentPage === page
                  ? 'bg-[#7F1D1D] text-white'
                  : 'border border-slate-300 bg-white text-slate-600 hover:bg-[#7F1D1D] hover:text-white',
                totalPages === 1
                  ? 'cursor-default'
                  : '',
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

      {/* Footer note */}
      <p className="text-xs leading-5 text-slate-400">
        File terproteksi kata sandi atau yang telah mencapai batas 3
        percobaan tidak dapat diproses ulang dan perlu diunggah ulang oleh
        inovator.
      </p>
    </div>
  )
}