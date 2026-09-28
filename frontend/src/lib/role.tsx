import { createContext, useContext, useEffect, useState } from 'react'
import type { Dispatch, ReactNode, SetStateAction } from 'react'
import { ROLES } from '../config/roles'

/*
  Sumber peran pengguna.

  SEMENTARA (belum ada auth): peran disimpan di localStorage dan bisa diganti
  lewat tombol di header. Ini cukup untuk pengembangan & demo.

  NANTI saat autentikasi sudah jadi: ganti isi useEffect di bawah dengan
  pemanggilan API (mis. api.get('/me')), sisanya tidak perlu diubah.
*/
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
    return saved || ROLES.ADMIN
  })

  useEffect(() => {
    window.localStorage.setItem(STORAGE_KEY, role)
  }, [role])

  const value: RoleContextValue = {
    role,
    setRole,
    // is(ROLES.ADMIN, ROLES.VERIFIKATOR) -> true kalau peran saat ini salah satunya
    is: (...allowed: string[]) => allowed.includes(role),
  }

  return <RoleContext.Provider value={value}>{children}</RoleContext.Provider>
}

export function useRole(): RoleContextValue {
  const ctx = useContext(RoleContext)
  if (!ctx) throw new Error('useRole() harus dipakai di dalam <RoleProvider>')
  return ctx
}
