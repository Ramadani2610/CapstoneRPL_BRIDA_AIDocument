import type { ReactNode } from 'react'

const VARIANTS = {
  draft: 'bg-status-draft text-status-draft-ink',
  proses: 'bg-status-proses text-status-proses-ink',
  revisi: 'bg-status-revisi text-status-revisi-ink',
  selesai: 'bg-status-selesai text-status-selesai-ink',
}

export type BadgeVariant = keyof typeof VARIANTS

interface BadgeProps {
  variant?: BadgeVariant
  icon?: ReactNode
  children: ReactNode
}

export default function Badge({ variant = 'draft', icon, children }: BadgeProps) {
  return (
    <span className={'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium ' + VARIANTS[variant]}>
      {icon}
      {children}
    </span>
  )
}
