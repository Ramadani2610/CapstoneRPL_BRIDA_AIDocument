import { useState } from 'react'
import { Outlet } from 'react-router-dom'
import Sidebar from './Sidebar'
import Topbar from './Topbar'

export default function AppLayout() {
  const [isSidebarOpen, setIsSidebarOpen] = useState(false)

  return (
    <div className="min-h-screen bg-canvas text-ink">
      <Topbar onToggleSidebar={() => setIsSidebarOpen((prev) => !prev)} />
      {/* min-h dipakai supaya sidebar tetap penuh ke bawah seperti di desain,
          meski isi halaman hanya sebentar. */}
      <div className="flex min-h-[calc(100vh-4rem)]">
        <Sidebar isOpen={isSidebarOpen} onClose={() => setIsSidebarOpen(false)} />
        <main className="min-w-0 flex-1 p-6 lg:p-8">
          <Outlet />
        </main>
      </div>
    </div>
  )
}