import { Construction } from 'lucide-react'

/*
  Halaman kosong untuk modul yang belum dikerjakan.
  Ganti isinya dengan halaman asli, jangan hapus file-nya kalau masih dipakai rute.
*/
export default function PlaceholderPage({ title, description, useCase, owner }) {
  return (
    <div className="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center">
      <div className="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
        <Construction className="text-slate-400" size={22} />
      </div>
      <h1 className="text-lg font-semibold text-slate-800">{title}</h1>
      {description ? (
        <p className="mx-auto mt-1 max-w-xl text-sm text-slate-500">{description}</p>
      ) : null}

      <div className="mx-auto mt-6 max-w-md space-y-2 text-left text-xs text-slate-500">
        {useCase ? (
          <p>
            <span className="font-medium text-slate-600">Acuan SRS:</span> {useCase}
          </p>
        ) : null}
        {owner ? (
          <p>
            <span className="font-medium text-slate-600">Pemilik modul:</span> {owner}
          </p>
        ) : null}
      </div>
    </div>
  )
}
