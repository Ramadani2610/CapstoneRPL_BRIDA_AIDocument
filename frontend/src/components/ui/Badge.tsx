/*
  Badge status. Varian mengikuti status yang ada di SRS:
    success -> "Sesuai" / "Saran AI: Lolos"
    warning -> "Perlu Review" / "Keyakinan Rendah"
    danger  -> "Gagal Diproses"
    info    -> "Menunggu Review"
    neutral -> keterangan umum
*/
import type { ReactNode } from 'react'
import type { LucideIcon } from 'lucide-react'

const VARIANTS = {
  success: 'bg-emerald-100 text-emerald-700',
  warning: 'bg-orange-100 text-orange-700',
  danger: 'bg-red-100 text-red-700',
  info: 'bg-amber-100 text-amber-700',
  neutral: 'bg-slate-100 text-slate-600',
}

export type BadgeVariant = keyof typeof VARIANTS

interface BadgeProps {
  variant?: BadgeVariant
  icon?: LucideIcon
  children: ReactNode
}

export default function Badge({ variant = 'neutral', icon: Icon, children }: BadgeProps) {
  return (
    <span
      className={
        'inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-medium ' +
        VARIANTS[variant]
      }
    >
      {Icon ? <Icon size={13} /> : null}
      {children}
    </span>
  )
}
