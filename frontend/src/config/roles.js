// Peran sesuai SRS Bab 2.2 (Inovator, Verifikator, Admin).
// Jangan tulis string peran langsung di halaman - pakai konstanta ini.
export const ROLES = {
  INOVATOR: 'inovator',
  VERIFIKATOR: 'verifikator',
  ADMIN: 'admin',
}

// Label yang tampil di UI (mengikuti desain Figma: "Administrator").
export const ROLE_LABEL = {
  [ROLES.INOVATOR]: 'Inovator',
  [ROLES.VERIFIKATOR]: 'Verifikator',
  [ROLES.ADMIN]: 'Administrator',
}

/*
  Profil contoh, SEMENTARA sampai autentikasi jadi.
  Dipakai header biar tampilan mirip desain. Nanti diganti data dari API.
*/
export const DEMO_PROFILE = {
  [ROLES.INOVATOR]: { name: 'Andi Pratama', unit: 'Dinas Komunikasi dan Informatika' },
  [ROLES.VERIFIKATOR]: { name: 'Nurul Hidayah', unit: 'BRIDA Kota Makassar' },
  [ROLES.ADMIN]: { name: 'Muh. Rizal Syam', unit: 'BRIDA Kota Makassar' },
}
