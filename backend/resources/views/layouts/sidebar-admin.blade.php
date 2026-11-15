@php
    $userName = auth()->user()->name ?? 'Muh. Rizal Syam';
    $userInstansi = auth()->user()->instansi ?? 'BRIDA Kota Makassar';
    $words = preg_split('/\s+/', trim($userName));
    $initials = count($words) >= 2
        ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
        : strtoupper(substr($words[0] ?? 'A', 0, 2));
@endphp

<aside
    id="sidebar"
    class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 -translate-x-full flex-col border-r border-gray-200 bg-white transition-transform duration-300 ease-in-out lg:static lg:z-0 lg:h-full lg:translate-x-0"
>
    {{-- Logo BRIDA — mobile only (desktop logo di topbar) --}}
    <div class="flex h-20 shrink-0 items-center justify-center border-b border-gray-200 px-6 lg:hidden">
        {{-- FIXME: logo-brida.png di-add rekan via feat/blade-backend; fallback ke text saat belum merged. --}}
        <img
            src="{{ asset('images/logo-brida.png') }}"
            alt="Logo BRIDA"
            class="h-10 w-auto object-contain"
            onerror="this.style.display='none'; this.nextElementSibling?.classList.remove('hidden');"
        >
        <span class="hidden rounded-md bg-[#7a161a] px-3 py-1.5 text-sm font-bold text-white">BRIDA</span>
    </div>

    {{-- Menu (flat, tanpa heading grup) --}}
    <div class="flex-1 overflow-y-auto py-4">
        <nav class="flex flex-col gap-1 px-4">

            {{-- Dashboard --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex h-10 items-center gap-3 rounded-lg px-3 text-sm font-medium transition
                    {{ request()->is('admin/dashboard')
                        ? 'bg-[#7a161a] text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-[#7a161a]' }}"
            >
                <svg class="size-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="1.8" />
                    <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="1.8" />
                    <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="1.8" />
                    <rect x="14" y="14" width="7" height="7" rx="1" stroke-width="1.8" />
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- Indikator & Parameter --}}
            <a
                href="{{ route('admin.indikator.index') }}"
                class="flex h-10 items-center gap-3 rounded-lg px-3 text-sm font-medium transition
                    {{ request()->is('admin/indikator*')
                        ? 'bg-[#7a161a] text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-[#7a161a]' }}"
            >
                <svg class="size-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5h18M6 12h12M10 19h4"/>
                </svg>
                <span>Indikator &amp; Parameter</span>
            </a>

            {{-- FIXME: route('verifikator.antrian-review') setelah merge --}}
            <a
                href="#"
                onclick="alert('Halaman milik tim Verifikator — akan aktif setelah merge'); return false;"
                class="flex h-10 items-center gap-3 rounded-lg px-3 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-[#7a161a]"
            >
                <svg class="size-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5h6m-7 0a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 11h6M9 15h4"/>
                </svg>
                <span>Antrian Review</span>
            </a>

            {{-- FIXME: route('verifikator.gagal-diproses') setelah merge --}}
            <a
                href="#"
                onclick="alert('Halaman milik tim Verifikator — akan aktif setelah merge'); return false;"
                class="flex h-10 items-center gap-3 rounded-lg px-3 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-[#7a161a]"
            >
                <svg class="size-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4M12 16h.01"/>
                </svg>
                <span>Gagal Diproses</span>
            </a>

            {{-- FIXME: route('verifikator.riwayat-audit') setelah merge --}}
            <a
                href="#"
                onclick="alert('Halaman milik tim Verifikator — akan aktif setelah merge'); return false;"
                class="flex h-10 items-center gap-3 rounded-lg px-3 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-[#7a161a]"
            >
                <svg class="size-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v6h6M8 13h8M8 17h5"/>
                </svg>
                <span>Riwayat Audit</span>
            </a>

            {{-- Manajemen Pengguna --}}
            <a
                href="{{ route('admin.pengguna.index') }}"
                class="flex h-10 items-center gap-3 rounded-lg px-3 text-sm font-medium transition
                    {{ request()->is('admin/pengguna*')
                        ? 'bg-[#7a161a] text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-[#7a161a]' }}"
            >
                <svg class="size-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="9" cy="8" r="3.5" stroke-width="1.8" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 20c0-3.314 2.686-6 6-6s6 2.686 6 6"/>
                    <circle cx="17" cy="9" r="2.5" stroke-width="1.8" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 19c0-2.21-1.79-4-4-4"/>
                </svg>
                <span>Manajemen Pengguna</span>
            </a>

        </nav>
    </div>

    {{-- Profil & Logout --}}
    <div class="shrink-0 border-t border-gray-200 bg-gray-50 p-4">
        <div class="flex flex-col gap-4">

            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#7a161a] text-sm font-bold text-white shadow-sm">
                    {{ $initials }}
                </div>
                <div class="min-w-0 flex-1 leading-tight">
                    <p class="truncate text-sm font-semibold text-gray-900">{{ $userName }}</p>
                    <p class="truncate text-xs text-gray-500">{{ $userInstansi }}</p>
                </div>
            </div>

            <button
                type="button"
                onclick="showLogoutModal()"
                class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-[#7a161a] bg-white px-4 py-2 text-sm font-medium text-[#7a161a] shadow-sm transition-all hover:bg-[#7a161a] hover:text-white"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12H3m0 0l4-4m-4 4l4 4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 4h4a2 2 0 012 2v12a2 2 0 01-2 2h-4"/>
                </svg>
                <span>Keluar</span>
            </button>

        </div>
    </div>
</aside>

{{-- Logout Modal --}}
<div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-xl">
        <h3 class="mb-2 text-lg font-bold text-gray-900">Konfirmasi Keluar</h3>
        <p class="mb-6 text-sm text-gray-600">
            Apakah Anda yakin ingin keluar dari sesi aplikasi SIGAP Inovasi?
        </p>
        <div class="flex items-center justify-end gap-3">
            <button
                type="button"
                onclick="hideLogoutModal()"
                class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100"
            >
                Batal
            </button>
            <button
                type="button"
                onclick="hideLogoutModal()"
                class="cursor-pointer rounded-lg bg-[#7a161a] px-4 py-2 text-sm font-semibold text-white shadow-md transition-colors hover:bg-[#5a1013]"
            >
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<script>
    function showLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function hideLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
