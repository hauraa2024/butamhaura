@extends('layouts.base')

@section('title', 'Login Admin')

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-emerald-50 px-4 py-12">
        <div class="w-full max-w-md rounded-2xl border border-emerald-100 bg-white p-8 shadow-2xl shadow-emerald-100/60">
            <div class="mb-6 space-y-2 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Buku Tamu</p>
                <h1 class="text-2xl font-semibold text-slate-900">Masuk sebagai Admin</h1>
                <p class="text-sm text-slate-600">Login hanya untuk akun dengan peran admin.</p>
            </div>
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-slate-900">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60"
                    >
                    @error('email')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-slate-900">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none ring-emerald-500/50 transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/60"
                    >
                    @error('password')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
                <button
                    type="submit"
                    class="flex w-full items-center justify-center rounded-lg bg-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-emerald-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-500"
                >
                    Masuk
                </button>
                <div class="text-center">
                    <a href="{{ route('landing') }}" class="text-sm text-emerald-700 hover:text-emerald-800">Kembali ke landing</a>
                </div>
            </form>
        </div>
    </div>
@endsection
