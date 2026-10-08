@extends('layouts.app')

@section('title', 'Riwayat Audit & Log Keputusan')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-500">
        <span>Dashboard</span>
        <span>/</span>
        <span class="font-medium text-slate-800">
            Riwayat Audit
        </span>
    </div>

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Riwayat Audit &amp; Log Keputusan
            </h1>

            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">
                Jejak lengkap setiap tindakan verifikator, inovator, admin,
                dan proses otomatis sistem.
            </p>
        </div>

        {{-- Export CSV --}}
        <button
            type="button"
            onclick="exportCSV()"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-[#7F1D1D] hover:text-white"
        >
            <svg
                width="17"
                height="17"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <polyline points="7 10 12 15 17 10" />
                <line x1="12" y1="15" x2="12" y2="3" />
            </svg>

            Ekspor CSV
        </button>
    </div>

    {{-- Filter & Search --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

            {{-- Filter --}}
            <div class="flex flex-wrap gap-2">
                @foreach (['Semua', 'Verifikator', 'AI', 'Sistem', 'Inovator', 'Admin'] as $filter)
                    <button
                        type="button"
                        data-filter="{{ $filter }}"
                        onclick="setFilter('{{ $filter }}')"
                        class="filter-button rounded-full px-4 py-2 text-sm font-medium transition
                            {{ $filter === 'Semua'
                                ? 'bg-[#7F1D1D] text-white'
                                : 'bg-slate-100 text-slate-600 hover:bg-[#7F1D1D] hover:text-white' }}"
                    >
                        {{ $filter }}
                    </button>
                @endforeach
            </div>

            {{-- Search --}}
            <div class="relative w-full xl:max-w-sm">
                <svg
                    class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>

                <input
                    id="searchInput"
                    type="text"
                    placeholder="Cari aksi, ID, atau aktor"
                    class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
            </div>
        </div>
    </div>

    {{-- Result Info --}}
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">
            Menampilkan
            <span
                id="showingCount"
                class="font-semibold text-slate-800"
            >0</span>
            dari
            <span
                id="totalCount"
                class="font-semibold text-slate-800"
            >0</span>
            aktivitas
        </p>

        <button
            id="resetButton"
            type="button"
            onclick="resetFilter()"
            class="hidden text-sm font-medium text-[#7F1D1D] hover:text-[#5B1515]"
        >
            Reset filter
        </button>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[1000px] w-full">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Waktu
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Aktor
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Aksi
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Objek
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Keterangan
                        </th>
                    </tr>
                </thead>

                <tbody
                    id="auditTableBody"
                    class="divide-y divide-slate-100"
                ></tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div
            id="paginationContainer"
            class="hidden flex flex-col gap-3 border-t border-slate-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5"
        >
            {{-- Informasi halaman --}}
            <p class="text-sm text-slate-500">
                Menampilkan
                <span
                    id="paginationStart"
                    class="font-semibold text-slate-800"
                >0</span>
                -
                <span
                    id="paginationEnd"
                    class="font-semibold text-slate-800"
                >0</span>
                dari
                <span
                    id="paginationTotal"
                    class="font-semibold text-slate-800"
                >0</span>
                aktivitas
            </p>

            {{-- Tombol Pagination --}}
            <div
                id="paginationButtons"
                class="flex items-center justify-center gap-1.5"
            ></div>
        </div>
    </div>

</div>

<script>
    /*
    |--------------------------------------------------------------------------
    | Data Audit
    |--------------------------------------------------------------------------
    */

    const auditData = @json($auditData);

    const itemsPerPage = 10;

    let activeFilter = 'Semua';
    let search = '';
    let currentPage = 1;

    /*
    |--------------------------------------------------------------------------
    | Actor Style
    |--------------------------------------------------------------------------
    */

    function getActorStyle(type) {
        switch (type) {
            case 'AI':
                return 'bg-violet-50 text-violet-700 ring-violet-200';

            case 'Sistem':
                return 'bg-slate-100 text-slate-700 ring-slate-200';

            case 'Inovator':
                return 'bg-emerald-50 text-emerald-700 ring-emerald-200';

            case 'Admin':
                return 'bg-amber-50 text-amber-700 ring-amber-200';

            case 'Verifikator':
                return 'bg-blue-50 text-blue-700 ring-blue-200';

            default:
                return 'bg-slate-100 text-slate-700 ring-slate-200';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Filter + Search
    |--------------------------------------------------------------------------
    */

    function getFilteredData() {
        const keyword = search.toLowerCase().trim();

        return auditData.filter(item => {

            const matchesFilter =
                activeFilter === 'Semua' ||
                item.actorType === activeFilter;

            const matchesSearch =
                !keyword ||
                item.actor.toLowerCase().includes(keyword) ||
                item.action.toLowerCase().includes(keyword) ||
                item.object.toLowerCase().includes(keyword) ||
                item.description.toLowerCase().includes(keyword);

            return matchesFilter && matchesSearch;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Render Table
    |--------------------------------------------------------------------------
    */

    function renderTable() {
        const filteredData = getFilteredData();

        const totalPages = Math.max(
            1,
            Math.ceil(filteredData.length / itemsPerPage)
        );

        // Kalau filter/search membuat halaman sekarang tidak valid
        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        const startIndex = (currentPage - 1) * itemsPerPage;

        const paginatedData = filteredData.slice(
            startIndex,
            startIndex + itemsPerPage
        );

        const tableBody = document.getElementById('auditTableBody');

        /*
        |--------------------------------------------------------------------------
        | Result Info
        |--------------------------------------------------------------------------
        */

        document.getElementById('showingCount').textContent =
            paginatedData.length;

        document.getElementById('totalCount').textContent =
            filteredData.length;

        /*
        |--------------------------------------------------------------------------
        | Reset Button
        |--------------------------------------------------------------------------
        */

        const resetButton = document.getElementById('resetButton');

        if (activeFilter !== 'Semua' || search) {
            resetButton.classList.remove('hidden');
        } else {
            resetButton.classList.add('hidden');
        }

        /*
        |--------------------------------------------------------------------------
        | Empty State
        |--------------------------------------------------------------------------
        */

        if (filteredData.length === 0) {

            tableBody.innerHTML = `
                <tr>
                    <td
                        colspan="5"
                        class="px-5 py-12 text-center"
                    >
                        <div class="text-sm font-medium text-slate-700">
                            Tidak ada aktivitas ditemukan
                        </div>

                        <p class="mt-1 text-sm text-slate-400">
                            Coba ubah kata kunci pencarian atau filter aktor.
                        </p>
                    </td>
                </tr>
            `;

            renderPagination(1);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Table Rows
        |--------------------------------------------------------------------------
        */

        tableBody.innerHTML = paginatedData.map(item => {

            const actorStyle = getActorStyle(item.actorType);

            return `
                <tr class="transition hover:bg-[#FDF2F2]">

                    <!-- Waktu -->
                    <td class="whitespace-nowrap px-5 py-4 align-top">
                        <div class="text-sm font-medium text-slate-800">
                            ${escapeHtml(item.time)}
                        </div>

                        <div class="mt-1 text-xs text-slate-400">
                            ${escapeHtml(item.date)}
                        </div>
                    </td>

                    <!-- Aktor -->
                    <td class="px-5 py-4 align-top">
                        <div class="flex flex-col items-start gap-2">

                            <span class="text-sm font-medium text-slate-800">
                                ${escapeHtml(item.actor)}
                            </span>

                            <span
                                class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset ${actorStyle}"
                            >
                                ${escapeHtml(item.actorType)}
                            </span>

                        </div>
                    </td>

                    <!-- Aksi -->
                    <td class="px-5 py-4 align-top">
                        <span class="text-sm font-medium text-slate-700">
                            ${escapeHtml(item.action)}
                        </span>
                    </td>

                    <!-- Objek -->
                    <td class="px-5 py-4 align-top">
                        <span class="rounded-md bg-slate-100 px-2 py-1 font-mono text-xs font-medium text-slate-700">
                            ${escapeHtml(item.object)}
                        </span>
                    </td>

                    <!-- Keterangan -->
                    <td class="max-w-md px-5 py-4 align-top">
                        <p class="text-sm leading-6 text-slate-500">
                            ${escapeHtml(item.description)}
                        </p>
                    </td>

                </tr>
            `;

        }).join('');

        renderPagination(totalPages);
    }

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    function renderPagination(totalPages) {

        const container =
            document.getElementById('paginationContainer');

        const buttons =
            document.getElementById('paginationButtons');

        const paginationStart =
            document.getElementById('paginationStart');

        const paginationEnd =
            document.getElementById('paginationEnd');

        const paginationTotal =
            document.getElementById('paginationTotal');

        const filteredData = getFilteredData();

        /*
        |--------------------------------------------------------------------------
        | Informasi jumlah data
        |--------------------------------------------------------------------------
        */

        const startIndex =
            filteredData.length === 0
                ? 0
                : (currentPage - 1) * itemsPerPage + 1;

        const endIndex =
            Math.min(
                currentPage * itemsPerPage,
                filteredData.length
            );

        paginationStart.textContent = startIndex;
        paginationEnd.textContent = endIndex;
        paginationTotal.textContent = filteredData.length;

        /*
        |--------------------------------------------------------------------------
        | Hanya tampil kalau lebih dari 1 halaman
        |--------------------------------------------------------------------------
        */

        if (totalPages <= 1) {
            container.classList.add('hidden');
            return;
        }

        container.classList.remove('hidden');

        buttons.innerHTML = '';

        /*
        |--------------------------------------------------------------------------
        | Tombol Sebelumnya
        |--------------------------------------------------------------------------
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

        previousButton.addEventListener('click', () => {

            if (currentPage > 1) {

                currentPage--;

                renderTable();
            }
        });

        buttons.appendChild(previousButton);

        /*
        |--------------------------------------------------------------------------
        | Nomor Halaman
        |--------------------------------------------------------------------------
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
                () => {

                    currentPage = page;

                    renderTable();
                }
            );

            buttons.appendChild(pageButton);
        }

        /*
        |--------------------------------------------------------------------------
        | Tombol Berikutnya
        |--------------------------------------------------------------------------
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

        nextButton.addEventListener('click', () => {

            if (currentPage < totalPages) {

                currentPage++;

                renderTable();
            }
        });

        buttons.appendChild(nextButton);
    }

    /*
    |--------------------------------------------------------------------------
    | Set Filter
    |--------------------------------------------------------------------------
    */

    function setFilter(filter) {

        activeFilter = filter;

        currentPage = 1;

        document.querySelectorAll('.filter-button').forEach(button => {

            const isActive =
                button.dataset.filter === filter;

            if (isActive) {

                button.className =
                    'filter-button rounded-full bg-[#7F1D1D] px-4 py-2 text-sm font-medium text-white transition';

            } else {

                button.className =
                    'filter-button rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#7F1D1D] hover:text-white';

            }
        });

        renderTable();
    }

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('searchInput')
        .addEventListener('input', function(event) {

            search = event.target.value;

            currentPage = 1;

            renderTable();
        });

    /*
    |--------------------------------------------------------------------------
    | Reset Filter
    |--------------------------------------------------------------------------
    */

    function resetFilter() {

        activeFilter = 'Semua';

        search = '';

        currentPage = 1;

        document.getElementById('searchInput').value = '';

        setFilter('Semua');
    }

    /*
    |--------------------------------------------------------------------------
    | Export CSV
    |--------------------------------------------------------------------------
    */

    function exportCSV() {

        const filteredData = getFilteredData();

        const header = [
            'Waktu',
            'Aktor',
            'Tipe Aktor',
            'Aksi',
            'Objek',
            'Keterangan'
        ];

        const rows = filteredData.map(item => [
            `${item.date} ${item.time}`,
            item.actor,
            item.actorType,
            item.action,
            item.object,
            item.description
        ]);

        const csv = [header, ...rows]
            .map(row =>
                row
                    .map(value =>
                        `"${String(value).replace(/"/g, '""')}"`
                    )
                    .join(',')
            )
            .join('\n');

        const blob = new Blob(
            [csv],
            {
                type: 'text/csv;charset=utf-8;'
            }
        );

        const url = URL.createObjectURL(blob);

        const link = document.createElement('a');

        link.href = url;

        link.setAttribute(
            'download',
            'riwayat-audit.csv'
        );

        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);

        URL.revokeObjectURL(url);
    }

    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    |
    | Digunakan supaya data yang berasal dari PHP tidak langsung
    | dianggap sebagai HTML oleh browser.
    |
    */

    function escapeHtml(value) {

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    /*
    |--------------------------------------------------------------------------
    | Initial Render
    |--------------------------------------------------------------------------
    */

    renderTable();
</script>
@endsection