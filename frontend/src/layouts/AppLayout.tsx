import { useState } from 'react'
import { Outlet } from 'react-router-dom'
import Sidebar from './Sidebar'
import Topbar from './Topbar'

export default function AppLayout() {
  const [isSidebarOpen, setIsSidebarOpen] = useState(false)

  return (
    // Mengunci layar penuh dengan h-screen dan overflow-hidden
    <div className="flex h-screen flex-col overflow-hidden bg-canvas text-ink">
      {/* Topbar tetap di posisi atas */}
      <Topbar onToggleSidebar={() => setIsSidebarOpen((prev) => !prev)} />

      {/* Container utama di bawah Topbar */}
      <div className="flex flex-1 overflow-hidden">
        <Sidebar isOpen={isSidebarOpen} onClose={() => setIsSidebarOpen(false)} />

        {/* HANYA area main ini yang memiliki scrollbar */}
        <main className="flex-1 overflow-y-auto p-6 lg:p-8">
          <Outlet />
        </main>
      </div>
    </div>
  )
}