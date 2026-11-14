import { ExternalLink, Info, Star } from 'lucide-react'
import type { Indikator, OpsiPenilaian } from './data'

interface IndikatorDetailProps {
  indikator: Indikator | null
}

export default function IndikatorDetail({ indikator }: IndikatorDetailProps) {
  if (!indikator) {
    return (
      <div className="flex h-full items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-white p-10">
        <p className="text-sm text-slate-500">
          Pilih indikator di sebelah kiri untuk melihat detail.
        </p>
      </div>
    )
  }

  const maxPoin = indikator.bobot * 3

  return (
    <div className="rounded-2xl border border-slate-200 bg-white">
      <div className="border-b border-slate-100 p-6">
        <div className="mb-3 flex flex-wrap items-center gap-2">
          <span className="rounded bg-slate-100 px-2 py-0.5 text-xs font-mono font-semibold text-slate-600">
            {indikator.kode}
          </span>
          {indikator.mandatory ? (
            <span className="rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700">
              MANDATORY
            </span>
          ) : null}
          <span
            className={[
              'flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium',
              indikator.aktif
                ? 'bg-emerald-50 text-emerald-700'
                : 'bg-slate-100 text-slate-500',
            ].join(' ')}
          >
            <span
              className={[
                'h-1.5 w-1.5 rounded-full',
                indikator.aktif ? 'bg-emerald-500' : 'bg-slate-400',
              ].join(' ')}
            />
            {indikator.aktif ? 'Aktif' : 'Nonaktif'}
          </span>
        </div>
        <h2 className="text-xl font-semibold text-slate-900">{indikator.nama}</h2>
        <p className="mt-2 text-sm text-slate-600">{indikator.deskripsi}</p>
      </div>

      <div className="space-y-6 p-6">
        <section>
          <h3 className="mb-2 text-sm font-semibold text-slate-800">Bobot Penilaian</h3>
          <div className="flex items-baseline gap-2 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
            <span className="text-2xl font-semibold text-brand-700">{indikator.bobot}</span>
            <span className="text-sm text-slate-600">
              × 3 bintang = maks {maxPoin} poin
            </span>
          </div>
        </section>

        <section>
          <h3 className="mb-3 text-sm font-semibold text-slate-800">Opsi Penilaian</h3>
          <ul className="space-y-2">
            {indikator.opsiPenilaian.map((opsi) => (
              <OpsiItem key={opsi.bintang} opsi={opsi} />
            ))}
          </ul>
        </section>

        {indikator.catatanTambahan ? (
          <section>
            <div className="flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 p-4">
              <Info size={18} className="mt-0.5 shrink-0 text-amber-600" />
              <div>
                <p className="text-sm font-semibold text-amber-900">Catatan Tambahan</p>
                <p className="mt-1 text-sm text-amber-800">{indikator.catatanTambahan}</p>
              </div>
            </div>
          </section>
        ) : null}

        <section>
          <h3 className="mb-2 text-sm font-semibold text-slate-800">
            Eviden &amp; Bukti Dukung
          </h3>
          <div className="rounded-lg border border-slate-200 bg-white p-4">
            <p className="text-sm text-slate-700">{indikator.eviden.deskripsi}</p>
            <div className="mt-3">
              <span className="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">
                {indikator.eviden.formatFile}
              </span>
            </div>
          </div>
        </section>

        {indikator.contohBuktiUrl ? (
          <section>
            <h3 className="mb-2 text-sm font-semibold text-slate-800">
              Contoh Bukti dari BRIDA
            </h3>
            <a
              href={indikator.contohBuktiUrl}
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center gap-2 rounded-lg border border-brand-200 bg-brand-50 px-4 py-2 text-sm font-medium text-brand-700 transition hover:bg-brand-100"
            >
              <ExternalLink size={14} />
              Lihat Contoh Bukti
            </a>
          </section>
        ) : null}
      </div>
    </div>
  )
}

interface OpsiItemProps {
  opsi: OpsiPenilaian
}

function OpsiItem({ opsi }: OpsiItemProps) {
  const isTerbaik = opsi.bintang === 3
  return (
    <li
      className={[
        'flex items-start gap-3 rounded-lg border p-3',
        isTerbaik
          ? 'border-emerald-200 bg-emerald-50'
          : 'border-slate-200 bg-white',
      ].join(' ')}
    >
      <div className="flex shrink-0 items-center gap-0.5">
        {Array.from({ length: opsi.bintang }).map((_, idx) => (
          <Star
            key={idx}
            size={14}
            className={isTerbaik ? 'fill-emerald-500 text-emerald-500' : 'fill-amber-400 text-amber-400'}
          />
        ))}
      </div>
      <div className="min-w-0 flex-1">
        <p className={['text-sm', isTerbaik ? 'text-emerald-900' : 'text-slate-700'].join(' ')}>
          {opsi.deskripsi}
        </p>
        {isTerbaik ? (
          <p className="mt-0.5 text-[11px] font-semibold uppercase tracking-wide text-emerald-700">
            Nilai terbaik
          </p>
        ) : null}
      </div>
    </li>
  )
}
