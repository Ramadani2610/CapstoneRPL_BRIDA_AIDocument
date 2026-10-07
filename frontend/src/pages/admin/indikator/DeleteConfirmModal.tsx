import Modal from '../../../components/ui/Modal'

interface DeleteConfirmModalProps {
  open: boolean
  title: string
  message: string
  confirmLabel?: string
  onClose: () => void
  onConfirm: () => void
}

export default function DeleteConfirmModal({
  open,
  title,
  message,
  confirmLabel = 'Ya, Hapus',
  onClose,
  onConfirm,
}: DeleteConfirmModalProps) {
  return (
    <Modal
      open={open}
      onClose={onClose}
      title={title}
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
            {confirmLabel}
          </button>
        </>
      }
    >
      <p className="text-sm text-slate-600">{message}</p>
    </Modal>
  )
}