import {
  ChevronDown,
  Pencil,
  Plus,
  Search,
  Trash2,
} from 'lucide-react'
import { useMemo, useState } from 'react'
import Button from '../../../components/ui/Button'
import Card from '../../../components/ui/Card'
import { ROLE_LABEL, ROLES } from '../../../config/roles'

/*
  MODUL: Manajemen Pengguna (khusus admin)
  Acuan: SRS 3.2.22 - 3.2.25 (lihat/menambah/mengedit/menonaktifkan akun)

  Ini CONTOH POLA untuk halaman admin: breadcrumb + judul + tombol aksi,
  tab filter + pencarian, lalu tabel dengan kolom aksi.

  DATA MASIH DUMMY. Ganti dengan api.get('/users') begitu endpoint siap
  (lihat src/lib/api.js). Toggle status juga masih lokal - nanti panggil API.
*/

// Peran -> gaya badge. Ubah di sini saja kalau mau ganti warna.
const ROLE_STYLE = {
  [ROLES.INOVATOR]: 'bg-blue-50 text-blue-700 ring-blue-100',
  [ROLES.VERIFIKATOR]: 'bg-emerald-50 text-emerald-700 ring-emerald-100',
  [ROLES.ADMIN]: 'bg-brand-50 text-brand-700 ring-brand-100',
}

const PENGGUNA_AWAL = [
  { name: 'Andi Pratama', email: 'andi.pratama@makassarkota.go.id', opd: 'Dinas Komunikasi dan Informatika', role: ROLES.INOVATOR, aktif: true, login: '26 Sep 2026, 09:12' },
  { name: 'Nurul Hidayah', email: 'nurul.hidayah@makassarkota.go.id', opd: 'BRIDA Kota Makassar', role: ROLES.VERIFIKATOR, aktif: true, login: '26 Sep 2026, 08:30' },
  { name: 'Muh. Rizal Syam', email: 'rizal.syam@makassarkota.go.id', opd: 'BRIDA Kota Makassar', role: ROLES.ADMIN, aktif: true, login: '26 Sep 2026, 07:55' },
  { name: 'Sitti Rahmawati', email: 'sitti.rahmawati@makassarkota.go.id', opd: 'Dinas Kesehatan', role: ROLES.INOVATOR, aktif: true, login: '25 Sep 2026, 16:42' },
  { name: 'Dr. Hasanuddin Latief', email: 'hasanuddin.latief@makassarkota.go.id', opd: 'BRIDA Kota Makassar', role: ROLES.VERIFIKATOR, aktif: true, login: '25 Sep 2026, 14:10' },
  { name: 'Ahmad Fauzi', email: 'ahmad.fauzi@makassarkota.go.id', opd: 'Dinas Perhubungan', role: ROLES.INOVATOR, aktif: true, login: '24 Sep 2026, 11:03' },
  { name: 'Irma Suryani', email: 'irma.suryani@makassarkota.go.id', opd: 'BRIDA Kota Makassar', role: ROLES.VERIFIKATOR, aktif: true, login: '23 Sep 2026, 10:21' },
  { name: 'Fadli Ramadhan', email: 'fadli.ramadhan@makassarkota.go.id', opd: 'Dinas Lingkungan Hidup', role: ROLES.INOVATOR, aktif: false, login: '12 Agu 2025, 09:47' },
  { name: 'Rini Kartika', email: 'rini.kartika@makassarkota.go.id', opd: 'Dinas Pendidikan', role: ROLES.INOVATOR, aktif: true, login: '22 Sep 2026, 05:30' },
  { name: 'Yusuf Doeng Tompo', email: 'yusuf.tompo@makassarkota.go.id', opd: 'Kecamatan Tamalate', role: ROLES.INOVATOR, aktif: true, login: 'Belum pernah' },
]

const TABS = [
  { key: 'semua', label: 'Semua' },
  { key: ROLES.INOVATOR, label: ROLE_LABEL[ROLES.INOVATOR] },
  { key: ROLES.VERIFIKATOR, label: ROLE_LABEL[ROLES.VERIFIKATOR] },
  { key: ROLES.ADMIN, label: ROLE_LABEL[ROLES.ADMIN] },
]

function initials(name) {
  return name
    .split(' ')
    .filter((part) => /^[A-Za-z]/.test(part))
    .slice(0, 2)
    .map((part) => part[0].toUpperCase())
    .join('')
}

export default function ManajemenPenggunaPage() {
  const [pengguna, setPengguna] = useState(PENGGUNA_AWAL)
  const [tab, setTab] = useState('semua')
  const [query, setQuery] = useState('')

  const jumlahPerTab = useMemo(() => {
    const total = { semua: pengguna.length }
    for (const role of [ROLES.INOVATOR, ROLES.VERIFIKATOR, ROLES.ADMIN]) {
      total[role] = pengguna.filter((u) => u.role === role).length
    }
    return total
  }, [pengguna])

  const baris = useMemo(() => {
    const kata = query.trim().toLowerCase()
    return pengguna.filter((u) => {
      if (tab !== 'semua' && u.role !== tab) return false
      if (!kata) return true
      return (
        u.name.toLowerCase().includes(kata) ||
        u.email.toLowerCase().includes(kata) ||
        u.opd.toLowerCase().includes(kata)
      )
    })
  }, [pengguna, tab, query])

  // SEMENTARA: hanya ubah status di layar. Nanti ganti dengan panggilan API.
  function toggleAktif(email) {
    setPengguna((sebelum) =>
      sebelum.map((u) => (u.email === email ? { ...u, aktif: !u.aktif } : u)),
    )
  }

  return (
    <div className="space-y-4">
      {/* Judul halaman */}
      <div>
        <nav className="text-xs text-slate-400">
          Dashboard <span className="mx-1">/</span>
          <span className="text-slate-600">Kelola Pengguna</span>
        </nav>
        <div className="mt-1 flex flex-wrap items-end justify-between gap-3">
          <div>
            <h1 className="text-xl font-semibold text-slate-800">Kelola Akun Pengguna</h1>
            <p className="mt-1 text-sm text-slate-500">
              Atur akses akun: inovator, verifikator BRIDA, dan administrator sistem.
            </p>
          </div>
          <Button>
            <Plus size={16} />
            Tambah Pengguna
          </Button>
        </div>
      </div>

      {/* Tab filter peran */}
      <div className="flex flex-wrap items-center justify-between gap-3">
        <div className="flex flex-wrap gap-2">
          {TABS.map((item) => {
            const aktif = item.key === tab
            return (
              <button
                key={item.key}
                type="button"
                onClick={() => setTab(item.key)}
                className={[
                  'inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm transition',
                  aktif
                    ? 'bg-brand-600 font-medium text-white'
                    : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50',
                ].join(' ')}
              >
                {item.label}
                <span
                  className={[
                    'rounded-full px-2 py-0.5 text-xs',
                    aktif ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500',
                  ].join(' ')}
                >
                  {jumlahPerTab[item.key]}
                </span>
              </button>
            )
          })}
        </div>

        <div className="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2">
          <Search size={16} className="text-slate-400" />
          <input
            value={query}
            onChange={(event) => setQuery(event.target.value)}
            placeholder="Cari nama, email, atau OPD"
            className="w-56 bg-transparent text-sm outline-none placeholder:text-slate-400"
          />
        </div>
      </div>

      {/* Tabel pengguna */}
      <Card>
        <div className="overflow-x-auto">
          <table className="w-full text-left text-sm">
            <thead className="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
              <tr>
                <th className="w-10 px-4 py-3">
                  <input type="checkbox" className="rounded" />
                </th>
                <th className="px-4 py-3 font-medium">Pengguna</th>
                <th className="px-4 py-3 font-medium">OPD / Instansi</th>
                <th className="px-4 py-3 font-medium">Peran</th>
                <th className="px-4 py-3 font-medium">Status</th>
                <th className="px-4 py-3 font-medium">Login Terakhir</th>
                <th className="px-4 py-3 font-medium">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100">
              {baris.map((u) => (
                <tr key={u.email} className="hover:bg-slate-50/60">
                  <td className="px-4 py-3">
                    <input type="checkbox" className="rounded" />
                  </td>
                  <td className="px-4 py-3">
                    <div className="flex items-center gap-3">
                      <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-200 text-xs font-semibold text-slate-600">
                        {initials(u.name)}
                      </div>
                      <div className="leading-tight">
                        <p className="font-medium text-slate-800">{u.name}</p>
                        <p className="text-xs text-slate-500">{u.email}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-4 py-3 text-slate-600">{u.opd}</td>
                  <td className="px-4 py-3">
                    <span
                      className={
                        'inline-flex rounded-full px-2.5 py-1 text-xs font-medium ring-1 ' +
                        ROLE_STYLE[u.role]
                      }
                    >
                      {ROLE_LABEL[u.role]}
                    </span>
                  </td>
                  <td className="px-4 py-3">
                    <div className="flex items-center gap-2">
                      <button
                        type="button"
                        onClick={() => toggleAktif(u.email)}
                        title={u.aktif ? 'Nonaktifkan' : 'Aktifkan'}
                        className={[
                          'relative h-5 w-9 rounded-full transition',
                          u.aktif ? 'bg-emerald-500' : 'bg-slate-300',
                        ].join(' ')}
                      >
                        <span
                          className={[
                            'absolute top-0.5 h-4 w-4 rounded-full bg-white shadow transition',
                            u.aktif ? 'left-4' : 'left-0.5',
                          ].join(' ')}
                        />
                      </button>
                      <span
                        className={
                          'text-xs font-medium ' +
                          (u.aktif ? 'text-emerald-600' : 'text-slate-400')
                        }
                      >
                        {u.aktif ? 'AKTIF' : 'Nonaktif'}
                      </span>
                    </div>
                  </td>
                  <td className="px-4 py-3 text-slate-600">{u.login}</td>
                  <td className="px-4 py-3">
                    <div className="flex items-center gap-1">
                      <button
                        type="button"
                        title="Ubah akun"
                        className="rounded p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600"
                      >
                        <Pencil size={16} />
                      </button>
                      <button
                        type="button"
                        title="Hapus / nonaktifkan"
                        className="rounded p-1.5 text-slate-400 hover:bg-red-50 hover:text-red-600"
                      >
                        <Trash2 size={16} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}

              {baris.length === 0 ? (
                <tr>
                  <td colSpan={7} className="px-4 py-10 text-center text-sm text-slate-500">
                    Tidak ada pengguna pada filter ini.
                  </td>
                </tr>
              ) : null}
            </tbody>
          </table>
        </div>

        <div className="flex items-center justify-between border-t border-slate-100 px-4 py-3 text-xs text-slate-500">
          <span>
            Menampilkan {baris.length} dari {pengguna.length} pengguna
          </span>
          <button
            type="button"
            className="inline-flex items-center gap-1 rounded-md border border-slate-200 px-2 py-1 hover:bg-slate-50"
          >
            Baris per halaman: 10
            <ChevronDown size={14} />
          </button>
        </div>
      </Card>
    </div>
  )
}
