/**
 * Color Palette SIGAP - BRIDA Kota Makassar
 * 
 * File ini berisi kumpulan token warna standar yang digunakan di seluruh aplikasi.
 * Dapat di-import di komponen React, grafik (Chart.js / Recharts), inline style, maupun utility.
 */

// 1. Warna Utama (Brand Identity BRIDA - Maroon)
// Sinkron dengan definisi @theme di src/index.css
export const BRAND_COLORS = {
  50: '#fdecec',
  100: '#fbd9d9',
  200: '#f2b5b5',
  300: '#e58f8f',
  400: '#c9524f',
  500: '#a32020',
  600: '#8c1d1d', // Primary / Brand Utama
  700: '#731717', // Hover / Darker Maroon
  800: '#5c1212',
  900: '#450e0e',
  DEFAULT: '#8c1d1d',
}

// 2. Warna Netral (Slate) untuk background, border, teks
export const NEUTRAL_COLORS = {
  white: '#ffffff',
  50: '#f8fafc',
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

// 3. Status Semantik & Review Dokumen (Sesuai SRS & Badge)
export const STATUS_COLORS = {
  success: {
    label: 'Lolos / Sesuai',
    hex: '#059669', // emerald-600
    bg: '#d1fae5',  // emerald-100
    text: '#047857', // emerald-700
    border: '#a7f3d0',
    tailwind: 'bg-emerald-100 text-emerald-700',
  },
  warning: {
    label: 'Perlu Review / Keyakinan Rendah',
    hex: '#ea580c', // orange-600
    bg: '#ffedd5',  // orange-100
    text: '#c2410c', // orange-700
    border: '#fed7aa',
    tailwind: 'bg-orange-100 text-orange-700',
  },
  danger: {
    label: 'Gagal / Ditolak',
    hex: '#dc2626', // red-600
    bg: '#fee2e2',  // red-100
    text: '#b91c1c', // red-700
    border: '#fca5a5',
    tailwind: 'bg-red-100 text-red-700',
  },
  info: {
    label: 'Menunggu Review / Dalam Proses',
    hex: '#d97706', // amber-600
    bg: '#fef3c7',  // amber-100
    text: '#b45309', // amber-700
    border: '#fde68a',
    tailwind: 'bg-amber-100 text-amber-700',
  },
  neutral: {
    label: 'Keterangan Umum',
    hex: '#475569', // slate-600
    bg: '#f1f5f9',  // slate-100
    text: '#475569', // slate-600
    border: '#e2e8f0',
    tailwind: 'bg-slate-100 text-slate-600',
  },
}

// 4. Rekomendasi Keyakinan AI (AI Confidence Score)
export const AI_STATUS = {
  lolos: {
    label: 'Lolos',
    variant: 'success',
    color: STATUS_COLORS.success.hex,
    badgeClasses: STATUS_COLORS.success.tailwind,
  },
  rendah: {
    label: 'Keyakinan Rendah',
    variant: 'warning',
    color: STATUS_COLORS.warning.hex,
    badgeClasses: STATUS_COLORS.warning.tailwind,
  },
  gagal: {
    label: 'Gagal Diproses',
    variant: 'danger',
    color: STATUS_COLORS.danger.hex,
    badgeClasses: STATUS_COLORS.danger.tailwind,
  },
}

// 5. Helper utility fungsi pembantu terkait warna
/**
 * Mendapatkan warna berdasarkan skor kepercayaan AI (0 - 100)
 * @param {number} score 
 * @returns {object} { hex, text, bg, variant }
 */
export function getScoreColor(score: number) {
  if (score >= 75) return STATUS_COLORS.success
  if (score >= 50) return STATUS_COLORS.warning
  return STATUS_COLORS.danger
}

// Objek master colors untuk default import
export const COLORS = {
  brand: BRAND_COLORS,
  neutral: NEUTRAL_COLORS,
  status: STATUS_COLORS,
  ai: AI_STATUS,
  getScoreColor,
}

export default COLORS
