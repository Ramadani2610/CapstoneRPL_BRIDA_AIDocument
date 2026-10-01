import { ChevronRight, Home, Plus } from 'lucide-react'
import { useState } from 'react'
import IndikatorDetail from './IndikatorDetail'
import IndikatorSidebar from './IndikatorSidebar'
import { INDIKATORS, type Indikator } from './data'

export default function IndikatorPage() {
  const [indikators] = useState<Indikator[]>(INDIKATORS)
  const [selectedId, setSelectedId] = useState<string | null>(INDIKATORS[0]?.id ?? null)

  const selected = indikators.find((ind) => ind.id === selectedId) ?? null

  // Handler placeholder — akan diimplementasikan di langkah berikutnya.
  const handleTambahIndikator = () => {
    // TODO: buka modal Tambah Indikator (Commit 3)
  }

  const handleEditIndikator = (_indikator: Indikator) => {
    // TODO: buka modal Edit Indikator (Commit 3)
  }

  const handleDeleteIndikator = (_indikator: Indikator) => {
    // TODO: buka modal Hapus Indikator (Commit 3)
  }

  const handleTambahParameter = (_indikator: Indikator) => {
    // TODO: buka modal Tambah Parameter (Commit 4)
  }

  return (
    <div className="space-y-6">
      <Breadcrumb />

      <div className="flex flex-wrap items-start justify-between gap-4">
        <div>
          <h1 className="text-2xl font-semibold text-slate-900">
            Kelola Indikator & Parameter
          </h1>
          <p className="mt-1 text-sm text-slate-500">
            Atur indikator penilaian, parameter, kriteria pemenuhan, dan contoh dokumen yang menjadi acuan verifikasi.
          </p>
        </div>

        <button
          type="button"
          onClick={handleTambahIndikator}
          className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-800"
        >
          <Plus size={16} />
          Tambah Indikator
        </button>
      </div>

      <div className="grid gap-6 lg:grid-cols-[320px_1fr]">
        <IndikatorSidebar
          indikators={indikators}
          selectedId={selectedId}
          onSelect={setSelectedId}
        />
        <IndikatorDetail
          indikator={selected}
          onEdit={handleEditIndikator}
          onDelete={handleDeleteIndikator}
          onTambahParameter={handleTambahParameter}
        />
      </div>
    </div>
  )
}

function Breadcrumb() {
  return (
    <nav className="flex items-center gap-2 text-sm text-slate-500">
      <Home size={15} />
      <ChevronRight size={14} />
      <span>Dashboard</span>
      <ChevronRight size={14} />
      <span className="text-slate-700">Indikator & Parameter</span>
    </nav>
  )
}