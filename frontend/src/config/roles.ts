// Peran sesuai SRS Bab 2.2 (Inovator, Verifikator, Admin).

export const ROLES = {
  INOVATOR: 'inovator',
  VERIFIKATOR: 'verifikator',
  ADMIN: 'admin',
} as const

export type Role = (typeof ROLES)[keyof typeof ROLES]


export const ROLE_LABEL: Record<string, string> = {
  [ROLES.INOVATOR]: 'Inovator',
  [ROLES.VERIFIKATOR]: 'Verifikator',
  [ROLES.ADMIN]: 'Administrator',
}

export interface UserProfile {
  name: string
  unit: string
}

/*
  Profil contoh, SEMENTARA sampai autentikasi jadi.
  Dipakai header biar tampilan mirip desain. Nanti diganti data dari API.
*/
export const DEMO_PROFILE: Record<string, UserProfile> = {
  [ROLES.INOVATOR]: { name: 'Andi Pratama', unit: 'Dinas Komunikasi dan Informatika' },
  [ROLES.VERIFIKATOR]: { name: 'Nurul Hidayah', unit: 'BRIDA Kota Makassar' },
  [ROLES.ADMIN]: { name: 'Muh. Rizal Syam', unit: 'BRIDA Kota Makassar' },
}
