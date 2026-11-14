import { ChevronRight, Home } from 'lucide-react'
import { useEffect, useRef, useState } from 'react'
import IndikatorDetail from './IndikatorDetail'
import IndikatorSidebar from './IndikatorSidebar'
import { INDIKATORS } from './data'

export default function IndikatorPage() {
  const [selectedId, setSelectedId] = useState<string | null>(INDIKATORS[0]?.id ?? null)
  const detailRef = useRef<HTMLDivElement>(null)
  // Hindari auto-scroll saat first render (mobile user belum pernah interaksi).
  const isMountedRef = useRef(false)

  useEffect(() => {
    if (!isMountedRef.current) {
      isMountedRef.current = true
      return
    }
    if (!selectedId) return
    if (window.matchMedia('(max-width: 1023px)').matches) {
      detailRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
  }, [selectedId])

  const selected = INDIKATORS.find((ind) => ind.id === selectedId) ?? null

  return (
    <div className="space-y-6">
      <Breadcrumb />

      <div>
        <h1 className="text-2xl font-semibold text-slate-900">Indikator &amp; Parameter</h1>
        <p className="mt-1 text-sm text-slate-500">
          Referensi standar indikator penilaian inovasi daerah menurut Panduan Inovasi BRIDA
          (IID Kemendagri 2026). 20 indikator, skor maksimal 111 poin.
        </p>
      </div>

      <div className="grid gap-6 lg:grid-cols-[320px_1fr]">
        <IndikatorSidebar
          indikators={INDIKATORS}
          selectedId={selectedId}
          onSelect={setSelectedId}
        />
        <div ref={detailRef} className="scroll-mt-4">
          <IndikatorDetail indikator={selected} />
        </div>
      </div>
    </div>
  )
}

function Breadcrumb() {
  return (
    <nav className="flex items-center gap-2 text-sm text-slate-500">
      <Home size={15} />
      <ChevronRight size={14} />
      <span>Dashboard</span>
      <ChevronRight size={14} />
      <span className="text-slate-700">Indikator &amp; Parameter</span>
    </nav>
  )
}
