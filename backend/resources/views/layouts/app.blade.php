<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIGAP Inovasi')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <div class="flex h-screen flex-col overflow-hidden">

        {{-- Topbar --}}
        @include('layouts.topbar')

        <div class="relative flex min-h-0 flex-1 overflow-hidden">

            {{-- Mobile Sidebar Overlay --}}
            <div
                id="sidebarOverlay"
                class="fixed inset-0 z-30 hidden bg-black/40 lg:hidden"
                onclick="closeSidebar()"
            ></div>

            {{-- Sidebar --}}
            @include('layouts.sidebar')

            {{-- Content halaman --}}
            <main class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

        </div>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const openIcon = document.getElementById('menuOpenIcon');
            const closeIcon = document.getElementById('menuCloseIcon');

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

        // Jika ukuran layar berubah dari mobile ke desktop,
        // pastikan state sidebar kembali normal.
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