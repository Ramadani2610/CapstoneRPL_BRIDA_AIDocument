import axios from 'axios'

/*
  Satu instance axios untuk seluruh aplikasi.
  Semua request lewat /api dan diteruskan Vite ke Laravel (lihat vite.config.js),
  jadi tidak ada URL backend yang ditulis ulang di halaman.
*/
export const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || '/api',
  headers: { Accept: 'application/json' },
  withCredentials: true,
})

api.interceptors.response.use(
  (response) => response,
  (error) => {
    // Pesan error diseragamkan supaya halaman tidak perlu tahu bentuk asli axios.
    const message =
      error.response?.data?.message || error.message || 'Terjadi kesalahan pada server'
    return Promise.reject({ status: error.response?.status ?? 0, message, raw: error })
  },
)
