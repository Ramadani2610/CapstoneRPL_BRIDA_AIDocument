@extends('layouts.app')

@section('title', 'Antrian Review - SIGAP Inovasi')

@section('content')

<script>
    const failedDocuments = @json($failedDocuments);

    let processingIds = [];
    let currentPage = 1;
    const itemsPerPage = 5;

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function errorIcon(type) {
        if (type === 'timeout') {
            return `
                <svg width="23" height="23" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="8.5" />
                    <path d="M12 7v5l3 2" />
                </svg>
            `;
        }

        if (type === 'protected') {
            return `
                <svg width="23" height="23" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="4" y="10" width="16" height="10" rx="2" />
                    <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                </svg>
            `;
        }

        if (type === 'text') {
            return `
                <svg width="23" height="23" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="5" y="3" width="14" height="18" rx="2" />
                    <path d="M9 8h6" />
                    <path d="M9 12h6" />
                    <path d="M9 16h3" />
                </svg>
            `;
        }

        return `
            <svg width="23" height="23" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="1.8"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 3h6" />
                <path d="M10 3v3L5.5 10.5A2 2 0 0 0 5 12v6a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-6a2 2 0 0 0-.5-1.5L14 6V3" />
                <path d="M8 13h8" />
                <path d="M9 17h6" />
            </svg>
        `;
    }

    function retryIcon() {
        return `
            <svg width="17" height="17" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12a9 9 0 1 1-2.64-6.36" />
                <polyline points="21 3 21 9 15 9" />
            </svg>
        `;
    }

    function uploadIcon() {
        return `
            <svg width="17" height="17" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="2" />
                <path d="m3 7 9 6 9-6" />
            </svg>
        `;
    }

    function getTotalPages() {
        return Math.max(
            1,
            Math.ceil(failedDocuments.length / itemsPerPage)
        );
    }

    function handleRetry(id) {
        if (processingIds.includes(id)) {
            return;
        }

        processingIds.push(id);
        renderPage();

        setTimeout(() => {
            processingIds = processingIds.filter(
                itemId => itemId !== id
            );

            renderPage();
        }, 1500);
    }

    function handleRetryAll() {
        const retryableIds = failedDocuments
            .filter(item => item.canRetry)
            .map(item => item.id);

        processingIds = retryableIds;
        renderPage();

        setTimeout(() => {
            processingIds = [];
            renderPage();
        }, 1500);
    }

    function handleRequestUpload(fileName) {
        window.alert(
            `Permintaan unggah ulang untuk ${fileName} akan dikirim ke inovator.`
        );
    }

    function renderPage() {
        const totalPages = getTotalPages();

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        const startIndex = (currentPage - 1) * itemsPerPage;

        const paginatedDocuments = failedDocuments.slice(
            startIndex,
            startIndex + itemsPerPage
        );

        const retryableCount = failedDocuments.filter(
            item => item.canRetry
        ).length;

        const isProcessingAll = processingIds.length > 0;

        const listContainer =
            document.getElementById('failed-document-list');

        const retryAllButton =
            document.getElementById('retry-all-button');

        const resultInfo =
            document.getElementById('result-info');

        const paginationInfo =
            document.getElementById('pagination-info');

        const paginationButtons =
            document.getElementById('pagination-buttons');

        /*
         * Tombol Retry Semua
         */
        retryAllButton.disabled = isProcessingAll;

        retryAllButton.innerHTML = `
            ${retryIcon()}
            ${
                isProcessingAll
                    ? 'Memproses...'
                    : `Retry Semua (${retryableCount})`
            }
        `;

        /*
         * Informasi jumlah data
         */
        resultInfo.innerHTML = `
            Menampilkan
            <span class="font-semibold text-slate-800">
                ${paginatedDocuments.length}
            </span>
            dari
            <span class="font-semibold text-slate-800">
                ${failedDocuments.length}
            </span>
            dokumen dalam antrian review
        `;

        /*
         * Daftar dokumen
         */
        listContainer.innerHTML = paginatedDocuments
            .map((item, index) => {
                const isProcessing =
                    processingIds.includes(item.id);

                const borderClass =
                    index !== paginatedDocuments.length - 1
                        ? 'border-b border-slate-200'
                        : '';

                return `
                    <div
                        class="flex flex-col gap-5 px-5 py-5 transition ${borderClass}"
                    >
                        <div
                            class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between"
                        >

                            <!-- Left content -->
                            <div
                                class="flex min-w-0 flex-1 items-start gap-4"
                            >

                                <!-- Error icon -->
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-[#F9DADA] text-[#8B2525]"
                                >
                                    ${errorIcon(item.icon)}
                                </div>

                                <!-- Information -->
                                <div class="min-w-0 flex-1">

                                    <!-- File name -->
                                    <div
                                        class="flex flex-wrap items-baseline gap-2"
                                    >
                                        <h2
                                            class="text-[15px] font-bold text-slate-800"
                                        >
                                            ${escapeHtml(item.fileName)}
                                        </h2>

                                        <span
                                            class="text-xs text-slate-400"
                                        >
                                            ${escapeHtml(item.fileSize)}
                                        </span>
                                    </div>

                                    <!-- Submission information -->
                                    <p
                                        class="mt-1 text-[13px] text-slate-500"
                                    >
                                        <span
                                            class="font-medium text-slate-500"
                                        >
                                            ${escapeHtml(item.submissionId)}
                                        </span>

                                        <span class="mx-1.5">·</span>

                                        ${escapeHtml(item.innovationName)}

                                        <span class="mx-1.5">·</span>

                                        ${escapeHtml(item.indicator)}
                                    </p>

                                    <!-- Error description -->
                                    <div
                                        class="mt-2.5 flex flex-wrap items-center gap-2"
                                    >
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-[#F9DADA] px-2.5 py-1 text-xs font-medium text-[#8B2525]"
                                        >
                                            <span
                                                class="h-1.5 w-1.5 rounded-full bg-[#8B2525]"
                                            ></span>

                                            ${escapeHtml(item.errorType)}
                                        </span>

                                        <span
                                            class="text-sm text-slate-600"
                                        >
                                            ${escapeHtml(item.description)}
                                        </span>
                                    </div>

                                    <!-- Attempt -->
                                    <div
                                        class="mt-2 text-xs text-slate-500"
                                    >
                                        ${escapeHtml(item.attempt)}

                                        <span class="mx-1.5">·</span>

                                        <span
                                            class="${
                                                item.lastAttempt
                                                    ? 'font-medium text-[#8B2525]'
                                                    : ''
                                            }"
                                        >
                                            ${escapeHtml(item.failedAt)}
                                        </span>

                                        ${
                                            item.lastAttempt
                                                ? `
                                                    <span class="mx-1.5">·</span>
                                                    <span
                                                        class="font-medium text-[#8B2525]"
                                                    >
                                                        Batas percobaan tercapai
                                                    </span>
                                                `
                                                : ''
                                        }
                                    </div>
                                </div>
                            </div>

                            <!-- Action -->
                            <div
                                class="flex shrink-0 justify-end xl:pl-6"
                            >
                                ${
                                    item.canRetry
                                        ? `
                                            <button
                                                type="button"
                                                ${
                                                    isProcessing
                                                        ? 'disabled'
                                                        : ''
                                                }
                                                onclick="handleRetry(${item.id})"
                                                class="inline-flex min-w-[185px] items-center justify-center gap-2 rounded-lg bg-[#7F1D1D] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#681818] disabled:cursor-not-allowed disabled:opacity-70"
                                            >
                                                ${retryIcon()}

                                                ${
                                                    isProcessing
                                                        ? 'Memproses...'
                                                        : escapeHtml(item.retryLabel)
                                                }
                                            </button>
                                        `
                                        : `
                                            <button
                                                type="button"
                                                onclick="handleRequestUpload('${escapeHtml(item.fileName)}')"
                                                class="inline-flex min-w-[185px] items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-[#8B2525] hover:bg-[#FFF7F7] hover:text-[#7F1D1D]"
                                            >
                                                ${uploadIcon()}

                                                ${escapeHtml(item.retryLabel)}
                                            </button>
                                        `
                                }
                            </div>
                        </div>
                    </div>
                `;
            })
            .join('');

        /*
         * Pagination
         */
        paginationInfo.innerHTML = `
            Halaman
            <span class="font-semibold text-slate-800">
                ${currentPage}
            </span>
            dari
            <span class="font-semibold text-slate-800">
                ${totalPages}
            </span>
        `;

        paginationButtons.innerHTML = `
            <button
                type="button"
                ${currentPage === 1 ? 'disabled' : ''}
                onclick="goToPage(${currentPage - 1})"
                class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#7F1D1D] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-slate-600"
            >
                ← Sebelumnya
            </button>

            ${Array.from(
                { length: totalPages },
                (_, index) => index + 1
            )
                .map(
                    page => `
                        <button
                            type="button"
                            ${
                                totalPages === 1
                                    ? 'disabled'
                                    : ''
                            }
                            onclick="goToPage(${page})"
                            class="h-9 min-w-9 rounded-lg px-3 text-sm font-medium transition ${
                                currentPage === page
                                    ? 'bg-[#7F1D1D] text-white'
                                    : 'border border-slate-300 bg-white text-slate-600 hover:bg-[#7F1D1D] hover:text-white'
                            } ${
                                totalPages === 1
                                    ? 'cursor-default'
                                    : ''
                            }"
                        >
                            ${page}
                        </button>
                    `
                )
                .join('')}

            <button
                type="button"
                ${
                    currentPage === totalPages
                        ? 'disabled'
                        : ''
                }
                onclick="goToPage(${currentPage + 1})"
                class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#7F1D1D] hover:text-white disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-slate-600"
            >
                Berikutnya →
            </button>
        `;
    }

    function goToPage(page) {
        const totalPages = getTotalPages();

        currentPage = Math.min(
            Math.max(page, 1),
            totalPages
        );

        renderPage();
    }

    document.addEventListener('DOMContentLoaded', function () {
        renderPage();
    });
</script>

<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-400">

        <svg
            width="17"
            height="17"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="m3 11 9-8 9 8" />
            <path d="M5 10v10h14V10" />
            <path d="M9 20v-6h6v6" />
        </svg>

        <span>Dashboard</span>

        <span class="text-slate-300">›</span>

        <span class="font-medium text-slate-700">
            Antrian Review
        </span>
    </div>

    {{-- Header --}}
    <div
        class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between"
    >
        <div>
            <h1
                class="text-[27px] font-bold tracking-tight text-slate-900"
            >
                Antrian Review Dokumen
            </h1>

            <p
                class="mt-1.5 max-w-4xl text-[15px] leading-6 text-slate-500"
            >
                Dokumen yang memerlukan perhatian atau tindakan verifikator.
                Tinjau kendala pemrosesan dokumen, lakukan proses ulang jika
                memungkinkan, atau minta inovator mengunggah versi baru.
            </p>
        </div>

        <button
            id="retry-all-button"
            type="button"
            onclick="handleRetryAll()"
            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#7F1D1D] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#681818] disabled:cursor-not-allowed disabled:opacity-70"
        >
            Memproses...
        </button>
    </div>

    {{-- Result info --}}
    <div class="flex items-center justify-between">
        <p
            id="result-info"
            class="text-sm text-slate-500"
        ></p>
    </div>

    {{-- Failed document list --}}
    <div
        class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"
        id="failed-document-list"
    ></div>

    {{-- Pagination --}}
    <div
        class="flex flex-col gap-3 border-t border-slate-200 bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
    >
        <p
            id="pagination-info"
            class="text-sm text-slate-500"
        ></p>

        <div
            id="pagination-buttons"
            class="flex items-center gap-2"
        ></div>
    </div>

    {{-- Footer note --}}
    <p class="text-xs leading-5 text-slate-400">
        File terproteksi kata sandi atau yang telah mencapai batas 3
        percobaan tidak dapat diproses ulang dan perlu diunggah ulang oleh
        inovator.
    </p>

</div>

@endsection