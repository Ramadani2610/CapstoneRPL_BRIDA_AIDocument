<header class="sticky top-0 z-30 h-16 shrink-0 border-b border-slate-200 bg-white">
    <div class="flex h-full items-center justify-between px-4 sm:px-5 lg:px-8">

    {{-- Kiri --}}
    <div class="flex min-w-0 items-center gap-3 sm:gap-4">

        {{-- Tombol Menu Mobile --}}
        <button
            id="mobileMenuButton"
            type="button"
            onclick="toggleSidebar()"
            aria-label="Buka menu"
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-slate-600 transition hover:bg-[#FDF2F2] hover:text-[#7a161a] lg:hidden"
        >
            {{-- Hamburger --}}
            <svg
                id="menuOpenIcon"
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>

            {{-- Close --}}
            <svg
                id="menuCloseIcon"
                class="hidden h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 6l12 12M18 6L6 18"
                />
            </svg>
        </button>

        {{-- Logo kecil --}}
        <img
            src="{{ asset('images/logo-brida.png') }}"
            alt="SIGAP Inovasi"
            class="h-8 w-auto sm:h-9"
        >

        <div class="hidden h-6 w-px bg-slate-200 sm:block"></div>

        <span class="hidden text-sm font-medium text-slate-500 sm:block">
            Sistem Informasi SIGAP Inovasi
        </span>
    </div>

    {{-- Kanan --}}
    <div class="flex shrink-0 items-center gap-2 sm:gap-3">

        {{-- Role --}}
        <div class="hidden rounded-full bg-[#FDF2F2] px-3 py-1.5 text-xs font-semibold text-[#7a161a] sm:block">
            Verifikator
        </div>

        {{-- Notification --}}
        <button
            type="button"
            class="relative flex h-10 w-10 items-center justify-center rounded-full text-slate-500 transition hover:bg-[#FDF2F2] hover:text-[#7a161a]"
            title="Notifikasi"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M15 17h5l-1.5-1.5A2 2 0 0118 14v-3a6 6 0 00-12 0v3a2 2 0 01-.5 1.5L4 17h5m6 0a3 3 0 01-6 0"
                />
            </svg>

            <span class="absolute right-1.5 top-1.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-[#7a161a] px-1 text-[9px] font-bold text-white">
                2
            </span>
        </button>

        {{-- Profile --}}
        <button
            type="button"
            onclick="window.location.href='#'"
            class="flex h-10 w-10 items-center justify-center rounded-full bg-[#7a161a] text-sm font-bold text-white transition hover:bg-[#5a1013]"
            title="Profil"
        >
            NH
        </button>

    </div>
</div>

</header>
