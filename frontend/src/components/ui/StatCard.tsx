import type { ReactNode } from 'react'

interface StatBreakdown {
  label: string
  value: string | number
  tone?: 'default' | 'success' | 'warning' | 'danger'
}

interface StatCardProps {
  title: string
  value: ReactNode
  trend?: string
  breakdown?: StatBreakdown[]
  children?: ReactNode
  className?: string
}

const TONE_CLASS: Record<NonNullable<StatBreakdown['tone']>, string> = {
  default: 'text-slate-700',
  success: 'text-emerald-600',
  warning: 'text-amber-600',
  danger: 'text-rose-600',
}

export default function StatCard({
  title,
  value,
  trend,
  breakdown,
  children,
  className,
}: StatCardProps) {
  return (
    <div
      className={[
        'rounded-2xl border border-slate-200 bg-white p-6',
        className ?? '',
      ].join(' ')}
    >
      <div className="flex items-start justify-between gap-6">
        <div>
          <p className="text-sm text-slate-500">{title}</p>
          <p className="mt-2 text-4xl font-semibold text-slate-900">{value}</p>
          {trend ? (
            <p className="mt-2 text-xs font-medium text-emerald-600">{trend}</p>
          ) : null}
        </div>

        {breakdown && breakdown.length > 0 ? (
          <div className="flex gap-5 text-right">
            {breakdown.map((item) => (
              <div key={item.label}>
                <p className="text-xs text-slate-500">{item.label}</p>
                <p
                  className={[
                    'text-lg font-semibold',
                    TONE_CLASS[item.tone ?? 'default'],
                  ].join(' ')}
                >
                  {item.value}
                </p>
              </div>
            ))}
          </div>
        ) : null}
      </div>

      {children ? <div className="mt-4">{children}</div> : null}
    </div>
  )
}