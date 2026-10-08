<aside
    id="sidebar"
    class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r border-slate-200 bg-white shadow-xl transition-transform duration-300 ease-in-out lg:static lg:z-auto lg:w-64 lg:shrink-0 lg:translate-x-0 lg:shadow-none"
>
    <div class="flex h-full flex-col">

    {{-- Logo --}}
    <div class="flex h-16 items-center border-b border-slate-200 px-5">
        <img
            src="{{ asset('images/logo-brida.png') }}"
            alt="SIGAP Inovasi"
            class="h-10 w-auto"
        >
    </div>

    {{-- Menu --}}
    <nav class="flex-1 overflow-y-auto p-4">
        <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
            Verifikator
        </p>

        <div class="space-y-1">
            {{-- Dashboard --}}
            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ request()->is('verifikator/dashboard')
                        ? 'bg-[#7a161a] text-white'
                        : 'text-slate-600 hover:bg-[#FDF2F2] hover:text-[#7a161a]' }}"
            >
                {{-- Dashboard / Grid --}}
                <svg
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <rect
                        x="3"
                        y="3"
                        width="7"
                        height="7"
                        rx="1"
                        stroke-width="1.8"
                    />
                    <rect
                        x="14"
                        y="3"
                        width="7"
                        height="7"
                        rx="1"
                        stroke-width="1.8"
                    />
                    <rect
                        x="3"
                        y="14"
                        width="7"
                        height="7"
                        rx="1"
                        stroke-width="1.8"
                    />
                    <rect
                        x="14"
                        y="14"
                        width="7"
                        height="7"
                        rx="1"
                        stroke-width="1.8"
                    />
                </svg>

                <span>Dashboard</span>
            </a>

            {{-- Antrian Review --}}
            <a
                href="{{ route('verifikator.antrian-review') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ request()->is('verifikator/antrian-review')
                        ? 'bg-[#7a161a] text-white'
                        : 'text-slate-600 hover:bg-[#FDF2F2] hover:text-[#7a161a]' }}"
            >
                {{-- Clipboard Check --}}
                <svg
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M9 5h6m-7 0a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2m-6 5l2 2 4-4"
                    />
                </svg>

                <span>Antrian Review</span>
            </a>

            {{-- Riwayat Audit --}}
            <a
                href="{{ route('verifikator.riwayat-audit') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ request()->is('verifikator/riwayat-audit')
                        ? 'bg-[#7a161a] text-white'
                        : 'text-slate-600 hover:bg-[#FDF2F2] hover:text-[#7a161a]' }}"
            >
                {{-- History / Clock --}}
                <svg
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke-width="1.8"
                    />
                    <path
                        d="M12 7v5l3 2"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

                <span>Riwayat Audit</span>
            </a>

        </div>

        <p class="mb-3 mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
            Lainnya
        </p>

        <div class="space-y-1">

            {{-- Profil --}}
            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-gray-100 hover:text-[#7a161a]"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M20 21a8 8 0 10-16 0"/>
                    <circle cx="12" cy="7" r="4" stroke-width="1.8"/>
                </svg>
                <span>Profil</span>
            </a>

        </div>
    </nav>

    {{-- Profile + Logout --}}
    <div class="border-t border-slate-200 p-4">

        <div class="mb-3 flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#7a161a] text-sm font-semibold text-white">
                NH
            </div>

            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-slate-800">
                    Nurul Hidayah
                </p>
                <p class="text-xs text-slate-500">
                    Verifikator
                </p>
            </div>
        </div>

        <button
            type="button"
            onclick="showLogoutModal()"
            class="flex w-full items-center justify-center gap-2 rounded-lg border border-[#7a161a] px-3 py-2 text-sm font-medium text-[#7a161a] transition hover:bg-[#7a161a] hover:text-white"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M15 12H3m0 0l4-4m-4 4l4 4"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M15 4h4a2 2 0 012 2v12a2 2 0 01-2 2h-4"/>
            </svg>
            Keluar
        </button>
    </div>
</div>

{{-- Logout Modal --}}
<div
    id="logoutModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
>
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

        <h2 class="text-lg font-semibold text-slate-900">
            Konfirmasi Keluar
        </h2>

        <p class="mt-2 text-sm leading-6 text-slate-600">
            Apakah Anda yakin ingin keluar dari sesi aplikasi SIGAP Inovasi?
        </p>

        <div class="mt-6 flex justify-end gap-3">
            <button
                type="button"
                onclick="hideLogoutModal()"
                class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Batal
            </button>

            <button
                type="button"
                onclick="hideLogoutModal()"
                class="rounded-lg bg-[#7a161a] px-4 py-2 text-sm font-medium text-white hover:bg-[#5a1013]"
            >
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

</aside>

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
