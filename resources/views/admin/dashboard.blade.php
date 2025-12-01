@extends('layouts.base')

@section('title', 'Admin Dashboard')
@section('body-class', 'bg-emerald-50 text-slate-900 overflow-hidden')

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
                <a class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-300 transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-50"
                    href="{{ route('admin.dashboard') }}">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Dashboard
                </a>
                <a class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-700 transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-50"
                    href="{{ route('admin.guests.index') }}">
                    <span class="h-2 w-2 rounded-full bg-emerald-200"></span>
                    Kunjungan
                </a>
            </nav>
            <div class="mt-8 space-y-3 text-sm text-slate-700">bg-emera
                <div class="flex items-center justify-between rounded-xl border border-emerald-100 bg-white px-4 py-3 shadow-sm">
                    <div>
                        <p class="text-xs text-emerald-600">Masuk sebagai</p>
                        <p class="font-semibold text-slate-900">{{ $user?->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500">{{ $user?->email }}</p>
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
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Ringkasan</p>
                            <h1 class="text-2xl font-semibold text-slate-900">Dashboard Buku Tamu</h1>
                            <p class="text-sm text-slate-600">Pantau kunjungan, tren, dan performa pelayanan.</p>
                        </div>
                        <div class="flex items-center gap-3">
                        </div>
                    </div>
                </div>
                <div class="flex-1 overflow-y-auto scrollbar-hidden">
                    <div class="space-y-8 px-6 py-8">
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-2xl border border-emerald-100 bg-white p-4 shadow-lg shadow-emerald-100/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Menunggu review</p>
                                <div class="mt-3 flex items-baseline gap-2">
                                    <span class="text-3xl font-semibold text-slate-900">{{ number_format($stats['pending'] ?? 0) }}</span>
                                    <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Pending</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-600">Tamu menunggu persetujuan.</p>
                            </div>
                            <div class="rounded-2xl border border-emerald-100 bg-white p-4 shadow-lg shadow-emerald-100/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Disetujui</p>
                                <div class="mt-3 flex items-baseline gap-2">
                                    <span class="text-3xl font-semibold text-slate-900">{{ number_format($stats['approved'] ?? 0) }}</span>
                                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Approved</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-600">Tamu yang sudah di-approve.</p>
                            </div>
                            <div class="rounded-2xl border border-emerald-100 bg-white p-4 shadow-lg shadow-emerald-100/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Ditolak</p>
                                <div class="mt-3 flex items-baseline gap-2">
                                    <span class="text-3xl font-semibold text-slate-900">{{ number_format($stats['rejected'] ?? 0) }}</span>
                                    <span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-700">Rejected</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-600">Tamu yang ditolak admin.</p>
                            </div>
                            <div class="rounded-2xl border border-emerald-100 bg-white p-4 shadow-lg shadow-emerald-100/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Jadwal hari ini</p>
                                <div class="mt-3 flex items-baseline gap-2">
                                    <span class="text-3xl font-semibold text-slate-900">{{ number_format($stats['today'] ?? 0) }}</span>
                                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Visit</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-600">Tamu dengan tanggal hari ini.</p>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-lg shadow-emerald-100/60">
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Total Visitors</p>
                                    <p class="text-lg font-semibold text-slate-900">Periode dinamis</p>
                                    <p class="text-sm text-slate-600">Pilih rentang waktu untuk melihat tren kunjungan.</p>
                                </div>
                                @php
                                    $rangeOptions = [
                                        'day' => 'Hari ini',
                                        'week' => 'Minggu ini',
                                        'month' => 'Bulan ini',
                                    ];
                                @endphp
                                <div class="flex items-center gap-2">
                                    @foreach ($rangeOptions as $key => $label)
                                        <a href="{{ route('admin.dashboard', ['range' => $key]) }}"
                                            class="rounded-full border {{ $chartRange === $key ? 'border-emerald-400 bg-emerald-50 text-emerald-700' : 'border-emerald-200 bg-white text-slate-700' }} px-3 py-1 text-xs font-semibold transition hover:border-emerald-400 hover:text-emerald-700">
                                            {{ $label }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="relative overflow-hidden rounded-2xl border border-emerald-100 bg-gradient-to-b from-white via-emerald-50 to-white p-6">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(16,185,129,0.14),transparent_35%),radial-gradient(circle_at_80%_10%,rgba(52,211,153,0.12),transparent_30%),radial-gradient(circle_at_50%_80%,rgba(59,130,246,0.08),transparent_40%)]"></div>
                                <div class="relative">
                                    <canvas id="visitorsChart" class="h-64 w-full"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-lg shadow-emerald-100/60">
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Antrian terbaru</p>
                                    <p class="text-lg font-semibold text-slate-900">Permintaan buku tamu terbaru</p>
                                </div>
                                <a href="{{ route('admin.guests.index') }}"
                                    class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-sm font-medium text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-400 hover:text-emerald-700">Lihat semua</a>
                            </div>
                            <div class="overflow-hidden rounded-2xl border border-emerald-100 bg-white">
                                <table class="min-w-full divide-y divide-emerald-100 text-sm">
                                    <thead class="bg-emerald-50 text-slate-600">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                            <th class="px-4 py-3 text-left font-semibold">Keperluan</th>
                                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                                            <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-emerald-50 text-slate-800">
                                        @forelse ($latestEntries as $entry)
                                            @php
                                                $badge = match ($entry->status) {
                                                    \App\Models\GuestEntry::STATUS_APPROVED => 'bg-emerald-100 text-emerald-700',
                                                    \App\Models\GuestEntry::STATUS_REJECTED => 'bg-rose-100 text-rose-700',
                                                    default => 'bg-amber-100 text-amber-700',
                                                };
                                                $label = ucfirst($entry->status);
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-3 font-medium">{{ $entry->name }}</td>
                                                <td class="px-4 py-3 text-slate-600">{{ $entry->purpose }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">{{ $label }}</span>
                                                </td>
                                                <td class="px-4 py-3 text-slate-600">{{ optional($entry->visit_date)->format('d M Y') ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-6 text-center text-slate-500">Belum ada permintaan tamu.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($chartLabels);
        const dataValues = @json($chartValues);
        const ctx = document.getElementById('visitorsChart');

        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Jumlah kunjungan',
                            data: dataValues,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.15)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#10b981',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#f8fafc',
                            bodyColor: '#e2e8f0',
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                color: '#475569',
                            },
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(16,185,129,0.08)',
                            },
                            ticks: {
                                color: '#475569',
                                precision: 0,
                            },
                        },
                    },
                },
            });
        }
    </script>
@endsection
