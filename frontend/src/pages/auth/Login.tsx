import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { Eye, EyeOff, Lightbulb, FileCheck, User } from 'lucide-react';
import { useRole } from '../../lib/role';
import { defaultPathForRole } from '../../config/navigation';

import bgKubah from '../../assets/images/99kubah.jpg';
import logoSigap from '../../assets/images/logo-sigap.png';

type Role = 'inovator' | 'verifikator' | 'admin';

const Login: React.FC = () => {
  const [role, setRoleState] = useState<Role>('verifikator');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);

  const { setRole } = useRole();
  const navigate = useNavigate();

  const roleDescriptions = {
    inovator: 'Unggah dan ajukan dokumen bukti inovasi daerah Anda.',
    verifikator: 'Tinjau dokumen bukti dengan bantuan rekomendasi AI dan tetapkan keputusan akhir.',
    admin: 'Kelola pengguna, indikator, dan pantau seluruh proses verifikasi.'
  };

  const handleLogin = (e: React.FormEvent) => {
    e.preventDefault();
    setRole(role);
    navigate(defaultPathForRole(role));
  };

  return (
    <div className="flex min-h-screen bg-gray-50 font-['Poppins',sans-serif]">
      {/* SISI KIRI - Hero Section (Layar Sedang & Besar) */}
      <div 
        className="hidden lg:flex lg:w-1/2 flex-col justify-between p-12 relative bg-cover bg-center"
        style={{ 
          backgroundImage: `linear-gradient(rgba(122, 22, 26, 0.72), rgba(97, 17, 20, 0.80)), url(${bgKubah})` 
        }}
      >
        {/* Logo BRIDA - Digeser sedikit ke kiri (-ml-2) agar pas sejajar dengan awal kalimat judul */}
        <div className="z-10 -ml-2">
          <img 
            src={logoSigap} 
            alt="Logo BRIDA Kota Makassar" 
            className="h-16 xl:h-20 w-auto object-contain drop-shadow-md" 
          />
        </div>

        <div className="z-10 max-w-lg mb-16">
          <h1 className="text-white text-3xl xl:text-4xl font-bold leading-tight mb-5">
            Verifikasi dokumen inovasi daerah yang cepat, terukur, dan transparan.
          </h1>
          <p className="text-white/90 text-sm leading-relaxed font-light">
            Satu ruang kerja bagi perangkat daerah dan verifikator BRIDA untuk menilai kelengkapan bukti inovasi, dibantu analisis AI yang tetap diputuskan oleh manusia.
          </p>
        </div>

        <div className="z-10 flex justify-between items-center text-white/70 text-xs border-t border-white/20 pt-5">
          <p>Badan Riset dan Inovasi Daerah Kota Makassar</p>
          <p>© 2026</p>
        </div>
      </div>

      {/* SISI KANAN - Form Login Section */}
      <div className="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 md:p-12">
        <div className="w-full max-w-md bg-white sm:bg-transparent p-6 sm:p-0 rounded-2xl sm:rounded-none shadow-sm sm:shadow-none border sm:border-none border-gray-100">
          
          {/* Logo Khusus Tampilan Ponsel / Tablet */}
          <div className="lg:hidden flex justify-center mb-6">
            <img 
              src={logoSigap} 
              alt="Logo BRIDA Kota Makassar" 
              className="h-16 w-auto object-contain" 
            />
          </div>

          {/* Judul & Subtitle Dibuat Rata Tengah (text-center) */}
          <div className="mb-8 text-center">
            <h2 className="text-2xl font-bold text-gray-900">Masuk ke SIGAP Inovasi</h2>
          </div>

          <form onSubmit={handleLogin} className="space-y-6">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-3">
                Silakan pilih peran Anda. Gunakan akun yang terdaftar di BRIDA Kota Makassar.<span className="text-gray-400 font-normal"></span>
              </label>
              
              <div className="grid grid-cols-3 gap-2 sm:gap-3">
                <button
                  type="button"
                  onClick={() => setRoleState('inovator')}
                  className={`flex flex-col items-center justify-center py-3 px-2 rounded-xl border transition-all cursor-pointer ${
                    role === 'inovator' 
                    ? 'border-[#7a161a] bg-[#7a161a]/10 text-[#7a161a] font-semibold shadow-sm' 
                    : 'border-gray-200 bg-white hover:border-[#7a161a]/60 hover:text-[#7a161a] text-gray-500'
                  }`}
                >
                  <Lightbulb size={20} className="mb-1.5" />
                  <span className="text-xs capitalize">Inovator</span>
                </button>

                <button
                  type="button"
                  onClick={() => setRoleState('verifikator')}
                  className={`flex flex-col items-center justify-center py-3 px-2 rounded-xl border transition-all cursor-pointer ${
                    role === 'verifikator' 
                    ? 'border-[#7a161a] bg-[#7a161a]/10 text-[#7a161a] font-semibold shadow-sm' 
                    : 'border-gray-200 bg-white hover:border-[#7a161a]/60 hover:text-[#7a161a] text-gray-500'
                  }`}
                >
                  <FileCheck size={20} className="mb-1.5" />
                  <span className="text-xs capitalize">Verifikator</span>
                </button>

                <button
                  type="button"
                  onClick={() => setRoleState('admin')}
                  className={`flex flex-col items-center justify-center py-3 px-2 rounded-xl border transition-all cursor-pointer ${
                    role === 'admin' 
                    ? 'border-[#7a161a] bg-[#7a161a]/10 text-[#7a161a] font-semibold shadow-sm' 
                    : 'border-gray-200 bg-white hover:border-[#7a161a]/60 hover:text-[#7a161a] text-gray-500'
                  }`}
                >
                  {/* Ikon Admin Diganti Menjadi Ikon Pengguna (User) */}
                  <User size={20} className="mb-1.5" />
                  <span className="text-xs capitalize">Admin</span>
                </button>
              </div>
              
              <p className="text-xs text-gray-500 mt-3 h-8">
                {roleDescriptions[role]}
              </p>
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1.5">
                Email atau Username
              </label>
              <input
                type="text"
                required
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="Masukkan email atau username"
                className="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a161a]/20 focus:border-[#7a161a] hover:border-[#7a161a]/60 outline-none transition-all text-sm"
              />
            </div>

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
                  placeholder="Masukkan kata sandi"
                  className="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7a161a]/20 focus:border-[#7a161a] hover:border-[#7a161a]/60 outline-none transition-all text-sm pr-10"
                />
                <button
                  type="button"
                  onClick={() => setShowPassword(!showPassword)}
                  className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7a161a] focus:outline-none transition-colors"
                >
                  {showPassword ? <EyeOff size={18} /> : <Eye size={18} />}
                </button>
              </div>
            </div>

            <div className="flex items-center justify-between">
              <label className="flex items-center gap-2 cursor-pointer group">
                <input
                  type="checkbox"
                  className="w-4 h-4 text-[#7a161a] border-gray-300 rounded accent-[#7a161a] focus:ring-[#7a161a] cursor-pointer"
                />
                <span className="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Ingat saya</span>
              </label>
              <a href="#" className="text-sm font-semibold text-[#7a161a] hover:text-[#5a1013] hover:underline transition-colors">
                Lupa Password?
              </a>
            </div>

            <button
              type="submit"
              className="w-full bg-[#7a161a] hover:bg-[#5a1013] active:bg-[#400b0d] text-white font-semibold py-3 rounded-lg transition-all shadow-md hover:shadow-lg cursor-pointer text-center"
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