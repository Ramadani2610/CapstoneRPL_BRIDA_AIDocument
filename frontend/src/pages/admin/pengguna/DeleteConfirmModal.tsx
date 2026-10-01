import Modal from '../../../components/ui/Modal'
import type { User } from './data'

interface DeleteConfirmModalProps {
  open: boolean
  user: User | null
  onClose: () => void
  onConfirm: () => void
}

export default function DeleteConfirmModal({
  open,
  user,
  onClose,
  onConfirm,
}: DeleteConfirmModalProps) {
  return (
    <Modal
      open={open}
      onClose={onClose}
      title={user ? `Hapus ${user.nama}?` : 'Hapus Pengguna?'}
      size="sm"
      footer={
        <>
          <button
            type="button"
            onClick={onClose}
            className="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
          >
            Batal
          </button>
          <button
            type="button"
            onClick={onConfirm}
            className="rounded-lg bg-rose-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-800"
          >
            Ya, Hapus Akun
          </button>
        </>
      }
    >
      <p className="text-sm text-slate-600">
        Akun akan dihapus permanen. Riwayat pengajuan dan log audit milik pengguna tetap tersimpan.
        Pertimbangkan menonaktifkan akun jika hanya ingin memblokir akses.
      </p>
    </Modal>
  )
}