import type { ReactNode } from 'react'

interface CardProps {
  className?: string
  children: ReactNode
}

export default function Card({ className = '', children }: CardProps) {
  return (
    <div className={'rounded-xl border border-line bg-white shadow-[0px_6px_20px_-8px_rgba(60,20,20,0.08)] ' + className}>
      {children}
    </div>
  )
}
