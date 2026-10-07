import type { ButtonHTMLAttributes } from 'react'

const VARIANTS = {
  primary: 'bg-brand-600 text-white hover:bg-brand-700',
  secondary: 'bg-white text-ink border border-line hover:bg-brand-50',
  ghost: 'bg-transparent text-muted hover:bg-brand-50 hover:text-brand-600',
}

const SIZES = {
  sm: 'h-8 px-3 text-xs',
  md: 'h-10 px-4 text-sm',
}

type ButtonVariant = keyof typeof VARIANTS
type ButtonSize = keyof typeof SIZES

interface ButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
  variant?: ButtonVariant
  size?: ButtonSize
}

export default function Button({ variant = 'primary', size = 'md', className = '', ...props }: ButtonProps) {
  return (
    <button
      className={
        'inline-flex items-center justify-center gap-1.5 rounded-lg font-medium transition ' +
        'disabled:cursor-not-allowed disabled:opacity-50 ' +
        VARIANTS[variant] +
        ' ' +
        SIZES[size] +
        ' ' +
        className
      }
      {...props}
    />
  )
}
