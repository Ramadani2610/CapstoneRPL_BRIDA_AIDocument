interface AvatarProps {
  name: string
  size?: 'sm' | 'md' | 'lg'
  tone?: 'default' | 'brand'
}

const SIZE_CLASS: Record<NonNullable<AvatarProps['size']>, string> = {
  sm: 'h-7 w-7 text-[11px]',
  md: 'h-9 w-9 text-xs',
  lg: 'h-11 w-11 text-sm',
}

const TONE_CLASS: Record<NonNullable<AvatarProps['tone']>, string> = {
  default: 'bg-slate-100 text-slate-600',
  brand: 'bg-brand-50 text-brand-700',
}

export function getInitials(name: string): string {
  const words = name.trim().split(/\s+/)
  if (words.length >= 2) {
    return (words[0][0] + words[1][0]).toUpperCase()
  }
  return name.replace(/[^a-zA-Z]/g, '').slice(0, 2).toUpperCase()
}

export default function Avatar({ name, size = 'md', tone = 'default' }: AvatarProps) {
  return (
    <div
      className={[
        'flex shrink-0 items-center justify-center rounded-full font-semibold',
        SIZE_CLASS[size],
        TONE_CLASS[tone],
      ].join(' ')}
      aria-label={name}
    >
      {getInitials(name)}
    </div>
  )
}