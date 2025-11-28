@extends('layouts.base')

@section('title', 'Form Buku Tamu')
@section('body-class', 'bg-emerald-50 text-slate-900')

@section('navbar')
    <div class="sticky top-0 z-10 border-b border-emerald-100 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500 text-sm font-semibold text-white shadow-md shadow-emerald-200">
                    BT
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Buku Tamu</p>
                    <p class="text-base font-semibold text-slate-900">Form Publik</p>
                </div>
            </div>
            <nav class="flex items-center gap-3 text-sm font-semibold">
                <a href="{{ route('landing') }}" class="rounded-lg px-3 py-2 text-slate-700 transition hover:text-emerald-700">Home</a>
                <a href="{{ route('guest.create') }}" class="rounded-lg bg-emerald-500 px-3 py-2 text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-400">Input Data Tamu</a>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="min-h-screen">
        <div class="mx-auto max-w-5xl px-6 py-12">
            <div class="grid gap-10 lg:grid-cols-5">
                <div class="lg:col-span-2 space-y-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Form publik</p>
                    <h1 class="text-3xl font-semibold text-slate-900">Isi data buku tamu untuk di-review admin.</h1>
                    <p class="text-slate-600">Kirim data Anda, admin akan menyetujui atau menolak. Jika disetujui, data akan tampil di daftar kunjungan.</p>
                    @if (session('status'))
                        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="lg:col-span-3">
                    <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-xl shadow-emerald-100/60">
                        <form action="{{ route('guest.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label for="name" class="text-sm font-semibold text-slate-900">Nama</label>
                                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60">
                                    @error('name')
                                        <p class="text-sm text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label for="email" class="text-sm font-semibold text-slate-900">Email</label>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60">
                                    @error('email')
                                        <p class="text-sm text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label for="phone" class="text-sm font-semibold text-slate-900">No. HP/Telepon</label>
                                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60">
                                    @error('phone')
                                        <p class="text-sm text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label for="organization" class="text-sm font-semibold text-slate-900">Instansi/Perusahaan</label>
                                    <input id="organization" name="organization" type="text" value="{{ old('organization') }}"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60">
                                    @error('organization')
                                        <p class="text-sm text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label for="person_to_meet" class="text-sm font-semibold text-slate-900">Bertemu dengan</label>
                                    <input id="person_to_meet" name="person_to_meet" type="text" value="{{ old('person_to_meet') }}"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60">
                                    @error('person_to_meet')
                                        <p class="text-sm text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label for="visit_date" class="text-sm font-semibold text-slate-900">Tanggal kunjungan (opsional)</label>
                                    <input id="visit_date" name="visit_date" type="date" value="{{ old('visit_date') }}"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60">
                                    @error('visit_date')
                                        <p class="text-sm text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="purpose" class="text-sm font-semibold text-slate-900">Keperluan</label>
                                <textarea id="purpose" name="purpose" rows="3" required
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60">{{ old('purpose') }}</textarea>
                                @error('purpose')
                                    <p class="text-sm text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-end">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-900">Captcha: {{ $captchaQuestion ?? 'Hitung penjumlahan' }}</label>
                                    <input name="captcha" type="text" inputmode="numeric" required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60">
                                    @error('captcha')
                                        <p class="text-sm text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit"
                                    class="w-full rounded-xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition duration-300 hover:-translate-y-0.5 hover:bg-emerald-400">
                                    Kirim dan menunggu persetujuan admin
                                </button>
                            </div>
                            <p class="text-xs text-slate-500">Data yang dikirim akan masuk antrean admin untuk di-approve atau reject.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
