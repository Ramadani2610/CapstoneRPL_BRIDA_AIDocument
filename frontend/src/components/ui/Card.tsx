import type { ReactNode } from 'react'

interface CardProps {
  className?: string
  children: ReactNode
}

export default function Card({ className = '', children }: CardProps) {
  return (
    <div className={'rounded-xl border border-slate-200 bg-white ' + className}>
      {children}
    </div>
  )
}
