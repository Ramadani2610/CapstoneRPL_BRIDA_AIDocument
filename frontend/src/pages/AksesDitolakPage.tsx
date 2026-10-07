import { ShieldAlert } from 'lucide-react'
import { Link } from 'react-router-dom'
import Button from '../components/ui/Button'
import { defaultPathForRole } from '../config/navigation'
import { ROLE_LABEL } from '../config/roles'
import { useRole } from '../lib/role'

export default function AksesDitolakPage({ allow = [] }: { allow?: string[] }) {
  const { role } = useRole()

  return (
    <div className="rounded-xl border border-line bg-white p-10 text-center">
      <ShieldAlert className="mx-auto mb-3 text-brand-600" size={30} />
      <h1 className="text-lg font-semibold text-ink">Halaman ini bukan untuk peran {ROLE_LABEL[role]}</h1>
      <p className="mt-1 text-sm text-muted">
        Hanya bisa dibuka oleh: {allow.map((item) => ROLE_LABEL[item]).join(', ') || '-'}
      </p>
      <Link to={defaultPathForRole(role)} className="mt-5 inline-block">
        <Button variant="secondary">Kembali ke halaman utama</Button>
      </Link>
    </div>
  )
}
