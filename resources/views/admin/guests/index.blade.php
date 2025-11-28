@extends('layouts.base')

@section('title', 'Review Buku Tamu')
@section('body-class', 'bg-emerald-50 text-slate-900 overflow-hidden')

@php
    $isGuests = request()->routeIs('admin.guests.*');
@endphp

@section('content')
    <div class="flex h-screen overflow-hidden bg-emerald-50 text-slate-900">
        <aside class="sticky top-0 hidden h-full w-72 shrink-0 flex-col border-r border-emerald-100 bg-white/90 px-6 py-8 shadow-md shadow-emerald-100 lg:flex">
            <div class="mb-8 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500 text-sm font-semibold text-white shadow-md shadow-emerald-200">
                    BT
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Buku Tamu</p>
                    <p class="text-base font-semibold text-slate-900">Admin Panel</p>
                </div>
            </div>
            <nav class="flex-1 space-y-1">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.15em] text-emerald-600">Navigasi</p>
                <a class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-700 transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-50"
                    href="{{ route('admin.dashboard') }}">
                    <span class="h-2 w-2 rounded-full bg-emerald-200"></span>
                    Dashboard
                </a>
                <a class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold {{ $isGuests ? 'text-emerald-700 ring-1 ring-emerald-300 bg-emerald-50' : 'text-slate-700 hover:bg-emerald-50' }} transition duration-300 hover:-translate-y-0.5"
                    href="{{ route('admin.guests.index') }}">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Kunjungan
                </a>
            </nav>
            <div class="mt-8 space-y-3 text-sm text-slate-700">
                <div class="flex items-center justify-between rounded-xl border border-emerald-100 bg-white px-4 py-3 shadow-sm">
                    <div>
                        <p class="text-xs text-emerald-600">Masuk sebagai</p>
                        <p class="font-semibold text-slate-900">{{ auth()->user()?->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()?->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-md shadow-emerald-200 transition hover:bg-emerald-400">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>
        <main class="flex-1 h-full overflow-hidden">
            <div class="flex h-full flex-col overflow-hidden">
                <div class="shrink-0 border-b border-emerald-100 bg-white/80 px-6 py-5 backdrop-blur">
                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Kunjungan</p>
                            <h1 class="text-2xl font-semibold text-slate-900">Review Buku Tamu</h1>
                            <p class="text-sm text-slate-600">Approve/reject pengajuan tamu dari halaman publik.</p>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-600">
                            <div class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 font-semibold text-amber-700">
                                Pending: {{ $pendingEntries->count() }}
                            </div>
                            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 font-semibold text-emerald-700">
                                Approved: {{ $approvedEntries->count() }}
                            </div>
                            <div class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 font-semibold text-rose-700">
                                Rejected: {{ $rejectedEntries->count() }}
                            </div>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="mt-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="flex-1 overflow-y-auto scrollbar-hidden">
                    <div class="space-y-8 px-6 py-8">
                        <div class="flex flex-col gap-3 rounded-2xl border border-emerald-100 bg-white px-4 py-3 shadow-sm shadow-emerald-100/60 md:flex-row md:items-center md:justify-between">
                            <form method="GET" class="flex flex-wrap items-center gap-2 text-sm text-slate-700">
                                <span class="font-semibold text-slate-800">Sortir</span>
                                <select name="sort" class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm"
                                    onchange="this.form.submit()">
                                    <option value="created_at" @selected($sort === 'created_at')>Tanggal dibuat</option>
                                    <option value="visit_date" @selected($sort === 'visit_date')>Tanggal kunjungan</option>
                                    <option value="name" @selected($sort === 'name')>Nama</option>
                                </select>
                                <select name="direction" class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm"
                                    onchange="this.form.submit()">
                                    <option value="desc" @selected($direction === 'desc')>Desc</option>
                                    <option value="asc" @selected($direction === 'asc')>Asc</option>
                                </select>
                                <noscript>
                                    <button type="submit" class="rounded-lg bg-emerald-500 px-3 py-2 text-white">Terapkan</button>
                                </noscript>
                            </form>
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('admin.guests.export.approved') }}"
                                    class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-400 hover:text-emerald-800">
                                    Export Approved (CSV)
                                </a>
                                <a href="{{ route('admin.guests.export.rejected') }}"
                                    class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-700 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-400 hover:text-rose-800">
                                    Export Rejected (CSV)
                                </a>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-lg shadow-emerald-100/60">
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.2em] text-amber-600">Pending</p>
                                    <p class="text-lg font-semibold text-slate-900">Menunggu persetujuan</p>
                                </div>
                            </div>
                            <div class="overflow-hidden rounded-2xl border border-emerald-100 bg-white">
                                <table class="min-w-full divide-y divide-emerald-100 text-sm">
                                    <thead class="bg-emerald-50 text-slate-600">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                            <th class="px-4 py-3 text-left font-semibold">Keperluan</th>
                                            <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                            <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-emerald-50 text-slate-800">
                                        @forelse ($pendingEntries as $entry)
                                            <tr>
                                                <td class="px-4 py-3 font-medium">{{ $entry->name }}</td>
                                                <td class="px-4 py-3 text-slate-600">{{ $entry->purpose }}</td>
                                                <td class="px-4 py-3 text-slate-600">{{ optional($entry->visit_date)->format('d M Y') ?? '—' }}</td>
                                                <td class="px-4 py-3 space-x-2">
                                                    <a href="{{ route('admin.guests.show', $entry) }}"
                                                        class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-400 hover:text-emerald-700">Lihat</a>
                                                    <form action="{{ route('admin.guests.approve', $entry) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="rounded-lg bg-emerald-500 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-emerald-400">
                                                            Approve
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.guests.reject', $entry) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="rounded-lg bg-rose-500 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-rose-400">
                                                            Reject
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.guests.destroy', $entry) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-400 hover:text-rose-700">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-6 text-center text-slate-500">Belum ada data pending.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-2">
                            <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-lg shadow-emerald-100/60">
                                <div class="mb-4 flex items-center justify-between">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Approved</p>
                                        <p class="text-lg font-semibold text-slate-900">Data disetujui</p>
                                    </div>
                                </div>
                                <div class="overflow-hidden rounded-2xl border border-emerald-100 bg-white">
                                    <table class="min-w-full divide-y divide-emerald-100 text-sm">
                                        <thead class="bg-emerald-50 text-slate-600">
                                            <tr>
                                                <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                                <th class="px-4 py-3 text-left font-semibold">Keperluan</th>
                                                <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-emerald-50 text-slate-800">
                                            @forelse ($approvedEntries as $entry)
                                                <tr>
                                                    <td class="px-4 py-3 font-medium">{{ $entry->name }}</td>
                                                    <td class="px-4 py-3 text-slate-600">{{ $entry->purpose }}</td>
                                                    <td class="px-4 py-3 space-x-2">
                                                        <a href="{{ route('admin.guests.show', $entry) }}"
                                                            class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-400 hover:text-emerald-700">Detail</a>
                                                        <form action="{{ route('admin.guests.destroy', $entry) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-400 hover:text-rose-700">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-4 py-6 text-center text-slate-500">Belum ada data approved.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-lg shadow-emerald-100/60">
                                <div class="mb-4 flex items-center justify-between">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.2em] text-rose-600">Rejected</p>
                                        <p class="text-lg font-semibold text-slate-900">Data ditolak</p>
                                    </div>
                                </div>
                                <div class="overflow-hidden rounded-2xl border border-emerald-100 bg-white">
                                    <table class="min-w-full divide-y divide-emerald-100 text-sm">
                                        <thead class="bg-emerald-50 text-slate-600">
                                            <tr>
                                                <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                                <th class="px-4 py-3 text-left font-semibold">Alasan/Catatan</th>
                                                <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-emerald-50 text-slate-800">
                                            @forelse ($rejectedEntries as $entry)
                                                <tr>
                                                    <td class="px-4 py-3 font-medium">{{ $entry->name }}</td>
                                                    <td class="px-4 py-3 text-slate-600">{{ $entry->notes ?: 'Tidak ada catatan.' }}</td>
                                                    <td class="px-4 py-3 space-x-2">
                                                        <a href="{{ route('admin.guests.show', $entry) }}"
                                                            class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-400 hover:text-emerald-700">Detail</a>
                                                        <form action="{{ route('admin.guests.destroy', $entry) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-400 hover:text-rose-700">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-4 py-6 text-center text-slate-500">Belum ada data rejected.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
