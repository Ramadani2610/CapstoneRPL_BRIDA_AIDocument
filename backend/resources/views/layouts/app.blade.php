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

        <div class="flex flex-1 overflow-hidden">

            {{-- Sidebar --}}
            @include('layouts.sidebar')

            {{-- Content halaman --}}
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                @yield('content')
            </main>

        </div>

    </div>

</body>
</html>