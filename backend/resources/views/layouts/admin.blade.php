@php
    $userName = auth()->user()->name ?? 'Admin';
    $words = preg_split('/\s+/', trim($userName));
    $initials = count($words) >= 2
        ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
        : strtoupper(substr($words[0] ?? 'A', 0, 2));
    $roleLabel = ucfirst(auth()->user()->role ?? 'admin');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIGAP Inovasi — Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <div class="flex h-screen flex-col overflow-hidden">

        {{-- Topbar --}}
        <header class="sticky top-0 z-50 h-16 shrink-0 border-b border-slate-200 bg-white">
            <div class="flex h-full items-center justify-between px-4 sm:px-5 lg:px-8">

                {{-- Kiri --}}
                <div class="flex min-w-0 items-center gap-3 sm:gap-4">

                    <button
                        id="mobileMenuButton"
                        type="button"
                        onclick="toggleSidebar()"
                        aria-label="Buka menu"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-slate-600 transition hover:bg-[#FDF2F2] hover:text-[#7a161a] lg:hidden"
                    >
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

                    {{-- FIXME: logo-brida.png di-add rekan via branch feat/blade-backend; fallback ke text saat belum merged. --}}
                    <img
                        src="{{ asset('images/logo-brida.png') }}"
                        alt="SIGAP Inovasi"
                        class="h-8 w-auto sm:h-9"
                        onerror="this.style.display='none'; this.nextElementSibling?.classList.remove('hidden');"
                    >
                    <span class="hidden rounded-md bg-[#7a161a] px-2.5 py-1 text-sm font-bold text-white">
                        SIGAP
                    </span>

                    <div class="hidden h-6 w-px bg-slate-200 sm:block"></div>

                    <span class="hidden text-sm font-medium text-slate-500 sm:block">
                        SIGAP Verifikasi Dokumen
                    </span>
                </div>

                {{-- Kanan --}}
                <div class="flex shrink-0 items-center gap-2 sm:gap-3">

                    <div class="hidden rounded-full bg-[#FDF2F2] px-3 py-1.5 text-xs font-semibold text-[#7a161a] sm:block">
                        {{ $roleLabel }}
                    </div>

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

                    <button
                        type="button"
                        onclick="window.location.href='#'"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-[#7a161a] text-sm font-bold text-white transition hover:bg-[#5a1013]"
                        title="Profil"
                    >
                        {{ $initials }}
                    </button>

                </div>
            </div>
        </header>

        {{-- Shell --}}
        <div class="relative flex min-h-0 flex-1 overflow-hidden">

            {{-- Mobile Sidebar Overlay --}}
            <div
                id="sidebarOverlay"
                class="fixed inset-0 z-30 hidden bg-black/40 lg:hidden"
                onclick="closeSidebar()"
            ></div>

            @include('layouts.sidebar-admin')

            <main class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

        </div>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');

            const isClosed = sidebar.classList.contains('-translate-x-full');

            if (isClosed) {
                openSidebar();
            } else {
                closeSidebar();
            }
        }

        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const openIcon = document.getElementById('menuOpenIcon');
            const closeIcon = document.getElementById('menuCloseIcon');

            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            openIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const openIcon = document.getElementById('menuOpenIcon');
            const closeIcon = document.getElementById('menuCloseIcon');

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            openIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Tutup sidebar setelah memilih menu di mobile.
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');

            if (!sidebar) return;

            sidebar.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });
        });

        // Jika layar berubah dari mobile ke desktop, pulihkan state sidebar.
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');

                if (sidebar) {
                    sidebar.classList.remove('-translate-x-full');
                }

                if (overlay) {
                    overlay.classList.add('hidden');
                }

                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>

</body>
</html>
