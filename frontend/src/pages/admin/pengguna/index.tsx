import { ChevronRight, Home, Plus } from 'lucide-react'
import { useState } from 'react'
import DeleteConfirmModal from './DeleteConfirmModal'
import UserFormModal, { type UserFormValues } from './UserFormModal'
import UserTable from './UserTable'
import { USERS, type User } from './data'

type ModalState =
  | { kind: 'closed' }
  | { kind: 'tambah' }
  | { kind: 'edit'; user: User }
  | { kind: 'hapus'; user: User }

export default function ManajemenPenggunaPage() {
  const [users, setUsers] = useState<User[]>(USERS)
  const [modal, setModal] = useState<ModalState>({ kind: 'closed' })

  const handleToggleActive = (userId: string, nextValue: boolean) => {
    setUsers((prev) =>
      prev.map((u) => (u.id === userId ? { ...u, aktif: nextValue } : u)),
    )
  }

  const handleOpenTambah = () => setModal({ kind: 'tambah' })
  const handleOpenEdit = (user: User) => setModal({ kind: 'edit', user })
  const handleOpenHapus = (user: User) => setModal({ kind: 'hapus', user })
  const handleCloseModal = () => setModal({ kind: 'closed' })

  const handleSubmitForm = (data: UserFormValues) => {
    if (modal.kind === 'tambah') {
      const newUser: User = {
        id: `u-${Date.now()}`,
        ...data,
        loginTerakhir: null,
      }
      setUsers((prev) => [newUser, ...prev])
    } else if (modal.kind === 'edit') {
      setUsers((prev) =>
        prev.map((u) => (u.id === modal.user.id ? { ...u, ...data } : u)),
      )
    }
    handleCloseModal()
  }

  const handleConfirmHapus = () => {
    if (modal.kind !== 'hapus') return
    setUsers((prev) => prev.filter((u) => u.id !== modal.user.id))
    handleCloseModal()
  }

  return (
    <div className="space-y-6">
      <Breadcrumb />

      <div className="flex flex-wrap items-start justify-between gap-4">
        <div>
          <h1 className="text-2xl font-semibold text-slate-900">Kelola Akun Pengguna</h1>
          <p className="mt-1 text-sm text-slate-500">
            Atur akses inovator perangkat daerah, verifikator BRIDA, dan administrator sistem.
          </p>
        </div>

        <button
          type="button"
          onClick={handleOpenTambah}
          className="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-800"
        >
          <Plus size={16} />
          Tambah Pengguna
        </button>
      </div>

      <UserTable
        users={users}
        onToggleActive={handleToggleActive}
        onEdit={handleOpenEdit}
        onDelete={handleOpenHapus}
      />

      <UserFormModal
        open={modal.kind === 'tambah' || modal.kind === 'edit'}
        mode={modal.kind === 'edit' ? 'edit' : 'tambah'}
        initialUser={modal.kind === 'edit' ? modal.user : null}
        onClose={handleCloseModal}
        onSubmit={handleSubmitForm}
      />

      <DeleteConfirmModal
        open={modal.kind === 'hapus'}
        user={modal.kind === 'hapus' ? modal.user : null}
        onClose={handleCloseModal}
        onConfirm={handleConfirmHapus}
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
      <span className="text-slate-700">Kelola Pengguna</span>
    </nav>
  )
}