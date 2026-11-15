@extends('layouts.admin')

@section('title', 'Dashboard — Admin')

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
            Kondisi pemrosesan dokumen inovasi dan konfigurasi SIGAP hari ini.
        </p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs text-slate-500">Total Submission</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $stats['total_submission'] }}</p>
            <p class="mt-1 text-xs text-slate-400">Semua periode</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs text-slate-500">Pending Review</p>
            <p class="mt-2 text-3xl font-semibold text-amber-600">{{ $stats['pending_review'] }}</p>
            <p class="mt-1 text-xs text-slate-400">Menunggu verifikator</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs text-slate-500">Approved</p>
            <p class="mt-2 text-3xl font-semibold text-emerald-600">{{ $stats['approved'] }}</p>
            <p class="mt-1 text-xs text-slate-400">Pengajuan disetujui</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs text-slate-500">Rejected</p>
            <p class="mt-2 text-3xl font-semibold text-rose-600">{{ $stats['rejected'] }}</p>
            <p class="mt-1 text-xs text-slate-400">Pengajuan ditolak</p>
        </div>

    </div>

    {{-- Chart + Aktivitas --}}
    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Chart --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-slate-800">Submission 6 Bulan Terakhir</h2>
                <div class="flex items-center gap-3 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-sm bg-emerald-500"></span>
                        Approved
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-sm bg-rose-500"></span>
                        Rejected
                    </span>
                </div>
            </div>
            <div class="mt-4 h-64">
                <canvas id="submissionChart"></canvas>
            </div>
        </div>

        {{-- Aktivitas --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="text-sm font-semibold text-slate-800">Aktivitas Terbaru</h2>

            @if ($aktivitas_terbaru->isEmpty())
                <div class="mt-4 rounded-lg border border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                    <p class="text-sm text-slate-500">Belum ada aktivitas.</p>
                </div>
            @else
                <ul class="mt-4 divide-y divide-slate-100">
                    @foreach ($aktivitas_terbaru as $item)
                        <li class="py-3">
                            <p class="text-sm text-slate-800 [overflow-wrap:anywhere]">
                                <span class="font-semibold">{{ $item->user }}</span>
                                <span class="text-slate-500"> — {{ $item->aksi }}</span>
                            </p>
                            <p class="mt-1 text-xs text-slate-400">{{ $item->waktu->diffForHumans() }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>

    {{-- Stat Pengguna + Indikator --}}
    <div class="grid gap-6 lg:grid-cols-2">

        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <p class="text-xs text-slate-500">Total Pengguna</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $stats['total_user'] }}</p>
            <p class="mt-2 text-xs text-slate-500">Terdaftar di sistem</p>
            <a href="{{ route('admin.pengguna.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-[#7a161a] hover:underline">
                Kelola pengguna →
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <p class="text-xs text-slate-500">Indikator Terdaftar</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $stats['total_indikator'] }}</p>
            <p class="mt-2 text-xs text-slate-500">Panduan Inovasi BRIDA (IID Kemendagri 2026)</p>
            <a href="{{ route('admin.indikator.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-[#7a161a] hover:underline">
                Lihat indikator →
            </a>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const el = document.getElementById('submissionChart');
        if (!el) return;

        const data = @json($chart_data);

        new Chart(el, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Approved',
                        data: data.approved,
                        backgroundColor: '#10b981',
                        borderRadius: 6,
                    },
                    {
                        label: 'Rejected',
                        data: data.rejected,
                        backgroundColor: '#f43f5e',
                        borderRadius: 6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#64748b' } },
                    y: { beginAtZero: true, ticks: { color: '#64748b' }, grid: { color: '#f1f5f9' } },
                },
            },
        });
    })();
</script>
@endsection
