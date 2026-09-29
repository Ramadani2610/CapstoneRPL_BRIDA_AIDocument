import React, { useState } from 'react';
import { 
  Search, 
  ChevronDown, 
  CheckCircle, 
  AlertTriangle, 
  ChevronRight, 
  ChevronLeft 
} from 'lucide-react';

// Tipe Data untuk item antrian review
interface ReviewItem {
  id: string;
  judul: string;
  kodeInovasi: string;
  opd: string;
  tglDiajukan: string;
  jumlahDokumen: number;
  aiRecommendation: {
    type: 'lolos' | 'keyakinan_rendah';
    label: string;
    score: number;
  };
  statusReview: string;
}

// Mock Data
const mockData: ReviewItem[] = [
  {
    id: '1',
    judul: 'Dashboard Command Center Penanganan Banjir',
    kodeInovasi: 'INV-2026-009',
    opd: 'Dinas Komunikasi dan Informatika',
    tglDiajukan: '20 Sep 2026',
    jumlahDokumen: 5,
    aiRecommendation: {
      type: 'lolos',
      label: 'Saran AI: Lolos',
      score: 92,
    },
    statusReview: 'Menunggu Review',
  },
  {
    id: '2',
    judul: 'Si-Lapor Sampah Lorong',
    kodeInovasi: 'INV-2026-012',
    opd: 'Dinas Komunikasi dan Informatika',
    tglDiajukan: '22 Sep 2026',
    jumlahDokumen: 3,
    aiRecommendation: {
      type: 'lolos',
      label: 'Saran AI: Lolos',
      score: 88,
    },
    statusReview: 'Menunggu Review',
  },
  {
    id: '3',
    judul: 'Posyandu Digital Terintegrasi',
    kodeInovasi: 'INV-2026-015',
    opd: 'Dinas Kesehatan',
    tglDiajukan: '25 Sep 2026',
    jumlahDokumen: 3,
    aiRecommendation: {
      type: 'keyakinan_rendah',
      label: 'Saran AI: Keyakinan Rendah',
      score: 54,
    },
    statusReview: 'Menunggu Review',
  },
  {
    id: '4',
    judul: 'Bank Sampah Lorong Garden',
    kodeInovasi: 'INV-2026-008',
    opd: 'Dinas Lingkungan Hidup',
    tglDiajukan: '23 Sep 2026',
    jumlahDokumen: 2,
    aiRecommendation: {
      type: 'keyakinan_rendah',
      label: 'Saran AI: Keyakinan Rendah',
      score: 62,
    },
    statusReview: 'Menunggu Review',
  },
];

const AntrianReviewPage: React.FC = () => {
  const [activeTab, setActiveTab] = useState<'menunggu' | 'tambahan' | 'selesai'>('menunggu');
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedIndikator, setSelectedIndikator] = useState('');
  const [selectedStatus, setSelectedStatus] = useState('');

  return (
    <div className="w-full space-y-6 font-['Poppins',sans-serif]">
      {/* 1. BANNER HEADER */}
      <div className="bg-[#7A1C1C] text-white p-6 md:p-8 rounded-2xl shadow-sm">
        <p className="text-white/80 text-sm font-normal mb-1">Selamat pagi, Nurul</p>
        <h1 className="text-2xl md:text-3xl font-bold mb-2">Antrian Review Dokumen</h1>
        <p className="text-white/90 text-sm font-light max-w-2xl mb-6 leading-relaxed">
          4 pengajuan menunggu review Anda. Rekomendasi AI membantu, keputusan tetap di tangan Anda.
        </p>

        {/* Input & Filter Grid */}
        <div className="grid grid-cols-1 md:grid-cols-12 gap-3">
          {/* Search Bar */}
          <div className="relative md:col-span-6">
            <Search className="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
            <input
              type="text"
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              placeholder="Cari judul, ID, OPD, atau inovator"
              className="w-full pl-10 pr-4 py-2.5 bg-white text-gray-900 rounded-xl text-sm outline-none placeholder:text-gray-400 shadow-sm border-0 focus:ring-2 focus:ring-white/40"
            />
          </div>

          {/* Select 1: Semua Indikator */}
          <div className="relative md:col-span-3">
            <select 
              value={selectedIndikator}
              onChange={(e) => setSelectedIndikator(e.target.value)}
              className="w-full px-4 py-2.5 bg-white text-gray-700 rounded-xl text-sm outline-none appearance-none cursor-pointer pr-10 shadow-sm border-0 focus:ring-2 focus:ring-white/40"
            >
              <option value="">Semua indikator</option>
              <option value="IND-01">IND-01 · Regulasi Inovasi Daerah</option>
              <option value="IND-02">IND-02 · Ketersediaan SDM terhadap Inovasi Daerah</option>
              <option value="IND-03">IND-03 · Dukungan Anggaran</option>
              <option value="IND-04">IND-04 · Penggunaan Teknologi Informasi</option>
              <option value="IND-05">IND-05 · Bimtek Inovasi</option>
              <option value="IND-06">IND-06 · Kecepatan Penciptaan Inovasi</option>
              <option value="IND-07">IND-07 · Kemanfaatan Inovasi</option>
            </select>
            <ChevronDown className="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
          </div>

          {/* Select 2: Semua Status */}
          <div className="relative md:col-span-3">
            <select 
              value={selectedStatus}
              onChange={(e) => setSelectedStatus(e.target.value)}
              className="w-full px-4 py-2.5 bg-white text-gray-700 rounded-xl text-sm outline-none appearance-none cursor-pointer pr-10 shadow-sm border-0 focus:ring-2 focus:ring-white/40"
            >
              <option value="">Semua status</option>
              <option value="Menunggu Review">Menunggu Review</option>
              <option value="Perlu Dokumen Tambahan">Perlu Dokumen Tambahan</option>
              <option value="Selesai">Selesai</option>
            </select>
            <ChevronDown className="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
          </div>
        </div>
      </div>

      {/* 2. SECTION TABS & PERINGATAN */}
      <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        {/* Tabs Navigasi */}
        <div className="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 w-full sm:w-auto">
          <button
            onClick={() => setActiveTab('menunggu')}
            className={`text-xs font-medium px-4 py-2 rounded-full flex items-center gap-2 transition-all cursor-pointer ${
              activeTab === 'menunggu'
                ? 'bg-[#7A1C1C] text-white shadow-sm'
                : 'bg-white border border-gray-200 text-gray-600 hover:bg-[#7A1C1C]/10 hover:text-[#7A1C1C]'
            }`}
          >
            <span>Menunggu Review</span>
            <span
              className={`px-2 py-0.5 rounded-full text-[10px] font-semibold ${
                activeTab === 'menunggu' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'
              }`}
            >
              4
            </span>
          </button>

          <button
            onClick={() => setActiveTab('tambahan')}
            className={`text-xs font-medium px-4 py-2 rounded-full flex items-center gap-2 transition-all cursor-pointer ${
              activeTab === 'tambahan'
                ? 'bg-[#7A1C1C] text-white shadow-sm'
                : 'bg-white border border-gray-200 text-gray-600 hover:bg-[#7A1C1C]/10 hover:text-[#7A1C1C]'
            }`}
          >
            <span>Perlu Dokumen Tambahan</span>
            <span
              className={`px-2 py-0.5 rounded-full text-[10px] font-semibold ${
                activeTab === 'tambahan' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'
              }`}
            >
              2
            </span>
          </button>

          <button
            onClick={() => setActiveTab('selesai')}
            className={`text-xs font-medium px-4 py-2 rounded-full flex items-center gap-2 transition-all cursor-pointer ${
              activeTab === 'selesai'
                ? 'bg-[#7A1C1C] text-white shadow-sm'
                : 'bg-white border border-gray-200 text-gray-600 hover:bg-[#7A1C1C]/10 hover:text-[#7A1C1C]'
            }`}
          >
            <span>Selesai</span>
            <span
              className={`px-2 py-0.5 rounded-full text-[10px] font-semibold ${
                activeTab === 'selesai' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'
              }`}
            >
              3
            </span>
          </button>
        </div>

        {/* Teks Peringatan AI */}
        <a
          href="/verifikator/gagal-diproses"
          className="flex items-center gap-1.5 text-[#7A1C1C] hover:text-[#5a1414] text-xs font-semibold cursor-pointer shrink-0 transition-colors"
        >
          <AlertTriangle className="w-4 h-4 text-[#7A1C1C]" />
          <span>5 dokumen gagal diproses AI</span>
          <ChevronRight className="w-4 h-4" />
        </a>
      </div>

      {/* 3. TABEL DATA PENGAJUAN */}
      <div className="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="border-b border-gray-100 bg-gray-50/50 text-gray-500 text-xs font-semibold">
                <th className="py-4 px-6">Pengajuan</th>
                <th className="py-4 px-4">Diajukan</th>
                <th className="py-4 px-4 text-center">Dokumen</th>
                <th className="py-4 px-4">Rekomendasi AI</th>
                <th className="py-4 px-4">Status Review</th>
                <th className="py-4 px-6 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100 text-sm text-gray-700">
              {mockData.map((item) => (
                <tr key={item.id} className="hover:bg-[#7A1C1C]/5 transition-colors">
                  {/* Kolom Pengajuan */}
                  <td className="py-4 px-6 max-w-md">
                    <p className="font-semibold text-gray-900 leading-snug">{item.judul}</p>
                    <p className="text-xs text-gray-400 mt-0.5">
                      {item.kodeInovasi} · {item.opd}
                    </p>
                  </td>

                  {/* Kolom Diajukan */}
                  <td className="py-4 px-4 text-xs text-gray-500 whitespace-nowrap">
                    {item.tglDiajukan}
                  </td>

                  {/* Kolom Jumlah Dokumen */}
                  <td className="py-4 px-4 text-xs text-gray-600 font-medium text-center">
                    {item.jumlahDokumen}
                  </td>

                  {/* Kolom Rekomendasi AI */}
                  <td className="py-4 px-4 whitespace-nowrap">
                    {item.aiRecommendation.type === 'lolos' ? (
                      <div className="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-200/60 rounded-full text-emerald-800 text-xs font-medium">
                        <CheckCircle className="w-3.5 h-3.5 text-emerald-600" />
                        <span>{item.aiRecommendation.label}</span>
                        <span className="bg-indigo-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md ml-1">
                          {item.aiRecommendation.score}%
                        </span>
                      </div>
                    ) : (
                      <div className="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200/60 rounded-full text-amber-900 text-xs font-medium">
                        <AlertTriangle className="w-3.5 h-3.5 text-amber-600" />
                        <span>{item.aiRecommendation.label}</span>
                        <span className="bg-[#7A1C1C] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md ml-1">
                          {item.aiRecommendation.score}%
                        </span>
                      </div>
                    )}
                  </td>

                  {/* Kolom Status Review */}
                  <td className="py-4 px-4 whitespace-nowrap">
                    <span className="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200/50 rounded-full text-amber-800 text-xs font-medium">
                      <span className="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                      {item.statusReview}
                    </span>
                  </td>

                  {/* Kolom Aksi */}
                  <td className="py-4 px-6 text-right whitespace-nowrap">
                    <button className="bg-[#7A1C1C] hover:bg-[#5a1414] active:bg-[#400b0d] text-white text-xs font-medium px-4 py-1.5 rounded-lg transition-colors cursor-pointer shadow-sm">
                      Review
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {/* 4. PAGINATION FOOTER */}
        <div className="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 py-4 border-t border-gray-100 text-xs text-gray-500">
          <p>Menampilkan 4 dari 9 pengajuan</p>
          <div className="flex items-center gap-1">
            <button 
              disabled 
              className="p-1.5 rounded-md text-gray-300 hover:text-gray-500 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <ChevronLeft className="w-4 h-4" />
            </button>
            <button className="w-7 h-7 flex items-center justify-center bg-[#7A1C1C] text-white font-medium rounded-md shadow-sm text-xs">
              1
            </button>
            <button className="p-1.5 rounded-md text-gray-500 hover:bg-[#7A1C1C]/10 hover:text-[#7A1C1C] transition-colors rounded-md">
              <ChevronRight className="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default AntrianReviewPage;