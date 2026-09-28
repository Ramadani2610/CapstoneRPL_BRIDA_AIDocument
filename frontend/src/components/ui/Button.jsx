const VARIANTS = {
  primary: 'bg-brand-600 text-white hover:bg-brand-700',
  secondary: 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50',
  ghost: 'bg-transparent text-slate-600 hover:bg-slate-100',
}

const SIZES = {
  sm: 'px-3 py-1.5 text-xs',
  md: 'px-4 py-2 text-sm',
}

export default function Button({
  variant = 'primary',
  size = 'md',
  className = '',
  ...props
}) {
  return (
    <button
      className={
        'inline-flex items-center justify-center gap-1.5 rounded-lg font-medium transition ' +
        'disabled:cursor-not-allowed disabled:opacity-50 ' +
        VARIANTS[variant] + ' ' + SIZES[size] + ' ' + className
      }
      {...props}
    />
  )
}
