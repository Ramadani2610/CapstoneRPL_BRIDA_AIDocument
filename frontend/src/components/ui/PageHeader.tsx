import type { ReactNode } from 'react'
import { HomeIcon, ChevronRightIcon } from '../icons'

interface PageHeaderProps {
  breadcrumb: string
  title: string
  subtitle?: string
  action?: ReactNode
}

export default function PageHeader({ breadcrumb, title, subtitle, action }: PageHeaderProps) {
  return (
    <div className="flex flex-wrap items-start justify-between gap-4">
      <div>
        <div className="flex items-center gap-1.5 text-xs text-ink">
          <HomeIcon className="size-3.5 text-muted" />
          <ChevronRightIcon className="size-3.5 text-muted" />
          <span>{breadcrumb}</span>
        </div>
        <h1 className="mt-2 text-2xl font-bold text-ink">{title}</h1>
        {subtitle ? <p className="mt-1 text-sm text-muted">{subtitle}</p> : null}
      </div>
      {action}
    </div>
  )
}
