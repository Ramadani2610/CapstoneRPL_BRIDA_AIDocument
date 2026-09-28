import { Link } from 'react-router-dom'
import Button from '../components/ui/Button'

export default function NotFoundPage() {
  return (
    <div className="rounded-xl border border-slate-200 bg-white p-10 text-center">
      <p className="text-4xl font-bold text-slate-300">404</p>
      <h1 className="mt-2 text-lg font-semibold">Halaman tidak ditemukan</h1>
      <p className="mt-1 text-sm text-slate-500">
        Periksa kembali alamat halaman, atau kembali ke menu utama.
      </p>
      <Link to="/" className="mt-5 inline-block">
        <Button>Ke menu utama</Button>
      </Link>
    </div>
  )
}
