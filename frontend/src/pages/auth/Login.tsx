import React, { useState } from 'react';

// Pastikan struktur folder Anda sesuai dengan path ini
import logoSigap from '../../assets/images/logo-sigap.png';
import bgKubah from '../../assets/images/99kubah.jpg';

type Role = 'inovator' | 'verifikator' | 'admin';

export const Login: React.FC = () => {
  const [role, setRole] = useState<Role>('verifikator');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);

  const roleDescriptions = {
    inovator: 'Unggah dan ajukan dokumen bukti inovasi daerah Anda.',
    verifikator: 'Tinjau dokumen bukti dengan bantuan rekomendasi AI dan tetapkan keputusan akhir.',
    admin: 'Kelola pengguna, indikator, dan pantau seluruh proses verifikasi.'
  };

  const handleLogin = (e: React.FormEvent) => {
    e.preventDefault();
    console.log({ email, password, role });
  };

  return (
    <div className="flex min-h-screen bg-gray-50 font-sans">
      
      {/* SISI KIRI - Banner Informasi */}
      <div 
        className="hidden lg:flex lg:w-1/2 flex-col justify-between p-12 relative bg-cover bg-center"
        style={{ 
          backgroundImage: `linear-gradient(rgba(122, 22, 26, 0.90), rgba(122, 22, 26, 0.95)), url(${bgKubah})` 
        }}
      >
        {/* Logo Kiri Atas */}
        <div className="flex items-center gap-3 z-10">
          <div className="w-10 h-10 bg-white rounded-full flex items-center justify-center p-1.5 shadow-sm">
            <img src={logoSigap} alt="Logo BRIDA" className="w-full h-full object-contain" />
          </div>
          <div className="text-white">
            <h2 className="font-bold text-sm tracking-widest uppercase">BRIDA</h2>
            <p className="text-xs font-light opacity-80">Kota Makassar</p>
          </div>
        </div>

        {/* Konten Tengah */}
        <div className="z-10 max-w-lg mb-20">
          <p className="text-white/70 text-sm font-medium tracking-wider mb-2">SIGAP Inovasi</p>
          <h1 className="text-white text-4xl font-bold leading-tight mb-5">
            Verifikasi dokumen inovasi daerah yang cepat, terukur, dan transparan.
          </h1>
          <p className="text-white/80 text-sm leading-relaxed font-light">
            Satu ruang kerja bagi perangkat daerah dan verifikator BRIDA untuk menilai kelengkapan bukti inovasi, dibantu analisis AI yang tetap diputuskan oleh manusia.
          </p>
        </div>

        {/* Footer Banner */}
        <div className="z-10 flex justify-between items-center text-white/60 text-xs border-t border-white/20 pt-5">
          <p>Badan Riset dan Inovasi Daerah Kota Makassar</p>
          <p>© 2026</p>
        </div>
      </div>

      {/* SISI KANAN - Form Login */}
      <div className="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
        <div className="w-full max-w-md bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
          
          <div className="mb-8">
            <h2 className="text-2xl font-bold text-gray-900">Masuk ke SIGAP Inovasi</h2>
            <p className="text-sm text-gray-500 mt-1">Gunakan akun yang terdaftar di BRIDA Kota Makassar.</p>
          </div>

          <form onSubmit={handleLogin} className="space-y-6">
            
            {/* Pilihan Role */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-3">
                Masuk sebagai <span className="text-gray-400 font-normal">(mode demo)</span>
              </label>
              
              <div className="grid grid-cols-3 gap-3">
                {(['inovator', 'verifikator', 'admin'] as Role[]).map((r) => (
                  <button
                    key={r}
                    type="button"
                    onClick={() => setRole(r)}
                    className={`flex flex-col items-center justify-center py-3 px-2 rounded-xl border transition-all ${
                      role === r 
                      ? 'border-maroon bg-maroon/5 text-maroon font-semibold' 
                      : 'border-gray-200 bg-white hover:border-gray-300 text-gray-500'
                    }`}
                  >
                    <span className="text-xs capitalize">{r}</span>
                  </button>
                ))}
              </div>
              <p className="text-xs text-gray-500 mt-3 h-8">
                {roleDescriptions[role]}
              </p>
            </div>

            {/* Input Username / Email */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1.5">
                Email atau Username
              </label>
              <input
                type="text"
                required
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-maroon/20 focus:border-maroon outline-none transition-all text-sm"
              />
            </div>

            {/* Input Password */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1.5">
                Kata Sandi
              </label>
              <div className="relative">
                <input
                  type={showPassword ? 'text' : 'password'}
                  required
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  className="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-maroon/20 focus:border-maroon outline-none transition-all text-sm pr-10"
                />
                <button
                  type="button"
                  onClick={() => setShowPassword(!showPassword)}
                  className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs font-medium"
                >
                  {showPassword ? 'Sembunyikan' : 'Lihat'}
                </button>
              </div>
            </div>

            {/* Checkbox & Lupa Password */}
            <div className="flex items-center justify-between">
              <label className="flex items-center gap-2 cursor-pointer">
                <input
                  type="checkbox"
                  className="w-4 h-4 text-maroon border-gray-300 rounded focus:ring-maroon"
                />
                <span className="text-sm text-gray-600">Ingat saya</span>
              </label>
              <a href="#" className="text-sm font-semibold text-maroon hover:underline">
                Lupa Password?
              </a>
            </div>

            {/* Tombol Submit */}
            <button
              type="submit"
              className="w-full bg-maroon hover:bg-maroon-hover text-white font-semibold py-3 rounded-lg transition-colors shadow-sm"
            >
              Masuk
            </button>
          </form>

          <p className="text-center text-xs text-gray-500 mt-8">
            Belum memiliki akun? Hubungi admin BRIDA melalui helpdesk{' '}
            <span className="font-semibold text-gray-700">(0411) 873 110</span>.
          </p>

        </div>
      </div>
    </div>
  );
};

export default Login;