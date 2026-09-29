/**
 * Token warna SIGAP - BRIDA Kota Makassar.
 *
 * Nilai diambil dari desain Figma "Project-RPL" (tema maroon), jadi file ini
 * adalah padanan JavaScript dari @theme di src/index.css. Dipakai saat butuh
 * nilai warna di dalam kode (inline style, grafik, canvas).
 */

// 1. Warna utama (brand BRIDA - maroon)
export const BRAND_COLORS = {
  50: '#fbf3f3',
  100: '#f6e6e6',
  200: '#e8c3c3',
  300: '#d99a9a',
  400: '#b85c5c',
  500: '#8f2323',
  600: '#7a1c1c', // warna utama (tombol, nav aktif)
  700: '#611114', // hover
  800: '#4d0e10',
  900: '#3a0a0c',
  DEFAULT: '#7a1c1c',
}

// 2. Warna teks & netral
export const NEUTRAL_COLORS = {
  white: '#ffffff',
  ink: '#2b2b2b', // judul & teks utama
  muted: '#6e6e6e', // teks pendukung
  line: '#eae5e5', // garis / border
  canvas: '#f6f4f4', // latar halaman
  soft: '#f8fafc',
  100: '#f1f5f9',
  200: '#e2e8f0',
  300: '#cbd5e1',
  400: '#94a3b8',
  500: '#64748b',
  600: '#475569',
  700: '#334155',
  800: '#1e293b',
  900: '#0f172a',
  black: '#000000',
}

// 3. Status pengajuan (samakan dengan badge di Figma)
export const STATUS_COLORS = {
  draft: {
    label: 'Draft',
    bg: '#efebeb',
    text: '#6b6b6b',
    tailwind: 'bg-status-draft text-status-draft-ink',
  },
  proses: {
    label: 'Dalam Proses Verifikasi',
    bg: '#fff3cd',
    text: '#b8860b',
    tailwind: 'bg-status-proses text-status-proses-ink',
  },
  revisi: {
    label: 'Perlu Perbaikan',
    bg: '#f8d7da',
    text: '#842029',
    tailwind: 'bg-status-revisi text-status-revisi-ink',
  },
  selesai: {
    label: 'Disetujui',
    bg: '#d1e7dd',
    text: '#0f5132',
    tailwind: 'bg-status-selesai text-status-selesai-ink',
  },
}

// 4. Rekomendasi AI (human-in-the-loop: AI hanya menyarankan)
export const AI_STATUS = {
  lolos: { label: 'Lolos', color: '#0f5132', badgeClasses: 'bg-status-selesai text-status-selesai-ink' },
  rendah: { label: 'Keyakinan Rendah', color: '#b8860b', badgeClasses: 'bg-status-proses text-status-proses-ink' },
  gagal: { label: 'Gagal Diproses', color: '#842029', badgeClasses: 'bg-status-revisi text-status-revisi-ink' },
}

// 5. Warna bar kelengkapan dokumen
export const PROGRESS_COLORS = {
  track: '#efeaea',
  fill: '#0f5132',
}

/**
 * Warna indikator skor keyakinan AI (0 - 100).
 * @param score skor keyakinan
 */
export function getScoreColor(score: number) {
  if (score >= 75) return STATUS_COLORS.selesai
  if (score >= 50) return STATUS_COLORS.proses
  return STATUS_COLORS.revisi
}

export const COLORS = {
  brand: BRAND_COLORS,
  neutral: NEUTRAL_COLORS,
  status: STATUS_COLORS,
  ai: AI_STATUS,
  progress: PROGRESS_COLORS,
  getScoreColor,
}

export default COLORS
