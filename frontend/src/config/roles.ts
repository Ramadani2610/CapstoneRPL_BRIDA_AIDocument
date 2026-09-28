// Peran sesuai SRS Bab 2.2 (Inovator, Verifikator, Admin).
export const ROLES = {
  INOVATOR: 'inovator',
  VERIFIKATOR: 'verifikator',
  ADMIN: 'admin',
} as const

export type Role = (typeof ROLES)[keyof typeof ROLES]

// Label yang tampil di UI (mengikuti desain Figma: "Administrator").
// Record<string, ...> supaya aman di-index dengan role dari context (bertipe string).
export const ROLE_LABEL: Record<string, string> = {
  [ROLES.INOVATOR]: 'Inovator',
  [ROLES.VERIFIKATOR]: 'Verifikator',
  [ROLES.ADMIN]: 'Administrator',
}
