import { Outlet } from 'react-router-dom'
import Sidebar from './Sidebar'
import Topbar from './Topbar'

/*
  Kerangka aplikasi: header penuh di atas, sidebar di kiri, isi halaman di kanan.
  Semua halaman otomatis memakai kerangka ini karena dipasang sebagai parent route
  (lihat src/routes.jsx).
*/
export default function AppLayout() {
  return (
    <div className="min-h-screen bg-slate-50 text-slate-900">
      <Topbar />
      <div className="flex">
        <Sidebar />
        <main className="min-w-0 flex-1 p-6 lg:p-8">
          <Outlet />
        </main>
      </div>
    </div>
  )
}
