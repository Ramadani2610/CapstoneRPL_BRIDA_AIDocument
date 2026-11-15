@extends('layouts.admin')

@section('title', 'Dashboard — Admin')

@php
    $badgeStyle = [
        'analisis-ai' => 'bg-sky-50 text-sky-700',
        'ocr' => 'bg-slate-100 text-slate-700',
        'pengajuan' => 'bg-rose-50 text-rose-700',
        'minta-dokumen' => 'bg-amber-50 text-amber-700',
        'gagal' => 'bg-rose-100 text-rose-700',
    ];
    $badgeLabel = [
        'analisis-ai' => 'Analisis AI selesai',
        'ocr' => 'OCR selesai',
        'pengajuan' => 'Pengajuan dikirim',
        'minta-dokumen' => 'Minta dokumen tambahan',
        'gagal' => 'Pemrosesan gagal',
    ];

    $getInitials = function (string $name): string {
        $parts = preg_split('/\s+/', trim($name));
        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        }
        return strtoupper(substr($parts[0] ?? '', 0, 2));
    };

    $inovatorPct = ($ringkasan_pengguna['breakdown'][0]['jumlah'] / $ringkasan_pengguna['total']) * 100;
@endphp

@section('content')
<div class="space-y-6 overflow-x-hidden">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V10"/>
        </svg>
        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-700">Dashboard</span>
    </nav>

    {{-- Heading --}}
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Ringkasan Sistem</h1>
        <p class="mt-1 text-sm text-slate-500">
            Kondisi pemrosesan dokumen inovasi dan konfigurasi SIGAP per {{ $tanggal_ringkasan }}.
        </p>
    </div>

    {{-- Row 1: Kartu Inovasi (2/3) + Pengguna & Indikator (1/3) --}}
    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Kartu Inovasi --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 lg:col-span-2">
            <div class="flex flex-wrap items-start justify-between gap-6">
                <div>
                    <p class="text-sm text-slate-500">Total Inovasi Diproses</p>
                    <p class="mt-2 text-4xl font-semibold text-slate-900">{{ $ringkasan_inovasi['total_diproses'] }}</p>
                    <p class="mt-2 text-xs font-medium text-emerald-600">📈 {{ $ringkasan_inovasi['pertumbuhan'] }}</p>
                </div>
            </div>

            {{-- Breakdown chip responsive --}}
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                <div class="min-w-0 rounded-lg bg-slate-50 p-2.5">
                    <p class="truncate text-xs text-slate-500">Disetujui</p>
                    <p class="text-lg font-semibold text-emerald-600">{{ $ringkasan_inovasi['disetujui'] }}</p>
                </div>
                <div class="min-w-0 rounded-lg bg-slate-50 p-2.5">
                    <p class="truncate text-xs text-slate-500">Perbaikan</p>
                    <p class="text-lg font-semibold text-amber-600">{{ $ringkasan_inovasi['perbaikan'] }}</p>
                </div>
                <div class="min-w-0 rounded-lg bg-slate-50 p-2.5">
                    <p class="truncate text-xs text-slate-500">Ditolak</p>
                    <p class="text-lg font-semibold text-rose-600">{{ $ringkasan_inovasi['ditolak'] }}</p>
                </div>
                <div class="min-w-0 rounded-lg bg-slate-50 p-2.5">
                    <p class="truncate text-xs text-slate-500">Diproses</p>
                    <p class="text-lg font-semibold text-slate-700">{{ $ringkasan_inovasi['diproses'] }}</p>
                </div>
            </div>

            {{-- Chart --}}
            <div class="mt-4 h-48 w-full">
                <canvas id="inovasiChart"></canvas>
            </div>
        </div>

        {{-- Kartu Pengguna + Indikator --}}
        <div class="space-y-6">

            {{-- Total Pengguna --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <p class="text-sm text-slate-500">Total Pengguna</p>
                <p class="mt-2 text-4xl font-semibold text-slate-900">{{ $ringkasan_pengguna['total'] }}</p>

                {{-- Progress bar gradient --}}
                <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-slate-100">
                    <div
                        class="h-full rounded-full bg-gradient-to-r from-[#7a161a] via-rose-400 to-rose-200"
                        style="width: {{ min(100, $inovatorPct + 20) }}%"
                    ></div>
                </div>

                <ul class="mt-3 space-y-1 text-xs text-slate-600">
                    @foreach ($ringkasan_pengguna['breakdown'] as $item)
                        <li class="flex items-center justify-between gap-2">
                            <span class="flex min-w-0 items-center gap-2">
                                <span class="h-2 w-2 shrink-0 rounded-full bg-[#7a161a]"></span>
                                <span class="truncate">{{ $item['peran'] }}</span>
                            </span>
                            <span class="shrink-0 font-medium text-slate-700">{{ $item['jumlah'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Indikator Aktif --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <p class="text-sm text-slate-500">Indikator Aktif</p>
                <p class="mt-2 text-4xl font-semibold text-slate-900">
                    {{ $ringkasan_indikator['aktif'] }}<span class="text-xl text-slate-400"> / {{ $ringkasan_indikator['total'] }}</span>
                </p>
                <p class="mt-2 text-xs font-medium text-emerald-600">
                    {{ $ringkasan_indikator['parameter_aktif'] }} parameter penilaian aktif
                </p>
            </div>

        </div>

    </div>

    {{-- Row 2: Shortcut (1/3) + Aktivitas (2/3) --}}
    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Shortcut --}}
        <div class="space-y-4">

            <a
                href="{{ route('admin.pengguna.index') }}"
                class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 transition hover:border-rose-300 hover:bg-[#FDF2F2]"
            >
                <div class="shrink-0 rounded-xl bg-slate-100 p-3 text-slate-600 group-hover:bg-white group-hover:text-[#7a161a]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="9" cy="8" r="3.5" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 20c0-3.314 2.686-6 6-6s6 2.686 6 6"/>
                        <circle cx="17" cy="9" r="2.5" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 19c0-2.21-1.79-4-4-4"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-slate-800 group-hover:text-[#7a161a]">Kelola Akun Pengguna</p>
                    <p class="mt-1 break-words text-xs text-slate-500">Tambah pengguna, atur peran, dan status akun.</p>
                </div>
                <svg class="mt-2 h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a
                href="{{ route('admin.indikator.index') }}"
                class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 transition hover:border-rose-300 hover:bg-[#FDF2F2]"
            >
                <div class="shrink-0 rounded-xl bg-slate-100 p-3 text-slate-600 group-hover:bg-white group-hover:text-[#7a161a]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5h18M6 12h12M10 19h4"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-slate-800 group-hover:text-[#7a161a]">Konfigurasi Indikator &amp; Parameter</p>
                    <p class="mt-1 break-words text-xs text-slate-500">Atur kriteria pemenuhan dan contoh dokumen.</p>
                </div>
                <svg class="mt-2 h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-slate-800">Aktivitas Terbaru</h2>
                {{-- FIXME: route('admin.log-audit') setelah ada. --}}
                <a href="#" class="text-xs font-medium text-[#7a161a] hover:underline">Lihat semua</a>
            </div>

            <ul class="mt-4 divide-y divide-slate-100">
                @foreach ($aktivitas_terbaru as $item)
                    <li class="flex flex-wrap items-start gap-3 py-3 sm:flex-nowrap sm:gap-4">
                        <div class="w-20 shrink-0 text-xs text-slate-500">
                            <p class="font-medium text-slate-700">{{ $item->tanggal }}</p>
                            <p>{{ $item->waktu }}</p>
                        </div>
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-600">
                            {{ $getInitials($item->aktor) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm text-slate-800 [overflow-wrap:anywhere]">
                                <span class="font-semibold">{{ $item->aktor }}</span>
                                <span class="text-slate-500"> — {{ $item->keterangan }}</span>
                            </p>
                        </div>
                        <span class="w-full self-start rounded-full px-2.5 py-0.5 text-xs font-medium sm:ml-auto sm:w-auto sm:shrink-0 {{ $badgeStyle[$item->status] }}">
                            • {{ $badgeLabel[$item->status] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const el = document.getElementById('inovasiChart');
        if (!el) return;

        const data = @json($grafik_bulanan);
        const labels = data.map(d => d.bulan);
        const values = data.map(d => d.jumlah);
        const colors = values.map((_, i) => i === values.length - 1 ? '#991b1b' : '#fecaca');

        new Chart(el, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderRadius: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#0f172a',
                        bodyColor: '#334155',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                    },
                    datalabels: false,
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#64748b', font: { size: 12 } },
                        border: { display: false },
                    },
                    y: { display: false, beginAtZero: true },
                },
                animation: { duration: 400 },
            },
            plugins: [{
                afterDatasetsDraw(chart) {
                    const { ctx } = chart;
                    const dataset = chart.getDatasetMeta(0);
                    ctx.save();
                    ctx.font = '600 12px ui-sans-serif, system-ui';
                    ctx.fillStyle = '#334155';
                    ctx.textAlign = 'center';
                    dataset.data.forEach((bar, i) => {
                        ctx.fillText(values[i], bar.x, bar.y - 6);
                    });
                    ctx.restore();
                },
            }],
        });
    })();
</script>
@endsection
