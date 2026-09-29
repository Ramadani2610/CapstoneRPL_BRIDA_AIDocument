import { Link } from 'react-router-dom'
import Button from '../components/ui/Button'

export default function NotFoundPage() {
  return (
    <div className="rounded-xl border border-line bg-white p-10 text-center">
      <p className="text-4xl font-bold text-line">404</p>
      <h1 className="mt-2 text-lg font-semibold text-ink">Halaman tidak ditemukan</h1>
      <p className="mt-1 text-sm text-muted">Periksa kembali alamat halaman, atau kembali ke menu utama.</p>
      <Link to="/" className="mt-5 inline-block">
        <Button>Ke menu utama</Button>
      </Link>
    </div>
  )
}
