@extends('layouts.admin')

@section('title', 'Indikator & Parameter — Admin')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V10"/>
        </svg>
        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span>Dashboard</span>
        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-700">Indikator &amp; Parameter</span>
    </nav>

    {{-- Heading --}}
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Indikator &amp; Parameter</h1>
        <p class="mt-1 text-sm text-slate-500">
            Referensi standar indikator penilaian inovasi daerah menurut Panduan Inovasi BRIDA
            (IID Kemendagri 2026). {{ $indikators->count() }} indikator terdaftar.
        </p>
    </div>

    {{-- Layout 2 panel --}}
    <div class="grid gap-6 lg:grid-cols-[320px_1fr]">

        {{-- Sidebar list --}}
        <aside class="flex h-full flex-col rounded-2xl border border-slate-200 bg-white">
            <div class="border-b border-slate-100 p-4">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7" stroke-width="1.8"/>
                        <path d="M21 21l-4.35-4.35" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <input
                        id="indikatorSearch"
                        type="text"
                        placeholder="Cari indikator"
                        class="w-full rounded-lg border border-slate-200 bg-white py-2 pl-9 pr-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-[#7a161a] focus:outline-none focus:ring-1 focus:ring-[#7a161a]"
                    />
                </div>
            </div>

            <ul id="indikatorList" class="flex-1 divide-y divide-slate-100 overflow-y-auto">
                @foreach ($indikators as $i => $ind)
                    <li data-kode="{{ $ind->kode }}" data-search="{{ strtolower($ind->kode . ' ' . $ind->nama) }}">
                        <button
                            type="button"
                            onclick="selectIndikator({{ $ind->kode }})"
                            class="indikator-item w-full border-l-4 px-4 py-3 text-left transition {{ $i === 0 ? 'border-[#7a161a] bg-[#FDF2F2]' : 'border-transparent hover:bg-slate-50' }}"
                        >
                            <div class="flex items-start gap-3">
                                <span class="shrink-0 rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-mono font-semibold text-slate-600">
                                    {{ $ind->kode }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-slate-800">{{ $ind->nama }}</p>
                                    <p class="mt-1 flex items-center gap-1 text-xs text-slate-500">
                                        <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"></span>
                                        Bobot {{ $ind->bobot }} · Aktif
                                    </p>
                                </div>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>

            <div id="emptyState" class="hidden p-6 text-center text-sm text-slate-500">
                Tidak ada indikator yang cocok.
            </div>
        </aside>

        {{-- Detail panels --}}
        <div id="detailWrapper">
            @foreach ($indikators as $i => $ind)
                <section
                    id="detail-{{ $ind->kode }}"
                    class="indikator-detail rounded-2xl border border-slate-200 bg-white {{ $i === 0 ? '' : 'hidden' }}"
                >
                    {{-- Header --}}
                    <div class="border-b border-slate-100 p-6">
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            <span class="rounded bg-slate-100 px-2 py-0.5 text-xs font-mono font-semibold text-slate-600">
                                {{ $ind->kode }}
                            </span>
                            @if ($ind->wajib)
                                <span class="rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700">
                                    MANDATORY
                                </span>
                            @endif
                            <span class="flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium {{ $ind->aktif ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $ind->aktif ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $ind->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ $ind->nama }}</h2>
                        @if ($ind->deskripsi)
                            <p class="mt-2 text-sm text-slate-600">{{ $ind->deskripsi }}</p>
                        @endif
                    </div>

                    <div class="space-y-6 p-6">

                        {{-- Bobot Penilaian --}}
                        <section>
                            <h3 class="mb-2 text-sm font-semibold text-slate-800">Bobot Penilaian</h3>
                            <div class="flex items-baseline gap-2 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                                <span class="text-2xl font-semibold text-[#7a161a]">{{ $ind->bobot }}</span>
                                <span class="text-sm text-slate-600">× 3 bintang = maks {{ $ind->bobot * 3 }} poin</span>
                            </div>
                        </section>

                        {{-- Opsi Penilaian --}}
                        <section>
                            <h3 class="mb-3 text-sm font-semibold text-slate-800">Opsi Penilaian</h3>
                            <ul class="space-y-2">
                                @foreach ($ind->tiers->sortByDesc('bintang') as $tier)
                                    @php $terbaik = $tier->bintang === 3; @endphp
                                    <li class="flex items-start gap-3 rounded-lg border p-3 {{ $terbaik ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-white' }}">
                                        <div class="flex shrink-0 items-center gap-0.5">
                                            @for ($b = 0; $b < $tier->bintang; $b++)
                                                <svg class="h-3.5 w-3.5 {{ $terbaik ? 'fill-emerald-500 text-emerald-500' : 'fill-amber-400 text-amber-400' }}" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm {{ $terbaik ? 'text-emerald-900' : 'text-slate-800' }}">{{ $tier->label }}</p>
                                            @if ($terbaik)
                                                <p class="mt-0.5 text-[11px] font-semibold uppercase tracking-wide text-emerald-700">Nilai terbaik</p>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </section>

                        {{-- Catatan Tambahan --}}
                        @if ($ind->catatan_tambahan)
                            <section>
                                <div class="flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 p-4">
                                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8h.01M11 12h1v4h1"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-amber-900">Catatan Tambahan</p>
                                        <p class="mt-1 text-sm text-amber-800 [overflow-wrap:anywhere]">{{ $ind->catatan_tambahan }}</p>
                                    </div>
                                </div>
                            </section>
                        @endif

                        {{-- Eviden & Bukti Dukung --}}
                        <section>
                            <h3 class="mb-2 text-sm font-semibold text-slate-800">Eviden &amp; Bukti Dukung</h3>
                            <div class="rounded-lg border border-slate-200 bg-white p-4">
                                <p class="text-sm text-slate-700 [overflow-wrap:anywhere]">
                                    {{ $ind->eviden_deskripsi }}
                                </p>
                                <div class="mt-3">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">
                                        {{ $ind->eviden_format }}
                                    </span>
                                </div>
                            </div>
                        </section>

                        {{-- Contoh Bukti dari BRIDA --}}
                        @if ($ind->contoh_bukti_url)
                            <section>
                                <h3 class="mb-2 text-sm font-semibold text-slate-800">Contoh Bukti dari BRIDA</h3>
                                <a
                                    href="{{ $ind->contoh_bukti_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-[#FDF2F2] px-4 py-2 text-sm font-medium text-[#7a161a] transition hover:bg-rose-100"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Lihat Contoh Bukti
                                </a>
                            </section>
                        @endif

                    </div>
                </section>
            @endforeach
        </div>

    </div>

</div>

<script>
    function selectIndikator(kode) {
        document.querySelectorAll('.indikator-item').forEach(function (btn) {
            btn.classList.remove('border-[#7a161a]', 'bg-[#FDF2F2]');
            btn.classList.add('border-transparent');
        });
        const activeBtn = document.querySelector('[data-kode="' + kode + '"] .indikator-item');
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent');
            activeBtn.classList.add('border-[#7a161a]', 'bg-[#FDF2F2]');
        }

        document.querySelectorAll('.indikator-detail').forEach(function (el) {
            el.classList.add('hidden');
        });
        const detail = document.getElementById('detail-' + kode);
        if (detail) {
            detail.classList.remove('hidden');
        }

        if (window.innerWidth < 1024 && detail) {
            detail.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    (function () {
        const input = document.getElementById('indikatorSearch');
        const list = document.getElementById('indikatorList');
        const empty = document.getElementById('emptyState');
        if (!input || !list) return;

        input.addEventListener('input', function () {
            const q = input.value.trim().toLowerCase();
            let visible = 0;

            list.querySelectorAll('li').forEach(function (li) {
                const match = !q || li.dataset.search.includes(q);
                li.classList.toggle('hidden', !match);
                if (match) visible++;
            });

            empty.classList.toggle('hidden', visible > 0);
            list.classList.toggle('hidden', visible === 0);
        });
    })();
</script>
@endsection
