import { ChevronRight, Home, Plus } from 'lucide-react'
import { useState } from 'react'
import DeleteConfirmModal from './DeleteConfirmModal'
import IndikatorDetail from './IndikatorDetail'
import IndikatorFormModal, { type IndikatorFormValues } from './IndikatorFormModal'
import IndikatorSidebar from './IndikatorSidebar'
import ParameterTable from './ParameterTable'
import { INDIKATORS, type Indikator, type Parameter } from './data'

type ModalState =
  | { kind: 'closed' }
  | { kind: 'tambah-indikator' }
  | { kind: 'edit-indikator'; indikator: Indikator }
  | { kind: 'hapus-indikator'; indikator: Indikator }
  | { kind: 'tambah-parameter'; indikator: Indikator }
  | { kind: 'edit-parameter'; indikator: Indikator; parameter: Parameter }
  | { kind: 'hapus-parameter'; indikator: Indikator; parameter: Parameter }

export default function IndikatorPage() {
  const [indikators, setIndikators] = useState<Indikator[]>(INDIKATORS)
  const [selectedId, setSelectedId] = useState<string | null>(INDIKATORS[0]?.id ?? null)
  const [modal, setModal] = useState<ModalState>({ kind: 'closed' })

  const selected = indikators.find((ind) => ind.id === selectedId) ?? null

  const handleCloseModal = () => setModal({ kind: 'closed' })

  // ======== INDIKATOR CRUD ========
  const handleOpenTambahIndikator = () => setModal({ kind: 'tambah-indikator' })
  const handleOpenEditIndikator = (indikator: Indikator) =>
    setModal({ kind: 'edit-indikator', indikator })
  const handleOpenHapusIndikator = (indikator: Indikator) =>
    setModal({ kind: 'hapus-indikator', indikator })

  const handleSubmitIndikator = (data: IndikatorFormValues) => {
    if (modal.kind === 'tambah-indikator') {
      const newIndikator: Indikator = {
        id: `ind-${Date.now()}`,
        ...data,
        parameter: [],
      }
      setIndikators((prev) => [...prev, newIndikator])
      setSelectedId(newIndikator.id)
    } else if (modal.kind === 'edit-indikator') {
      setIndikators((prev) =>
        prev.map((ind) => (ind.id === modal.indikator.id ? { ...ind, ...data } : ind)),
      )
    }
    handleCloseModal()
  }

  const handleConfirmHapusIndikator = () => {
    if (modal.kind !== 'hapus-indikator') return
    const deletedId = modal.indikator.id
    setIndikators((prev) => prev.filter((ind) => ind.id !== deletedId))
    if (selectedId === deletedId) {
      setSelectedId(indikators.find((ind) => ind.id !== deletedId)?.id ?? null)
    }
    handleCloseModal()
  }

  // ======== PARAMETER CRUD (placeholder, implementasi di Commit 4) ========
  const handleOpenTambahParameter = (indikator: Indikator) =>
    setModal({ kind: 'tambah-parameter', indikator })
  const handleOpenEditParameter = (parameter: Parameter) => {
    if (!selected) return
    setModal({ kind: 'edit-parameter', indikator: selected, parameter })
  }
  const handleOpenHapusParameter = (parameter: Parameter) => {
    if (!selected) return
    setModal({ kind: 'hapus-parameter', indikator: selected, parameter })
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
          onClick={handleOpenTambahIndikator}
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
          onEdit={handleOpenEditIndikator}
          onDelete={handleOpenHapusIndikator}
          onTambahParameter={handleOpenTambahParameter}
        >
          {selected ? (
            <ParameterTable
              parameters={selected.parameter}
              onEdit={handleOpenEditParameter}
              onDelete={handleOpenHapusParameter}
            />
          ) : null}
        </IndikatorDetail>
      </div>

      <IndikatorFormModal
        open={modal.kind === 'tambah-indikator' || modal.kind === 'edit-indikator'}
        mode={modal.kind === 'edit-indikator' ? 'edit' : 'tambah'}
        initialIndikator={modal.kind === 'edit-indikator' ? modal.indikator : null}
        onClose={handleCloseModal}
        onSubmit={handleSubmitIndikator}
      />

      <DeleteConfirmModal
        open={modal.kind === 'hapus-indikator'}
        title={
          modal.kind === 'hapus-indikator'
            ? `Hapus ${modal.indikator.nama}?`
            : 'Hapus Indikator?'
        }
        message="Indikator beserta seluruh parameternya akan dihapus. Pengajuan yang sudah menggunakan indikator ini tidak terpengaruh."
        onClose={handleCloseModal}
        onConfirm={handleConfirmHapusIndikator}
      />
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