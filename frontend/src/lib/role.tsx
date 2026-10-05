import { createContext, useContext, useEffect, useState } from 'react'
import type { Dispatch, ReactNode, SetStateAction } from 'react'

const STORAGE_KEY = 'brida.role'

interface RoleContextValue {
  role: string
  setRole: Dispatch<SetStateAction<string>>
  is: (...allowed: string[]) => boolean
}

const RoleContext = createContext<RoleContextValue | null>(null)

export function RoleProvider({ children }: { children: ReactNode }) {
  const [role, setRole] = useState<string>(() => {
    // Menggunakan sessionStorage agar reset saat tab ditutup
    const saved = window.sessionStorage.getItem(STORAGE_KEY)
    return saved || ''
  })

  useEffect(() => {
    if (role) {
      window.sessionStorage.setItem(STORAGE_KEY, role)
    } else {
      window.sessionStorage.removeItem(STORAGE_KEY)
    }
  }, [role])

  const value: RoleContextValue = {
    role,
    setRole,
    is: (...allowed: string[]) => allowed.includes(role),
  }

  return <RoleContext.Provider value={value}>{children}</RoleContext.Provider>
}

export function useRole(): RoleContextValue {
  const ctx = useContext(RoleContext)
  if (!ctx) throw new Error('useRole() harus dipakai di dalam <RoleProvider>')
  return ctx
}