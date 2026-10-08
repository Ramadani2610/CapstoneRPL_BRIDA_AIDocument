@extends('layouts.app')

@section('title', 'Dashboard Verifikator - SIGAP Inovasi')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
         1. BANNER HEADER
    ========================================================== --}}
    <div class="bg-[#7A1C1C] text-white p-6 md:p-8 rounded-2xl shadow-sm">

        <p class="text-white/80 text-sm font-normal mb-1">
            Selamat pagi, Nurul
        </p>

        <h1 class="text-2xl md:text-3xl font-bold mb-2">
            Antrian Review Dokumen
        </h1>

        <p class="text-white/90 text-sm font-light max-w-2xl mb-6 leading-relaxed">
            4 pengajuan menunggu review Anda. Rekomendasi AI membantu,
            keputusan tetap di tangan Anda.
        </p>

        {{-- Input & Filter Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">

            {{-- Search --}}
            <div class="relative md:col-span-6">

                <svg
                    class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                    />
                </svg>

                <input
                    id="searchInput"
                    type="text"
                    placeholder="Cari judul, ID, OPD, atau inovator"
                    class="w-full pl-10 pr-4 py-2.5 bg-white text-gray-900 rounded-xl text-sm outline-none placeholder:text-gray-400 shadow-sm border-0 focus:ring-2 focus:ring-white/40"
                >

            </div>

            {{-- Filter Indikator --}}
            <div class="relative md:col-span-3">

                <select
                    id="indikatorFilter"
                    class="w-full px-4 py-2.5 bg-white text-gray-700 rounded-xl text-sm outline-none appearance-none cursor-pointer pr-10 shadow-sm border-0 focus:ring-2 focus:ring-white/40"
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

                <svg
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m6 9 6 6 6-6"
                    />
                </svg>

            </div>

            {{-- Filter Status --}}
            <div class="relative md:col-span-3">

                <select
                    id="statusFilter"
                    class="w-full px-4 py-2.5 bg-white text-gray-700 rounded-xl text-sm outline-none appearance-none cursor-pointer pr-10 shadow-sm border-0 focus:ring-2 focus:ring-white/40"
                >
                    <option value="">Semua status</option>
                    <option value="Menunggu Review">Menunggu Review</option>
                    <option value="Perlu Dokumen Tambahan">Perlu Dokumen Tambahan</option>
                    <option value="Selesai">Selesai</option>
                </select>

                <svg
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m6 9 6 6 6-6"
                    />
                </svg>

            </div>

        </div>
    </div>


    {{-- =========================================================
         2. TAB & PERINGATAN
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

        {{-- Tabs --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 w-full sm:w-auto">

            {{-- Menunggu Review --}}
            <button
                type="button"
                data-tab="menunggu"
                class="dashboard-tab active-tab text-xs font-medium px-4 py-2 rounded-full flex items-center gap-2 transition-all cursor-pointer bg-[#7A1C1C] text-white shadow-sm"
            >
                <span>Menunggu Review</span>

                <span class="tab-count px-2 py-0.5 rounded-full text-[10px] font-semibold bg-white/20 text-white">
                    4
                </span>
            </button>

            {{-- Perlu Dokumen Tambahan --}}
            <button
                type="button"
                data-tab="tambahan"
                class="dashboard-tab text-xs font-medium px-4 py-2 rounded-full flex items-center gap-2 transition-all cursor-pointer bg-white border border-gray-200 text-gray-600 hover:bg-[#7A1C1C]/10 hover:text-[#7A1C1C]"
            >
                <span>Perlu Dokumen Tambahan</span>

                <span class="tab-count px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-600">
                    2
                </span>
            </button>

            {{-- Selesai --}}
            <button
                type="button"
                data-tab="selesai"
                class="dashboard-tab text-xs font-medium px-4 py-2 rounded-full flex items-center gap-2 transition-all cursor-pointer bg-white border border-gray-200 text-gray-600 hover:bg-[#7A1C1C]/10 hover:text-[#7A1C1C]"
            >
                <span>Selesai</span>

                <span class="tab-count px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-600">
                    3
                </span>
            </button>

        </div>


        {{-- Peringatan AI --}}
        <a
            href="{{ route('verifikator.antrian-review') }}"
            class="flex items-center gap-1.5 text-[#7A1C1C] hover:text-[#5a1414] text-xs font-semibold cursor-pointer shrink-0 transition-colors"
        >

            <svg
                class="w-4 h-4 text-[#7A1C1C]"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"
                />
            </svg>

            <span>5 dokumen gagal diproses AI</span>

            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m9 18 6-6-6-6"
                />
            </svg>

        </a>

    </div>


    {{-- =========================================================
         3. TABEL DATA PENGAJUAN
    ========================================================== --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead>

                    <tr class="border-b border-gray-100 bg-gray-50/50 text-gray-500 text-xs font-semibold">

                        <th class="py-4 px-6">
                            Pengajuan
                        </th>

                        <th class="py-4 px-4">
                            Diajukan
                        </th>

                        <th class="py-4 px-4 text-center">
                            Dokumen
                        </th>

                        <th class="py-4 px-4">
                            Rekomendasi AI
                        </th>

                        <th class="py-4 px-4">
                            Status Review
                        </th>

                        <th class="py-4 px-6 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody
                    id="reviewTableBody"
                    class="divide-y divide-gray-100 text-sm text-gray-700"
                >

                    @foreach ($reviewItems as $item)

                        <tr
                            class="review-row hover:bg-[#7A1C1C]/5 transition-colors"
                            data-id="{{ $item['id'] }}"
                            data-judul="{{ strtolower($item['judul']) }}"
                            data-kode="{{ strtolower($item['kodeInovasi']) }}"
                            data-opd="{{ strtolower($item['opd']) }}"
                            data-indikator="{{ $item['indikator'] }}"
                            data-status="{{ $item['statusReview'] }}"
                        >

                            {{-- Pengajuan --}}
                            <td class="py-4 px-6 max-w-md">

                                <p class="font-semibold text-gray-900 leading-snug">
                                    {{ $item['judul'] }}
                                </p>

                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $item['kodeInovasi'] }}
                                    ·
                                    {{ $item['opd'] }}
                                </p>

                            </td>


                            {{-- Diajukan --}}
                            <td class="py-4 px-4 text-xs text-gray-500 whitespace-nowrap">
                                {{ $item['tglDiajukan'] }}
                            </td>


                            {{-- Jumlah Dokumen --}}
                            <td class="py-4 px-4 text-xs text-gray-600 font-medium text-center">
                                {{ $item['jumlahDokumen'] }}
                            </td>


                            {{-- Rekomendasi AI --}}
                            <td class="py-4 px-4 whitespace-nowrap">

                                @if ($item['aiRecommendation']['type'] === 'lolos')

                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-200/60 rounded-full text-emerald-800 text-xs font-medium">

                                        <svg
                                            class="w-3.5 h-3.5 text-emerald-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m5 12 4 4L19 6"
                                            />
                                        </svg>

                                        <span>
                                            {{ $item['aiRecommendation']['label'] }}
                                        </span>

                                        <span class="bg-indigo-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md ml-1">
                                            {{ $item['aiRecommendation']['score'] }}%
                                        </span>

                                    </div>

                                @else

                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200/60 rounded-full text-amber-900 text-xs font-medium">

                                        <svg
                                            class="w-3.5 h-3.5 text-amber-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"
                                            />
                                        </svg>

                                        <span>
                                            {{ $item['aiRecommendation']['label'] }}
                                        </span>

                                        <span class="bg-[#7A1C1C] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md ml-1">
                                            {{ $item['aiRecommendation']['score'] }}%
                                        </span>

                                    </div>

                                @endif

                            </td>


                            {{-- Status Review --}}
                            <td class="py-4 px-4 whitespace-nowrap">

                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200/50 rounded-full text-amber-800 text-xs font-medium">

                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>

                                    {{ $item['statusReview'] }}

                                </span>

                            </td>


                            {{-- Aksi --}}
                            <td class="py-4 px-6 text-right whitespace-nowrap">

                                <button
                                    type="button"
                                    class="bg-[#7A1C1C] hover:bg-[#5a1414] active:bg-[#400b0d] text-white text-xs font-medium px-4 py-1.5 rounded-lg transition-colors cursor-pointer shadow-sm"
                                >
                                    Review
                                </button>

                            </td>

                        </tr>

                    @endforeach


                    {{-- Empty State --}}
                    <tr id="emptyState" class="hidden">

                        <td
                            colspan="6"
                            class="py-10 px-6 text-center text-sm text-gray-400"
                        >
                            Tidak ada pengajuan yang sesuai dengan pencarian atau filter.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             4. PAGINATION FOOTER
        ====================================================== --}}
        <div
            class="flex flex-col gap-3 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            {{-- Informasi jumlah data --}}
            <p
                id="paginationInfo"
                class="text-sm text-slate-500"
            >
                Menampilkan 0 - 0 dari 0 pengajuan
            </p>

            {{-- Tombol Pagination --}}
            <div
                id="paginationButtons"
                class="flex w-full items-center justify-center gap-1.5 sm:w-auto"
            >

                {{-- Diisi oleh JavaScript --}}

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}
<script>

    document.addEventListener('DOMContentLoaded', function () {

        const rows = Array.from(document.querySelectorAll('.review-row'));
        const searchInput = document.getElementById('searchInput');
        const indikatorFilter = document.getElementById('indikatorFilter');
        const statusFilter = document.getElementById('statusFilter');

        const paginationInfo =
            document.getElementById('paginationInfo');

        const paginationButtons =
            document.getElementById('paginationButtons');

        const emptyState = document.getElementById('emptyState');

        const tabs = document.querySelectorAll('.dashboard-tab');

        let currentPage = 1;
        const itemsPerPage = 10;
        let activeTab = 'menunggu';


        function getFilteredRows() {

            const search = searchInput.value.toLowerCase().trim();
            const indikator = indikatorFilter.value;
            const status = statusFilter.value;

            return rows.filter(function (row) {

                const judul = row.dataset.judul || '';
                const kode = row.dataset.kode || '';
                const opd = row.dataset.opd || '';
                const rowIndikator = row.dataset.indikator || '';
                const rowStatus = row.dataset.status || '';

                const matchesSearch =
                    judul.includes(search) ||
                    kode.includes(search) ||
                    opd.includes(search);

                const matchesIndikator =
                    !indikator ||
                    rowIndikator === indikator;

                const matchesStatus =
                    !status ||
                    rowStatus === status;

                let matchesTab = true;

                if (activeTab === 'menunggu') {
                    matchesTab = rowStatus === 'Menunggu Review';
                }

                if (activeTab === 'tambahan') {
                    matchesTab = rowStatus === 'Perlu Dokumen Tambahan';
                }

                if (activeTab === 'selesai') {
                    matchesTab = rowStatus === 'Selesai';
                }

                return (
                    matchesSearch &&
                    matchesIndikator &&
                    matchesStatus &&
                    matchesTab
                );

            });

        }


        function renderTable() {

            const filteredRows = getFilteredRows();

            const totalItems = filteredRows.length;
            const totalPages = Math.max(
                1,
                Math.ceil(totalItems / itemsPerPage)
            );

            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            rows.forEach(function (row) {
                row.classList.add('hidden');
            });

            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            filteredRows
                .slice(start, end)
                .forEach(function (row) {
                    row.classList.remove('hidden');
                });


            if (totalItems === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }


            const shownItems = Math.min(
                currentPage * itemsPerPage,
                totalItems
            );

            const firstShown =
                totalItems === 0
                    ? 0
                    : start + 1;

            paginationInfo.textContent =
                `Menampilkan ${firstShown}-${shownItems} dari ${totalItems} pengajuan`;

            renderPagination(totalPages);

        }

        function renderPagination(totalPages) {

            paginationButtons.innerHTML = '';

            /*
            * Tombol Sebelumnya
            */
            const previousButton =
                document.createElement('button');

            previousButton.type = 'button';
            previousButton.textContent = '←';

            previousButton.title = 'Halaman sebelumnya';
            previousButton.setAttribute(
                'aria-label',
                'Halaman sebelumnya'
            );

            previousButton.className =
                'flex h-9 w-9 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-600 transition hover:bg-[#7F1D1D] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-slate-600';

            previousButton.disabled =
                currentPage === 1;

            previousButton.addEventListener('click', function () {

                if (currentPage > 1) {

                    currentPage--;

                    renderTable();

                }

            });

            paginationButtons.appendChild(previousButton);


            /*
            * Nomor Halaman
            */
            for (
                let page = 1;
                page <= totalPages;
                page++
            ) {

                const pageButton =
                    document.createElement('button');

                pageButton.type = 'button';

                pageButton.textContent = page;

                pageButton.setAttribute(
                    'aria-label',
                    `Halaman ${page}`
                );

                pageButton.className =
                    currentPage === page

                        ? 'flex h-9 min-w-9 items-center justify-center rounded-lg bg-[#7F1D1D] px-3 text-sm font-medium text-white transition'

                        : 'flex h-9 min-w-9 items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-sm font-medium text-slate-600 transition hover:bg-[#7F1D1D] hover:text-white';

                pageButton.addEventListener(
                    'click',
                    function () {

                        currentPage = page;

                        renderTable();

                    }
                );

                paginationButtons.appendChild(pageButton);
            }


            /*
            * Tombol Berikutnya
            */
            const nextButton =
                document.createElement('button');

            nextButton.type = 'button';
            nextButton.textContent = '→';

            nextButton.title = 'Halaman berikutnya';
            nextButton.setAttribute(
                'aria-label',
                'Halaman berikutnya'
            );

            nextButton.className =
                'flex h-9 w-9 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-600 transition hover:bg-[#7F1D1D] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-slate-600';

            nextButton.disabled =
                currentPage === totalPages;

            nextButton.addEventListener('click', function () {

                if (currentPage < totalPages) {

                    currentPage++;

                    renderTable();

                }

            });

            paginationButtons.appendChild(nextButton);
        }

        function updateActiveTab() {

            tabs.forEach(function (tab) {

                const isActive =
                    tab.dataset.tab === activeTab;

                const count =
                    tab.querySelector('.tab-count');

                if (isActive) {

                    tab.classList.remove(
                        'bg-white',
                        'border',
                        'border-gray-200',
                        'text-gray-600'
                    );

                    tab.classList.add(
                        'bg-[#7A1C1C]',
                        'text-white',
                        'shadow-sm'
                    );

                    count.classList.remove(
                        'bg-gray-100',
                        'text-gray-600'
                    );

                    count.classList.add(
                        'bg-white/20',
                        'text-white'
                    );

                } else {

                    tab.classList.remove(
                        'bg-[#7A1C1C]',
                        'text-white',
                        'shadow-sm'
                    );

                    tab.classList.add(
                        'bg-white',
                        'border',
                        'border-gray-200',
                        'text-gray-600'
                    );

                    count.classList.remove(
                        'bg-white/20',
                        'text-white'
                    );

                    count.classList.add(
                        'bg-gray-100',
                        'text-gray-600'
                    );

                }

            });

        }


        searchInput.addEventListener('input', function () {
            currentPage = 1;
            renderTable();
        });


        indikatorFilter.addEventListener('change', function () {
            currentPage = 1;
            renderTable();
        });


        statusFilter.addEventListener('change', function () {
            currentPage = 1;
            renderTable();
        });


        tabs.forEach(function (tab) {

            tab.addEventListener('click', function () {

                activeTab = tab.dataset.tab;

                currentPage = 1;

                updateActiveTab();
                renderTable();

            });

        });


        updateActiveTab();
        renderTable();

    });

</script>

@endsection