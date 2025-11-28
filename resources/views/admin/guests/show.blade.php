@extends('layouts.base')

@section('title', 'Detail Tamu')
@section('body-class', 'bg-emerald-50 text-slate-900 overflow-hidden')

@section('content')
    <div class="flex h-screen overflow-hidden bg-emerald-50 text-slate-900">
        <div class="flex-1 overflow-y-auto scrollbar-hidden">
            <div class="mx-auto max-w-5xl px-6 py-10">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Detail tamu</p>
                        <h1 class="text-2xl font-semibold text-slate-900">{{ $entry->name }}</h1>
                        <p class="text-sm text-slate-600">Diajukan pada {{ $entry->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <a href="{{ route('admin.guests.index') }}"
                        class="rounded-lg border border-emerald-200 bg-white px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-400 hover:text-emerald-700">
                        Kembali
                    </a>
                </div>

                @php
                    $badgeClass = match ($entry->status) {
                        \App\Models\GuestEntry::STATUS_APPROVED => 'bg-emerald-100 text-emerald-700',
                        \App\Models\GuestEntry::STATUS_REJECTED => 'bg-rose-100 text-rose-700',
                        default => 'bg-amber-100 text-amber-700',
                    };
                @endphp

                <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-lg shadow-emerald-100/60">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClass }}">
                                {{ ucfirst($entry->status) }}
                            </span>
                            @if ($entry->reviewed_at)
                                <p class="text-xs text-slate-600">
                                    Direview {{ $entry->reviewed_at->format('d M Y H:i') }} oleh {{ $entry->reviewer?->name ?? 'Admin' }}
                                </p>
                            @endif
                        </div>
                        <div class="space-x-2">
                            <form action="{{ route('admin.guests.destroy', $entry) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-xs font-semibold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-400 hover:text-rose-700">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="space-y-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Kontak</p>
                            <div class="space-y-1 text-sm text-slate-800">
                                <p><span class="text-slate-500">Email:</span> {{ $entry->email }}</p>
                                <p><span class="text-slate-500">Telepon:</span> {{ $entry->phone ?: '—' }}</p>
                                <p><span class="text-slate-500">Instansi:</span> {{ $entry->organization ?: '—' }}</p>
                            </div>
                        </div>
                        <div class="space-y-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Kunjungan</p>
                            <div class="space-y-1 text-sm text-slate-800">
                                <p><span class="text-slate-500">Bertemu dengan:</span> {{ $entry->person_to_meet ?: '—' }}</p>
                                <p><span class="text-slate-500">Tanggal kunjungan:</span> {{ optional($entry->visit_date)->format('d M Y') ?? '—' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 space-y-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Keperluan</p>
                        <p class="text-sm text-slate-800">{{ $entry->purpose }}</p>
                        @if ($entry->notes)
                            <p class="text-xs text-slate-600">Catatan admin: {{ $entry->notes }}</p>
                        @endif
                    </div>
                </div>

                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    @if ($entry->status !== \App\Models\GuestEntry::STATUS_APPROVED)
                        <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-md shadow-emerald-100/60">
                            <p class="text-sm font-semibold text-slate-900">Approve</p>
                            <form action="{{ route('admin.guests.approve', $entry) }}" method="POST" class="mt-3 space-y-3">
                                @csrf
                                <label class="block text-xs text-slate-600">Catatan (opsional)</label>
                                <input type="text" name="notes" value="{{ old('notes') }}"
                                    class="w-full rounded-lg border border-emerald-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none ring-emerald-400/60 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60">
                                <button type="submit"
                                    class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-emerald-400">
                                    Setujui
                                </button>
                            </form>
                        </div>
                    @endif
                    @if ($entry->status !== \App\Models\GuestEntry::STATUS_REJECTED)
                        <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-md shadow-emerald-100/60">
                            <p class="text-sm font-semibold text-slate-900">Reject</p>
                            <form action="{{ route('admin.guests.reject', $entry) }}" method="POST" class="mt-3 space-y-3">
                                @csrf
                                <label class="block text-xs text-slate-600">Catatan (opsional)</label>
                                <input type="text" name="notes" value="{{ old('notes') }}"
                                    class="w-full rounded-lg border border-emerald-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none ring-rose-400/60 transition focus:border-rose-400 focus:ring-2 focus:ring-rose-400/60">
                                <button type="submit"
                                    class="rounded-lg bg-rose-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-rose-400">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
