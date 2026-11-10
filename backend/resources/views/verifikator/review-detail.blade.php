@extends('layouts.app')

@section('title', 'Detail Review Pengajuan - SIGAP Inovasi')

@section('content')
@php
    /*
    |--------------------------------------------------------------------------
    | DATA DEMO UNTUK PREVIEW DESAIN
    |--------------------------------------------------------------------------
    | Setelah desain disetujui, pindahkan data ini ke VerifikatorController.
    | View ini menerima variabel $review dari controller.
    */
    $review = $review ?? [
        'id' => 12,
        'kode' => 'INV-2026-012',
        'judul' => 'Si-Lapor Sampah Lorong',
        'deskripsi' => 'Platform pelaporan dan pemantauan pengelolaan sampah berbasis masyarakat untuk meningkatkan kebersihan lingkungan lorong.',
        'opd' => 'Dinas Komunikasi dan Informatika',
        'kategori' => 'Pelayanan Publik',
        'tahun' => 2026,
        'status' => 'menunggu_review',
        'diajukan_oleh' => 'Nurul Hidayah',
        'submitted_at' => now()->subDays(3)->format('d M Y, H:i'),
        'per_indikator' => [
            [
                'indicator_kode' => 1,
                'indicator_nama' => 'Kebaruan',
                'bobot' => 20,
                'wajib' => true,
                'bintang_diklaim' => 3,
                'tier_label' => 'Inovasi unggulan',
                'evidences' => [
                    ['id' => 1, 'nama_asli' => 'Dokumen_Kebaruan_Inovasi.pdf', 'ukuran_label' => '1.8 MB', 'tahun_dokumen' => 2026, 'url' => '#'],
                    ['id' => 2, 'nama_asli' => 'Surat_Keterangan_Inovasi.pdf', 'ukuran_label' => '820 KB', 'tahun_dokumen' => 2026, 'url' => '#'],
                ],
                'usulan_ai' => [
                    ['mesin' => 'llm', 'usulan_bintang' => 3, 'keyakinan' => 0.92, 'ringkasan' => 'Dokumen menunjukkan unsur kebaruan melalui pendekatan pelaporan sampah berbasis partisipasi warga. Terdapat penjelasan mengenai perbedaan proses dengan mekanisme pelaporan sebelumnya.'],
                    ['mesin' => 'rules', 'usulan_bintang' => 3, 'keyakinan' => null, 'ringkasan' => 'Kata kunci kebaruan dan pembeda ditemukan pada dokumen.'],
                ],
                'keputusan' => null,
            ],
            [
                'indicator_kode' => 2,
                'indicator_nama' => 'Efektivitas',
                'bobot' => 25,
                'wajib' => true,
                'bintang_diklaim' => 3,
                'tier_label' => 'Dampak tinggi',
                'evidences' => [
                    ['id' => 3, 'nama_asli' => 'Laporan_Hasil_Implementasi.pdf', 'ukuran_label' => '2.4 MB', 'tahun_dokumen' => 2026, 'url' => '#'],
                ],
                'usulan_ai' => [
                    ['mesin' => 'llm', 'usulan_bintang' => 2, 'keyakinan' => 0.54, 'ringkasan' => 'Dokumen memuat hasil implementasi, tetapi bukti kuantitatif mengenai perubahan waktu penanganan dan pengurangan volume sampah masih terbatas. Verifikator disarankan memeriksa indikator dampak secara lebih lanjut.'],
                ],
                'keputusan' => null,
            ],
            [
                'indicator_kode' => 3,
                'indicator_nama' => 'Keberlanjutan',
                'bobot' => 15,
                'wajib' => false,
                'bintang_diklaim' => 2,
                'tier_label' => 'Berkembang',
                'evidences' => [],
                'usulan_ai' => [],
                'keputusan' => null,
            ],
        ],
    ];

    $statusLabel = [
        'menunggu_review' => 'Menunggu Review',
        'diterima' => 'Diterima',
        'ditolak' => 'Ditolak',
        'direvisi' => 'Perlu Revisi',
        'draft' => 'Draft',
        'diproses' => 'Sedang Diproses',
    ][$review['status'] ?? ''] ?? ucfirst(str_replace('_', ' ', $review['status'] ?? 'Belum diketahui'));

    $statusClass = match ($review['status'] ?? '') {
        'diterima' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'ditolak' => 'bg-rose-50 text-rose-700 ring-rose-200',
        'direvisi' => 'bg-orange-50 text-orange-800 ring-orange-200',
        'menunggu_review' => 'bg-amber-50 text-amber-800 ring-amber-200',
        'diproses' => 'bg-blue-50 text-blue-700 ring-blue-200',
        default => 'bg-slate-100 text-slate-700 ring-slate-200',
    };

    $formatStars = fn ($n) => $n ? str_repeat('★', (int) $n) : '—';
@endphp

<div class="space-y-6" id="reviewPage">
    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
        <a href="{{ url('/verifikator/dashboard') }}" class="inline-flex items-center gap-1.5 font-medium text-[#7b211e] hover:underline">
            <span aria-hidden="true">←</span> Kembali ke Dashboard
        </a>
        <span>/</span>
        <span>Detail Review</span>
        <span>/</span>
        <span class="font-medium text-slate-700">{{ $review['kode'] }}</span>
    </div>

    {{-- Header pengajuan --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-gradient-to-r from-[#78231f] to-[#963b34] px-6 py-6 text-white sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div class="max-w-3xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-red-100">Detail Pengajuan · {{ $review['kode'] }}</p>
                    <h1 class="mt-2 break-words text-2xl font-bold leading-tight sm:text-3xl">{{ $review['judul'] }}</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-red-50">{{ $review['deskripsi'] ?: 'Tidak ada deskripsi pengajuan.' }}</p>
                </div>
                <span class="inline-flex items-center rounded-full px-4 py-2 text-xs font-semibold ring-1 {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-2 sm:px-8 lg:grid-cols-4">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Perangkat Daerah</p>
                <p class="mt-1 text-sm font-semibold text-slate-800">{{ $review['opd'] }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Diajukan oleh</p>
                <p class="mt-1 text-sm font-semibold text-slate-800">{{ $review['diajukan_oleh'] }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Kategori</p>
                <p class="mt-1 text-sm font-semibold text-slate-800">{{ $review['kategori'] ?: '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Tanggal Pengajuan</p>
                <p class="mt-1 text-sm font-semibold text-slate-800">{{ $review['submitted_at'] ?: '—' }}</p>
            </div>
        </div>
    </section>

    {{-- Informasi AI --}}
    <section class="rounded-xl border border-blue-200 bg-blue-50/70 p-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-700">i</div>
                <div>
                    <p class="text-sm font-semibold text-blue-900">AI hanya memberikan rekomendasi</p>
                    <p class="mt-0.5 text-sm leading-relaxed text-blue-800">Periksa bukti yang diunggah. Nilai bintang final tetap ditentukan oleh Anda sebagai Verifikator.</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:max-w-[390px]">
                <button type="button" id="btnJalankanAI" class="rounded-lg border border-blue-200 bg-white px-3 py-2 text-sm font-semibold text-blue-800 hover:bg-blue-100">
                    ↻ Jalankan Analisis AI
                </button>
                <button type="button" id="btnTentangAI" class="rounded-lg border border-blue-200 bg-white px-3 py-2 text-sm font-semibold text-blue-800 hover:bg-blue-100">
                    Tentang Analisis AI
                </button>
                <button type="button" id="btnMintaRevisi" class="rounded-lg border border-[#7b211e] bg-white px-3 py-2 text-sm font-semibold text-[#7b211e] hover:bg-red-50">
                    Minta Revisi
                </button>
            </div>
        </div>
        <div id="infoAI" hidden class="mt-4 rounded-lg border border-blue-200 bg-white p-3 text-sm text-slate-600">
            Rekomendasi AI membantu proses pemeriksaan, tetapi tidak menggantikan penilaian manusia. Verifikator perlu mempertimbangkan kesesuaian dokumen, kelengkapan bukti, dan konteks indikator.
        </div>
    </section>

    {{-- Ringkasan skor: berada di atas indikator dan tidak sticky --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5" aria-live="polite">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Skor Sementara</p>
                <p class="mt-1 text-2xl font-bold text-slate-900">
                    <span id="totalScore">0</span>
                    <span class="text-base font-medium text-slate-400">/ <span id="maxScore">0</span> poin</span>
                </p>
                <p class="mt-1 text-xs text-slate-500">
                    <span id="ratedCount">0</span> dari {{ count($review['per_indikator']) }} indikator sudah dinilai.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ url('/verifikator/dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Kembali ke Dashboard</a>
                <button type="button" id="btnSimpanKeputusan" class="rounded-lg bg-[#7b211e] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#641b18]">
                    Simpan Keputusan
                </button>
            </div>
        </div>
        <div class="mt-3 border-t border-slate-100 pt-3">
            <p class="text-xs leading-relaxed text-slate-400">Skor di atas merupakan pratinjau berdasarkan bobot dan nilai yang dipilih. Perhitungan serta penetapan predikat final harus dilakukan oleh backend berdasarkan aturan resmi.</p>
        </div>
    </section>

    {{-- Penilaian per indikator --}}
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Penilaian per Indikator</h2>
            <p class="mt-1 text-sm text-slate-500">Bandingkan klaim inovator, bukti dokumen, dan usulan AI sebelum menentukan nilai final.</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-500">
            Skala penilaian: <strong class="text-slate-700">1–3 bintang</strong>
        </div>
    </div>

    <div class="space-y-4">
        @forelse ($review['per_indikator'] as $index => $item)
            @php
                $aiLlm = collect($item['usulan_ai'] ?? [])->firstWhere('mesin', 'llm');
                $aiRules = collect($item['usulan_ai'] ?? [])->firstWhere('mesin', 'rules');
                $confidence = isset($aiLlm['keyakinan']) ? (float) $aiLlm['keyakinan'] : null;
                $confidenceLow = $confidence !== null && $confidence > 0 && $confidence < 0.5;
                $confidenceClass = !$aiLlm
                    ? 'bg-slate-100 text-slate-600'
                    : (($aiLlm['usulan_bintang'] ?? null) === null
                        ? 'bg-rose-50 text-rose-700 ring-rose-200'
                        : ($confidenceLow ? 'bg-amber-50 text-amber-800 ring-amber-200' : 'bg-emerald-50 text-emerald-700 ring-emerald-200'));
                // Nilai final hanya diisi jika sudah ada keputusan tersimpan. Tidak mengikuti usulan AI.
                $initialValue = $item['keputusan']['bintang_final'] ?? null;
            @endphp

            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-start sm:justify-between sm:px-6">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-bold text-slate-400">INDIKATOR {{ str_pad($item['indicator_kode'], 2, '0', STR_PAD_LEFT) }}</span>
                            @if ($item['wajib'])
                                <span class="rounded-full bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 ring-1 ring-rose-100">Wajib</span>
                            @else
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-medium text-slate-600">Tidak wajib</span>
                            @endif
                        </div>
                        <h3 class="mt-1 text-base font-bold text-slate-900">{{ $item['indicator_nama'] }}</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Bobot <strong class="text-slate-700">{{ $item['bobot'] }}</strong>
                            <span class="mx-1 text-slate-300">·</span>
                            Klaim inovator:
                            <strong class="text-amber-600">{{ $formatStars($item['bintang_diklaim'] ?? null) }}</strong>
                            @if (!empty($item['tier_label']))
                                <span class="text-slate-400">({{ $item['tier_label'] }})</span>
                            @endif
                        </p>
                    </div>

                    <fieldset class="shrink-0">
                        <legend class="mb-1.5 text-xs font-semibold text-slate-500">Nilai final verifikator</legend>
                        <div class="inline-flex w-full rounded-xl bg-slate-100 p-1 sm:w-auto" role="group" aria-label="Pilih nilai final">
                            @foreach ([1, 2, 3] as $star)
                                <label class="cursor-pointer">
                                    <input
                                        type="radio"
                                        name="nilai_{{ $item['indicator_kode'] }}"
                                        value="{{ $star }}"
                                        data-indicator-code="{{ $item['indicator_kode'] }}"
                                        data-weight="{{ $item['bobot'] }}"
                                        class="score-radio peer sr-only"
                                        @checked((int) $initialValue === $star)
                                    >
                                    <span class="inline-flex min-h-11 min-w-0 w-full items-center justify-center rounded-lg px-4 py-2 text-sm font-bold text-slate-600 transition hover:bg-white peer-checked:bg-[#7b211e] peer-checked:text-white peer-checked:shadow">
                                        {{ $star }}★
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                </div>

                <div class="grid grid-cols-1 gap-4 p-4 sm:p-6 lg:grid-cols-2">
                    {{-- Bukti dokumen --}}
                    <section class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h4 class="text-xs font-bold uppercase tracking-wide text-slate-600">Bukti yang Diunggah</h4>
                            <span class="rounded-full bg-white px-2 py-1 text-xs font-semibold text-slate-500 ring-1 ring-slate-200">{{ count($item['evidences'] ?? []) }} berkas</span>
                        </div>

                        @if (count($item['evidences'] ?? []) > 0)
                            <ul class="mt-3 space-y-2">
                                @foreach ($item['evidences'] as $evidence)
                                    <li class="flex flex-col gap-3 rounded-lg border border-slate-200 bg-white p-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="flex min-w-0 items-start gap-2.5">
                                            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50 text-xs font-bold text-[#7b211e]">PDF</div>
                                            <div class="min-w-0">
                                                <p class="break-words text-sm font-semibold text-slate-700">{{ $evidence['nama_asli'] }}</p>
                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $evidence['ukuran_label'] ?? 'Ukuran tidak diketahui' }}
                                                    @if (!empty($evidence['tahun_dokumen']))
                                                        <span class="mx-1">·</span>{{ $evidence['tahun_dokumen'] }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        @if (!empty($evidence['url']) && $evidence['url'] !== '#')
                                            <a href="{{ $evidence['url'] }}" target="_blank" rel="noopener"
                                                class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-[#7b211e] hover:bg-red-50 sm:w-auto sm:shrink-0">
                                                Lihat Dokumen
                                            </a>
                                        @else
                                            <button type="button" disabled
                                                class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-400 sm:w-auto sm:shrink-0">
                                                Pratinjau belum tersedia
                                            </button>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="mt-3 rounded-lg border border-dashed border-amber-300 bg-amber-50 p-4">
                                <p class="text-sm font-semibold text-amber-800">Belum ada bukti dokumen</p>
                                <p class="mt-1 text-xs leading-relaxed text-amber-700">Indikator ini belum memiliki berkas pendukung yang diunggah.</p>
                            </div>
                        @endif
                    </section>

                    {{-- Usulan AI --}}
                    <section class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="flex items-center gap-2 text-xs font-bold uppercase tracking-wide text-slate-600">
                                <span class="text-base text-violet-600">✦</span> Usulan AI
                            </h4>
                            <span class="rounded-full bg-violet-50 px-2 py-1 text-[11px] font-semibold text-violet-700">Pendukung</span>
                        </div>

                        @if (!$aiLlm && !$aiRules)
                            <div class="mt-3 rounded-lg border border-dashed border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-medium text-slate-600">Analisis AI belum tersedia</p>
                                <p class="mt-1 text-xs leading-relaxed text-slate-400">Belum ada hasil analisis untuk indikator ini.</p>
                            </div>
                        @else
                            <div class="mt-3 space-y-3">
                                @if ($aiLlm)
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $confidenceClass }}">
                                            @if (($aiLlm['usulan_bintang'] ?? null) !== null)
                                                Usulan {{ $formatStars($aiLlm['usulan_bintang']) }}
                                            @else
                                                Tidak dapat dinilai
                                            @endif
                                        </span>
                                        @if ($confidence !== null && $confidence > 0)
                                            <span class="text-xs text-slate-500">Keyakinan {{ round($confidence * 100) }}%</span>
                                        @endif
                                    </div>
                                    @if (!empty($aiLlm['ringkasan']))
                                        <p class="text-sm leading-relaxed text-slate-600">{{ $aiLlm['ringkasan'] }}</p>
                                    @endif
                                    @if ($confidenceLow)
                                        <p class="rounded-lg bg-amber-50 px-3 py-2 text-xs leading-relaxed text-amber-800">Keyakinan AI relatif rendah. Periksa bukti secara mandiri sebelum menentukan nilai.</p>
                                    @endif
                                @endif
                                @if ($aiRules && !empty($aiRules['ringkasan']))
                                    <div class="border-t border-slate-100 pt-3">
                                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Pemeriksaan berbasis aturan</p>
                                        <p class="mt-1 text-xs leading-relaxed text-slate-500">{{ $aiRules['ringkasan'] }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </section>
                </div>

                {{-- Catatan per indikator --}}
                <div class="px-5 pb-5 sm:px-6 sm:pb-6">
                    <label for="catatan_{{ $item['indicator_kode'] }}" class="mb-1.5 block text-xs font-semibold text-slate-600">Catatan Verifikator <span class="font-normal text-slate-400">(opsional)</span></label>
                    <textarea
                        id="catatan_{{ $item['indicator_kode'] }}"
                        name="catatan[{{ $item['indicator_kode'] }}]"
                        rows="2"
                        class="review-note w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#9b514b] focus:ring-2 focus:ring-red-100"
                        placeholder="Tuliskan alasan atau catatan penilaian untuk indikator ini..."
                    >{{ $item['keputusan']['catatan'] ?? '' }}</textarea>
                    @if (empty($item['evidences']) && !empty($item['wajib']))
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-rose-600">
                            <span aria-hidden="true">!</span> Indikator wajib belum memiliki bukti. Pertimbangkan meminta revisi.
                        </p>
                    @endif
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center">
                <p class="font-semibold text-slate-700">Belum ada indikator penilaian</p>
                <p class="mt-1 text-sm text-slate-500">Data indikator untuk pengajuan ini belum tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- Tombol keputusan di bagian bawah --}}
    <div class="flex flex-wrap justify-end gap-2 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <a href="{{ url('/verifikator/dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Kembali ke Dashboard</a>
        <button type="button" id="btnSimpanKeputusanBawah" class="rounded-lg bg-[#7b211e] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#641b18]">
            Simpan Keputusan
        </button>
    </div>
</div>

{{-- Dialog Minta Revisi --}}
<dialog id="modalRevisi" class="m-auto w-[calc(100%-2rem)] max-w-lg rounded-2xl p-0 shadow-2xl backdrop:bg-slate-950/50">
    <div class="p-6">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Minta Revisi Dokumen</h3>
                <p class="mt-1 text-sm text-slate-500">Jelaskan bagian yang perlu diperbaiki oleh inovator.</p>
            </div>
            <button type="button" id="btnTutupRevisiX" class="rounded-lg px-2 py-1 text-slate-400 hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup">✕</button>
        </div>
        <label for="catatanRevisi" class="mt-4 mb-1.5 block text-xs font-semibold text-slate-600">Catatan revisi</label>
        <textarea id="catatanRevisi" rows="5" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-[#9b514b] focus:ring-2 focus:ring-red-100" placeholder="Contoh: Mohon unggah ulang SK Tim Pelaksana dengan kualitas dokumen yang lebih jelas."></textarea>
        <p id="pesanValidasiRevisi" class="mt-1 text-xs text-slate-400">Minimal 5 karakter.</p>
        <div class="mt-5 flex justify-end gap-2">
            <button type="button" id="btnBatalRevisi" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
            <button type="button" id="btnKirimRevisi" class="rounded-lg bg-[#7b211e] px-4 py-2 text-sm font-semibold text-white hover:bg-[#641b18] disabled:cursor-not-allowed disabled:opacity-40">Kirim Permintaan</button>
        </div>
    </div>
</dialog>

{{-- Dialog Konfirmasi Keputusan --}}
<dialog id="modalKonfirmasi" class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl p-0 shadow-2xl backdrop:bg-slate-950/50">
    <div class="p-6">
        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-amber-50 text-xl text-amber-700">?</div>
        <h3 class="mt-4 text-lg font-bold text-slate-900">Periksa kembali keputusan</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">Pastikan nilai final setiap indikator sudah sesuai dengan bukti. Pada tahap pratinjau ini, keputusan belum dikirim atau disimpan ke database.</p>
        <div class="mt-5 flex justify-end gap-2">
            <button type="button" id="btnPeriksaLagi" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Periksa Lagi</button>
            <button type="button" id="btnKonfirmasiSimpan" class="rounded-lg bg-[#7b211e] px-4 py-2 text-sm font-semibold text-white hover:bg-[#641b18]">Ya, Lanjutkan</button>
        </div>
    </div>
</dialog>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalRevisi = document.getElementById('modalRevisi');
    const modalKonfirmasi = document.getElementById('modalKonfirmasi');
    const catatanRevisi = document.getElementById('catatanRevisi');
    const btnKirimRevisi = document.getElementById('btnKirimRevisi');
    const pesanValidasiRevisi = document.getElementById('pesanValidasiRevisi');

    // Informasi AI
    const btnTentangAI = document.getElementById('btnTentangAI');
    const infoAI = document.getElementById('infoAI');

    btnTentangAI?.addEventListener('click', function () {
        infoAI.hidden = !infoAI.hidden;
        btnTentangAI.setAttribute('aria-expanded', String(!infoAI.hidden));
    });

    document.getElementById('btnJalankanAI')?.addEventListener('click', function () {
        alert('Pratinjau desain: proses analisis AI akan dihubungkan ke backend setelah endpoint disepakati.');
    });

    // Dialog Minta Revisi
    document.getElementById('btnMintaRevisi')?.addEventListener('click', function () {
        modalRevisi.showModal();
        catatanRevisi.focus();
    });

    document.getElementById('btnTutupRevisiX')?.addEventListener('click', function () {
        modalRevisi.close();
    });

    document.getElementById('btnBatalRevisi')?.addEventListener('click', function () {
        modalRevisi.close();
    });

    catatanRevisi?.addEventListener('input', function () {
        const valid = catatanRevisi.value.trim().length >= 5;
        btnKirimRevisi.disabled = !valid;
        pesanValidasiRevisi.textContent = valid
            ? 'Catatan sudah memenuhi panjang minimum.'
            : 'Minimal 5 karakter.';
        pesanValidasiRevisi.classList.toggle('text-emerald-600', valid);
        pesanValidasiRevisi.classList.toggle('text-slate-400', !valid);
    });

    btnKirimRevisi?.addEventListener('click', function () {
        if (catatanRevisi.value.trim().length < 5) {
            catatanRevisi.focus();
            return;
        }

        alert('Pratinjau desain: endpoint pengiriman permintaan revisi belum dihubungkan.');
        modalRevisi.close();
    });

    // Perhitungan skor: nilai final tidak otomatis mengikuti rekomendasi AI.
    const scoreRadios = document.querySelectorAll('.score-radio');
    const totalScoreElement = document.getElementById('totalScore');
    const maxScoreElement = document.getElementById('maxScore');
    const ratedCountElement = document.getElementById('ratedCount');

    function updateScore() {
        let total = 0;
        let max = 0;
        let rated = 0;
        const indicators = new Map();

        scoreRadios.forEach(function (radio) {
            const code = radio.dataset.indicatorCode;
            const weight = Number(radio.dataset.weight || 0);

            if (!indicators.has(code)) {
                indicators.set(code, { weight: weight, selected: null });
            }

            if (radio.checked) {
                indicators.get(code).selected = Number(radio.value);
            }
        });

        indicators.forEach(function (indicator) {
            max += indicator.weight * 3;

            if (indicator.selected !== null) {
                total += indicator.weight * indicator.selected;
                rated += 1;
            }
        });

        totalScoreElement.textContent = total;
        maxScoreElement.textContent = max;
        ratedCountElement.textContent = rated;
    }

    scoreRadios.forEach(function (radio) {
        radio.addEventListener('change', updateScore);
    });

    updateScore();

    // Dialog konfirmasi keputusan
    function openConfirmation() {
        modalKonfirmasi.showModal();
    }

    document.getElementById('btnSimpanKeputusan')?.addEventListener('click', openConfirmation);
    document.getElementById('btnSimpanKeputusanBawah')?.addEventListener('click', openConfirmation);

    document.getElementById('btnPeriksaLagi')?.addEventListener('click', function () {
        modalKonfirmasi.close();
    });

    document.getElementById('btnKonfirmasiSimpan')?.addEventListener('click', function () {
        modalKonfirmasi.close();
        alert('Pratinjau desain: endpoint penyimpanan keputusan belum dihubungkan.');
    });

    // Klik area backdrop untuk menutup dialog.
    [modalRevisi, modalKonfirmasi].forEach(function (dialog) {
        dialog?.addEventListener('click', function (event) {
            if (event.target === dialog) {
                dialog.close();
            }
        });
    });
});
</script>
@endsection
