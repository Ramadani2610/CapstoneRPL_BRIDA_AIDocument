/*
  File ini sengaja ada dan sengaja kosong.

  Vite mencari postcss.config sampai ke folder induk. Kalau file ini tidak ada,
  konfigurasi PostCSS milik project lain di folder home komputer bisa ikut
  terpakai dan merusak build.

  Project ini memakai Tailwind v4 melalui plugin @tailwindcss/vite
  (lihat vite.config.js), jadi PostCSS tidak perlu plugin apa pun di sini.
*/
export default { plugins: {} }
