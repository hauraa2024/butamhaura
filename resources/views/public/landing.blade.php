@extends('layouts.base')

@section('title', 'Buku Tamu Digital')

@section('body-class', 'bg-white text-slate-900')

@section('navbar')
    <div class="relative z-10 border-b border-emerald-100 bg-white/80 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500 text-sm font-semibold text-white shadow-sm shadow-emerald-200">
                    BT
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Buku Tamu</p>
                    <p class="text-base font-semibold text-slate-900">Digital</p>
                </div>
            </div>
            <nav class="flex items-center gap-3 text-sm font-semibold">
                <a href="{{ route('landing') }}" class="rounded-lg px-3 py-2 text-slate-700 transition hover:text-emerald-700">Home</a>
                <a href="{{ route('guest.create') }}" class="rounded-lg px-3 py-2 text-slate-700 transition hover:text-emerald-700">Input Data Tamu</a>
                <a href="{{ route('login') }}" class="rounded-lg border border-emerald-200 bg-white px-3 py-2 text-emerald-700 shadow-sm transition hover:border-emerald-400 hover:text-emerald-800">Login Admin</a>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-emerald-100 opacity-80"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(16,185,129,0.12),transparent_35%),radial-gradient(circle_at_80%_10%,rgba(34,197,94,0.08),transparent_30%)]"></div>
        <div class="relative mx-auto max-w-6xl px-6 py-12 lg:py-16">
            <header class="flex flex-col gap-10 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-6 lg:max-w-3xl">
                    <p class="text-sm uppercase tracking-[0.2em] text-emerald-600">Buku Tamu Digital</p>
                    <h1 class="text-4xl font-semibold leading-tight text-slate-900 sm:text-5xl">
                        Catat, pantau, dan analisa kunjungan tamu dalam satu panel ramping.
                    </h1>
                    <p class="text-lg text-slate-600">
                        Sistem buku tamu modern untuk lobby, event, dan kantor. Mudahkan admin memeriksa log kunjungan,
                        cetak laporan, serta pantau tren tamu secara real-time.
                    </p>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('guest.create') }}"
                            class="inline-flex items-center justify-center rounded-xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-400">
                            Isi buku tamu
                        </a>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-emerald-200 px-5 py-3 text-sm font-semibold text-emerald-700 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-emerald-400 hover:text-emerald-800">
                            Masuk Admin
                        </a>
                        <a href="#fitur"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-emerald-400 hover:text-emerald-700">
                            Lihat fitur
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-3 text-sm text-slate-600">
                        <div class="flex items-center gap-2 rounded-full border border-emerald-100 bg-white px-3 py-1 shadow-sm">Status tamu real-time</div>
                        <div class="flex items-center gap-2 rounded-full border border-emerald-100 bg-white px-3 py-1 shadow-sm">Laporan ekspor</div>
                        <div class="flex items-center gap-2 rounded-full border border-emerald-100 bg-white px-3 py-1 shadow-sm">Layout ringan</div>
                    </div>
                </div>
                <div class="w-full max-w-xl rounded-3xl border border-emerald-100 bg-white/90 p-6 shadow-2xl shadow-emerald-100/60 backdrop-blur">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Sneak peek</p>
                            <p class="text-lg font-semibold text-slate-900">Panel Admin</p>
                        </div>
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Live</span>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-gradient-to-b from-white via-emerald-50 to-white p-4 shadow-inner">
                        <div class="grid grid-cols-2 gap-3 text-sm text-slate-700">
                            <div class="rounded-xl border border-emerald-100 bg-white p-3 shadow-sm transition duration-300 hover:-translate-y-0.5">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Tamu aktif</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($stats['approved'] ?? 0) }}</p>
                            </div>
                            <div class="rounded-xl border border-emerald-100 bg-white p-3 shadow-sm transition duration-300 hover:-translate-y-0.5">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Kunjungan hari ini</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($stats['today'] ?? 0) }}</p>
                            </div>
                            <div class="rounded-xl border border-emerald-100 bg-white p-3 shadow-sm transition duration-300 hover:-translate-y-0.5">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Pending review</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($stats['pending'] ?? 0) }}</p>
                            </div>
                            <div class="rounded-xl border border-emerald-100 bg-white p-3 shadow-sm transition duration-300 hover:-translate-y-0.5">
                                <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Approval rate</p>
                                <p class="mt-2 text-2xl font-semibold text-slate-900">
                                    {{ $stats['approvalRate'] !== null ? $stats['approvalRate'].'%' : '—' }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-5 rounded-xl border border-emerald-100 bg-white px-3 py-4 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Tren 7 hari</p>
                            <div class="mt-3 flex items-end gap-2">
                                @foreach ($sparkline as $point)
                                    <div class="flex-1">
                                        <div class="h-20 w-full rounded-md bg-emerald-100">
                                            <div class="w-full rounded-md bg-emerald-400" style="height: {{ ($point['value'] ?? 0) * 6 }}px"></div>
                                        </div>
                                        <p class="mt-1 text-[10px] text-center text-slate-500">{{ $point['label'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <section id="fitur" class="mt-16 space-y-8">
                <div class="space-y-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Kenapa Buku Tamu ini?</p>
                    <h2 class="text-3xl font-semibold text-slate-900">Alur sederhana, data rapi, performa ringan.</h2>
                    <p class="text-slate-600">Dari check-in tamu sampai laporan berkala, semuanya dalam satu interface yang ringkas.</p>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-lg shadow-emerald-100/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <p class="text-sm font-semibold text-slate-900">Form check-in cepat</p>
                        <p class="mt-3 text-sm text-slate-600">Masukkan tamu, keperluan, dan orang yang dituju dalam beberapa klik, tanpa lag.</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-lg shadow-emerald-100/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <p class="text-sm font-semibold text-slate-900">Kontrol admin penuh</p>
                        <p class="mt-3 text-sm text-slate-600">Login hanya untuk admin, dengan dashboard berfokus pada metrik kunjungan.</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-lg shadow-emerald-100/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <p class="text-sm font-semibold text-slate-900">Laporan siap unduh</p>
                        <p class="mt-3 text-sm text-slate-600">Ekspor ringkasan kunjungan per periode untuk kebutuhan audit atau briefing.</p>
                    </div>
                </div>
            </section>

            <section class="mt-16 grid gap-8 lg:grid-cols-2">
                <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-xl shadow-emerald-100/60">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Alur</p>
                    <h3 class="mt-3 text-2xl font-semibold text-slate-900">3 langkah menjalankan buku tamu</h3>
                    <ol class="mt-5 space-y-4 text-slate-600">
                        <li><span class="font-semibold text-emerald-700">1.</span> Admin login, akses dashboard kunjungan.</li>
                        <li><span class="font-semibold text-emerald-700">2.</span> Input tamu baru atau checkout tamu yang selesai.</li>
                        <li><span class="font-semibold text-emerald-700">3.</span> Unduh laporan atau pantau tren real-time.</li>
                    </ol>
                </div>
                <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-xl shadow-emerald-100/60">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Siap pakai</p>
                    <h3 class="mt-3 text-2xl font-semibold text-slate-900">Butuh akses?</h3>
                    <p class="mt-3 text-slate-600">Hubungi admin untuk mendapatkan akun. Sistem ini dirancang hanya untuk pengguna dengan peran admin.</p>
                    <div class="mt-6 space-y-2 text-sm text-slate-600">
                        <p>Email: admin@example.com</p>
                        <p>Support: +62 812 0000 0000</p>
                    </div>
                    <a href="{{ route('login') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-400">
                        Masuk sekarang
                    </a>
                </div>
            </section>

            <section class="mt-16 text-center">
                <div class="rounded-3xl border border-emerald-100 bg-white p-8 shadow-lg shadow-emerald-100/60">
                    <h3 class="text-2xl font-semibold text-slate-900">Siap kirim data tamu?</h3>
                    <p class="mt-2 text-slate-600">Form publik sekarang ada di halaman tersendiri dengan navigasi yang rapi.</p>
                    <a href="{{ route('guest.create') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-400">
                        Buka form buku tamu
                    </a>
                </div>
            </section>
        </div>
    </div>
@endsection
