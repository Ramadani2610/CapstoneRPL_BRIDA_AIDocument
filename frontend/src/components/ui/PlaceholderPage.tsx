import { Construction } from 'lucide-react'

interface PlaceholderPageProps {
  title: string
  description?: string
  useCase?: string
  owner?: string
}

export default function PlaceholderPage({ title, description, useCase, owner }: PlaceholderPageProps) {
  return (
    <div className="rounded-xl border border-dashed border-line bg-white p-10 text-center">
      <div className="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-canvas">
        <Construction className="text-muted" size={22} />
      </div>
      <h1 className="text-lg font-semibold text-ink">{title}</h1>
      {description ? <p className="mx-auto mt-1 max-w-xl text-sm text-muted">{description}</p> : null}

      <div className="mx-auto mt-6 max-w-md space-y-2 text-left text-xs text-muted">
        {useCase ? (
          <p>
            <span className="font-medium text-ink">Acuan SRS:</span> {useCase}
          </p>
        ) : null}
        {owner ? (
          <p>
            <span className="font-medium text-ink">Pemilik modul:</span> {owner}
          </p>
        ) : null}
      </div>
    </div>
  )
}
