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
    const saved = window.localStorage.getItem(STORAGE_KEY)
    // REVISI: Kosongkan default jika tidak ada data di localStorage (jangan langsung ROLES.ADMIN)
    return saved || ''
  })

  useEffect(() => {
    if (role) {
      window.localStorage.setItem(STORAGE_KEY, role)
    } else {
      window.localStorage.removeItem(STORAGE_KEY)
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