interface ToggleProps {
  checked: boolean
  onChange: (checked: boolean) => void
  label?: string
  size?: 'sm' | 'md'
  disabled?: boolean
}

const SIZE_CLASS: Record<NonNullable<ToggleProps['size']>, {
  track: string
  thumb: string
  translate: string
}> = {
  sm: {
    track: 'h-5 w-9',
    thumb: 'h-4 w-4',
    translate: 'translate-x-4',
  },
  md: {
    track: 'h-6 w-11',
    thumb: 'h-5 w-5',
    translate: 'translate-x-5',
  },
}

export default function Toggle({
  checked,
  onChange,
  label,
  size = 'md',
  disabled = false,
}: ToggleProps) {
  const sizeClasses = SIZE_CLASS[size]

  return (
    <button
      type="button"
      role="switch"
      aria-checked={checked}
      aria-label={label}
      disabled={disabled}
      onClick={() => onChange(!checked)}
      className={[
        'relative inline-flex shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors',
        'focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2',
        checked ? 'bg-brand-700' : 'bg-slate-200',
        disabled ? 'cursor-not-allowed opacity-50' : '',
        sizeClasses.track,
      ].join(' ')}
    >
      <span
        className={[
          'pointer-events-none inline-block transform rounded-full bg-white shadow-md transition',
          checked ? sizeClasses.translate : 'translate-x-0',
          sizeClasses.thumb,
        ].join(' ')}
      />
    </button>
  )
}