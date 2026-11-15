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
        <span class="text-slate-700">Kelola Pengguna</span>
    </nav>

    {{-- Heading --}}
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Kelola Akun Pengguna</h1>
            <p class="mt-1 text-sm text-slate-500">
                Atur akses inovator perangkat daerah, verifikator BRIDA, dan administrator sistem.
            </p>
        </div>

        <button
            type="button"
            onclick="openUserFormModal('tambah')"
            class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#7a161a] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#5a1013]"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengguna
        </button>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <p class="font-semibold">Form tidak valid:</p>
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                        class="role-tab cursor-pointer rounded-full px-3 py-1.5 text-sm font-medium transition {{ $key === 'semua' ? 'bg-[#7a161a] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
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
                                    {{ $role_options[$user->role] ?? ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <form method="POST" action="{{ route('admin.pengguna.toggle-status', $user->id) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex cursor-pointer items-center gap-2 text-xs font-medium"
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
                                    <button
                                        type="button"
                                        onclick='openUserFormModal("edit", @json($user))'
                                        class="cursor-pointer rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                                        aria-label="Edit {{ $user->name }}"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"/>
                                        </svg>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal({{ $user->id }}, @js($user->name))"
                                        class="cursor-pointer rounded-lg p-2 text-slate-500 transition hover:bg-rose-50 hover:text-rose-700"
                                        aria-label="Hapus {{ $user->name }}"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                        </svg>
                                    </button>
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
                            {{ $role_options[$user->role] ?? ucfirst($user->role) }}
                        </span>
                        <span class="min-w-0 truncate text-xs text-slate-600">{{ $user->instansi }}</span>
                    </div>

                    <div class="mt-3 flex flex-wrap items-center justify-between gap-2">
                        <form method="POST" action="{{ route('admin.pengguna.toggle-status', $user->id) }}">
                            @csrf
                            <button type="submit" class="inline-flex cursor-pointer items-center gap-2 text-xs font-medium">
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

                    <div class="mt-3 flex items-center justify-end gap-1 border-t border-slate-100 pt-2">
                        <button
                            type="button"
                            onclick='openUserFormModal("edit", @json($user))'
                            class="cursor-pointer rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                            aria-label="Edit {{ $user->name }}"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"/>
                            </svg>
                        </button>
                        <button
                            type="button"
                            onclick="openDeleteModal({{ $user->id }}, @js($user->name))"
                            class="cursor-pointer rounded-lg p-2 text-slate-500 transition hover:bg-rose-50 hover:text-rose-700"
                            aria-label="Hapus {{ $user->name }}"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                            </svg>
                        </button>
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

{{-- ============================================================ --}}
{{-- Modal: Tambah / Edit Pengguna                                --}}
{{-- ============================================================ --}}
<div id="userFormModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">

        <div class="border-b border-slate-100 px-6 py-4">
            <h3 id="userFormTitle" class="text-lg font-bold text-slate-900">Tambah Pengguna</h3>
            <p id="userFormSubtitle" class="mt-1 text-sm text-slate-500">Undangan aktivasi akan dikirim ke email pengguna.</p>
        </div>

        <form id="userForm" method="POST" action="{{ route('admin.pengguna.store') }}" class="space-y-4 px-6 py-5">
            @csrf
            <input type="hidden" name="_method" id="userFormMethod" value="">

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">
                    Nama Lengkap<span class="ml-0.5 text-rose-600">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    id="userFormName"
                    required
                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 transition focus:border-[#7a161a] focus:outline-none focus:ring-1 focus:ring-[#7a161a]"
                >
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">
                    Email Dinas<span class="ml-0.5 text-rose-600">*</span>
                </label>
                <input
                    type="email"
                    name="email"
                    id="userFormEmail"
                    required
                    placeholder="nama@makassarkota.go.id"
                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 transition focus:border-[#7a161a] focus:outline-none focus:ring-1 focus:ring-[#7a161a]"
                >
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">
                    OPD / Instansi<span class="ml-0.5 text-rose-600">*</span>
                </label>
                <select
                    name="instansi"
                    id="userFormInstansi"
                    required
                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 transition focus:border-[#7a161a] focus:outline-none focus:ring-1 focus:ring-[#7a161a]"
                >
                    <option value="">— Pilih OPD / Instansi —</option>
                    @foreach ($opd_options as $opd)
                        <option value="{{ $opd }}">{{ $opd }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Peran</label>
                <select
                    name="role"
                    id="userFormRole"
                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 transition focus:border-[#7a161a] focus:outline-none focus:ring-1 focus:ring-[#7a161a]"
                >
                    <option value="inovator">Inovator</option>
                    <option value="verifikator">Verifikator</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                <div>
                    <p class="text-sm font-medium text-slate-700">Status Akun</p>
                    <p id="userFormAktifSubtext" class="text-xs text-slate-500">Aktif — pengguna dapat masuk.</p>
                </div>
                <label class="relative inline-flex cursor-pointer items-center">
                    <input type="checkbox" name="aktif" id="userFormAktif" value="1" checked class="peer sr-only">
                    <span class="relative inline-flex h-5 w-9 items-center rounded-full bg-slate-300 transition peer-checked:bg-emerald-500">
                        <span class="inline-block h-4 w-4 translate-x-0.5 rounded-full bg-white shadow transition peer-checked:translate-x-4"></span>
                    </span>
                </label>
            </div>

            <div class="-mx-6 -mb-5 flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button
                    type="button"
                    onclick="closeUserFormModal()"
                    class="cursor-pointer rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    id="userFormSubmit"
                    class="cursor-pointer rounded-lg bg-[#7a161a] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#5a1013]"
                >
                    Tambah Pengguna
                </button>
            </div>
        </form>

    </div>
</div>

{{-- ============================================================ --}}
{{-- Modal: Konfirmasi Hapus                                      --}}
{{-- ============================================================ --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-xl">
        <h3 id="deleteModalTitle" class="mb-2 text-lg font-bold text-slate-900">Hapus Pengguna?</h3>
        <p class="mb-6 text-sm text-slate-600">
            Akun akan dihapus permanen. Riwayat pengajuan dan log audit milik pengguna tetap tersimpan.
            Pertimbangkan menonaktifkan akun jika hanya ingin memblokir akses.
        </p>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end gap-3">
                <button
                    type="button"
                    onclick="closeDeleteModal()"
                    class="cursor-pointer rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="cursor-pointer rounded-lg bg-rose-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-800"
                >
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // ================= Filter & Search =================
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

    // ================= User Form Modal =================
    function openUserFormModal(mode, userData) {
        const modal = document.getElementById('userFormModal');
        const form = document.getElementById('userForm');
        const title = document.getElementById('userFormTitle');
        const subtitle = document.getElementById('userFormSubtitle');
        const methodInput = document.getElementById('userFormMethod');
        const submitBtn = document.getElementById('userFormSubmit');
        const aktifSub = document.getElementById('userFormAktifSubtext');

        if (mode === 'edit' && userData) {
            title.textContent = 'Edit Pengguna';
            subtitle.textContent = userData.email || '';
            submitBtn.textContent = 'Simpan Perubahan';
            form.action = '/admin/pengguna/' + userData.id;
            methodInput.value = 'PUT';
            document.getElementById('userFormName').value = userData.name || '';
            document.getElementById('userFormEmail').value = userData.email || '';
            document.getElementById('userFormInstansi').value = userData.instansi || '';
            document.getElementById('userFormRole').value = userData.role || 'inovator';
            document.getElementById('userFormAktif').checked = !!userData.aktif;
            aktifSub.textContent = userData.aktif ? 'Aktif — pengguna dapat masuk.' : 'Nonaktif — pengguna tidak dapat masuk.';
        } else {
            title.textContent = 'Tambah Pengguna';
            subtitle.textContent = 'Undangan aktivasi akan dikirim ke email pengguna.';
            submitBtn.textContent = 'Tambah Pengguna';
            form.action = '{{ route('admin.pengguna.store') }}';
            methodInput.value = '';
            form.reset();
            document.getElementById('userFormAktif').checked = true;
            aktifSub.textContent = 'Aktif — pengguna dapat masuk.';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeUserFormModal() {
        const modal = document.getElementById('userFormModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Sync subtitle on toggle inside modal
    document.addEventListener('DOMContentLoaded', function () {
        const aktif = document.getElementById('userFormAktif');
        const sub = document.getElementById('userFormAktifSubtext');
        if (aktif && sub) {
            aktif.addEventListener('change', function () {
                sub.textContent = aktif.checked
                    ? 'Aktif — pengguna dapat masuk.'
                    : 'Nonaktif — pengguna tidak dapat masuk.';
            });
        }
    });

    // ================= Delete Modal =================
    function openDeleteModal(id, name) {
        const modal = document.getElementById('deleteModal');
        const title = document.getElementById('deleteModalTitle');
        const form = document.getElementById('deleteForm');
        title.textContent = 'Hapus ' + name + '?';
        form.action = '/admin/pengguna/' + id;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection
