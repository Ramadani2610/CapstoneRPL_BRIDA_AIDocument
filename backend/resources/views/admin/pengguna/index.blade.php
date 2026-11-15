@extends('layouts.admin')

@section('title', 'Manajemen Pengguna — Admin')

@php
    $roleBadge = [
        'admin' => 'bg-rose-50 text-rose-700',
        'verifikator' => 'bg-amber-50 text-amber-700',
        'inovator' => 'bg-sky-50 text-sky-700',
    ];
@endphp

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
        <span class="text-slate-700">Manajemen Pengguna</span>
    </nav>

    {{-- Heading --}}
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Kelola Akun Pengguna</h1>
            <p class="mt-1 text-sm text-slate-500">
                Atur akses inovator perangkat daerah, verifikator BRIDA, dan administrator sistem.
            </p>
        </div>

        <span
            class="inline-flex cursor-not-allowed items-center gap-2 rounded-lg bg-slate-200 px-4 py-2 text-sm font-medium text-slate-500 opacity-60"
            title="Coming soon — tambah pengguna belum tersedia"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengguna
        </span>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white">

        {{-- Tabs + Search --}}
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 px-5 py-4">

            <div class="flex flex-wrap gap-2">
                @foreach (['semua' => 'Semua', 'admin' => 'Administrator', 'verifikator' => 'Verifikator', 'inovator' => 'Inovator'] as $key => $label)
                    <button
                        type="button"
                        data-tab="{{ $key }}"
                        onclick="setRoleFilter('{{ $key }}')"
                        class="role-tab rounded-full px-3 py-1.5 text-sm font-medium transition {{ $key === 'semua' ? 'bg-[#7a161a] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        {{ $label }}
                        <span class="ml-1.5 text-xs opacity-80">{{ $count_per_role[$key] }}</span>
                    </button>
                @endforeach
            </div>

            <div class="relative w-full sm:w-72">
                <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7" stroke-width="1.8"/>
                    <path d="M21 21l-4.35-4.35" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <input
                    id="userSearch"
                    type="text"
                    oninput="applyFilter()"
                    placeholder="Cari nama, email, atau instansi"
                    class="w-full rounded-lg border border-slate-200 bg-white py-2 pl-9 pr-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-[#7a161a] focus:outline-none focus:ring-1 focus:ring-[#7a161a]"
                />
            </div>

        </div>

        {{-- Table desktop --}}
        <div class="hidden overflow-x-auto lg:block">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3">Pengguna</th>
                        <th class="px-5 py-3">Instansi</th>
                        <th class="px-5 py-3">Peran</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Login Terakhir</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @foreach ($users as $user)
                        @php $search = strtolower($user->name . ' ' . $user->email . ' ' . $user->instansi); @endphp
                        <tr class="user-row border-b border-slate-50 last:border-0" data-role="{{ $user->role }}" data-search="{{ $search }}">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-200 text-xs font-semibold text-slate-700">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-800">{{ $user->name }}</p>
                                        <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-slate-700">{{ $user->instansi }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $roleBadge[$user->role] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <form method="POST" action="{{ route('admin.pengguna.toggle-status', $user->id) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 text-xs font-medium"
                                        aria-label="Toggle status {{ $user->name }}"
                                    >
                                        <span class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full transition {{ $user->aktif ? 'bg-emerald-500' : 'bg-slate-300' }}">
                                            <span class="inline-block h-4 w-4 rounded-full bg-white shadow transition {{ $user->aktif ? 'translate-x-4' : 'translate-x-0.5' }}"></span>
                                        </span>
                                        <span class="{{ $user->aktif ? 'text-slate-700' : 'text-slate-400' }}">
                                            {{ $user->aktif ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-3 text-xs text-slate-500">
                                {{ $user->login_terakhir?->diffForHumans() ?? '—' }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <span
                                        class="cursor-not-allowed rounded-lg p-2 text-slate-300"
                                        title="Edit — Coming soon"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                    <span
                                        class="cursor-not-allowed rounded-lg p-2 text-slate-300"
                                        title="Hapus — Coming soon"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                        </svg>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Card mobile --}}
        <div id="userCardList" class="block space-y-3 p-4 lg:hidden">
            @foreach ($users as $user)
                @php $search = strtolower($user->name . ' ' . $user->email . ' ' . $user->instansi); @endphp
                <div class="user-card rounded-lg border border-slate-200 bg-white p-4 shadow-sm" data-role="{{ $user->role }}" data-search="{{ $search }}">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-200 text-xs font-semibold text-slate-700">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-slate-800">{{ $user->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $roleBadge[$user->role] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="min-w-0 truncate text-xs text-slate-600">{{ $user->instansi }}</span>
                    </div>

                    <div class="mt-3 flex flex-wrap items-center justify-between gap-2">
                        <form method="POST" action="{{ route('admin.pengguna.toggle-status', $user->id) }}">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 text-xs font-medium"
                            >
                                <span class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full transition {{ $user->aktif ? 'bg-emerald-500' : 'bg-slate-300' }}">
                                    <span class="inline-block h-4 w-4 rounded-full bg-white shadow transition {{ $user->aktif ? 'translate-x-4' : 'translate-x-0.5' }}"></span>
                                </span>
                                <span class="{{ $user->aktif ? 'text-slate-700' : 'text-slate-400' }}">
                                    {{ $user->aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </button>
                        </form>
                        <span class="text-xs text-slate-500">
                            Login: {{ $user->login_terakhir?->diffForHumans() ?? '—' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="userEmpty" class="hidden px-5 py-10 text-center text-sm text-slate-500">
            Tidak ada pengguna yang cocok.
        </div>

        <div class="border-t border-slate-100 px-5 py-3 text-xs text-slate-500">
            <span id="userCount">{{ $users->count() }}</span> dari {{ $users->count() }} pengguna
        </div>

    </div>

</div>

<script>
    let currentRole = 'semua';

    function setRoleFilter(role) {
        currentRole = role;
        document.querySelectorAll('.role-tab').forEach(function (btn) {
            const active = btn.dataset.tab === role;
            btn.classList.toggle('bg-[#7a161a]', active);
            btn.classList.toggle('text-white', active);
            btn.classList.toggle('bg-slate-100', !active);
            btn.classList.toggle('text-slate-600', !active);
        });
        applyFilter();
    }

    function applyFilter() {
        const q = (document.getElementById('userSearch').value || '').trim().toLowerCase();
        let count = 0;

        const apply = function (el) {
            const roleMatch = currentRole === 'semua' || el.dataset.role === currentRole;
            const searchMatch = !q || el.dataset.search.includes(q);
            const show = roleMatch && searchMatch;
            el.classList.toggle('hidden', !show);
            return show;
        };

        document.querySelectorAll('.user-row').forEach(function (row) {
            if (apply(row)) count++;
        });
        document.querySelectorAll('.user-card').forEach(apply);

        document.getElementById('userCount').textContent = count;
        document.getElementById('userEmpty').classList.toggle('hidden', count > 0);
    }
</script>
@endsection
