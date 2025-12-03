@extends('layout.guest')

@section('title', 'Masuk')

@section('content')
@php
    $appUrl = rtrim(config('app.url'), '/');
@endphp
<div class="mb-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-slate-900">Masuk</h1>
    </div>
    <p class="text-sm text-slate-600 leading-relaxed mt-1">Gunakan email yang sudah diverifikasi untuk lanjut.</p>
</div>

@if (session('status') === 'verification-required')
    <div class="mb-4 p-3 rounded-lg border border-amber-200 bg-amber-50 text-amber-800 text-sm">
        Email kamu belum diverifikasi. Cek inbox atau kirim ulang dari halaman verifikasi.
    </div>
@endif

<form method="POST" action="{{ $appUrl }}/login" class="space-y-4">
    @csrf
    <div class="space-y-2 flex flex-col">
        <label for="email" class="text-sm font-medium text-slate-700">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               required autofocus
               class="w-full h-12 px-5 rounded-xl border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-black/40"
               placeholder="nama@email.com">
        @error('email')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 flex flex-col">
        <label for="password" class="text-sm font-medium text-slate-700">Password</label>
        <input type="password" name="password" id="password" required
               class="w-full h-12 px-5 rounded-xl border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-black/40"
               placeholder="••••••••">
        @error('password')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between text-sm text-slate-600">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-slate-700 focus:ring-black" value="1">
            <span>Ingat saya</span>
        </label>
        <a href="{{ $appUrl }}/forgot-password" class="font-semibold text-slate-900 hover:underline">Lupa password?</a>
    </div>

    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 h-12 px-4 rounded-xl bg-black text-white text-sm font-semibold transition hover:opacity-90">
        Masuk
    </button>
    <p class="text-sm text-slate-600">Belum punya akun?
        <a href="{{ $appUrl }}/register" class="font-semibold text-slate-900 hover:underline">Daftar sekarang</a>
    </p>
</form>

<div class="mt-8">
    <div class="text-center text-sm text-slate-600 mb-3">Atau masuk dengan</div>
    <a href="{{ $appUrl }}/auth/google"
       class="w-full inline-flex items-center justify-center gap-3 h-12 px-5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 bg-white transition hover:shadow hover:-translate-y-px">
        <svg class="w-5 h-5" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path fill="#EA4335" d="M24 9.5c3.12 0 5.89 1.07 8.09 2.83l6.06-6.06C34.32 2.86 29.47 1 24 1 14.64 1 6.44 6.24 2.63 14l7.56 5.87C11.73 14.26 17.33 9.5 24 9.5z"/>
            <path fill="#4285F4" d="M46.5 24.5c0-1.64-.15-3.22-.43-4.75H24v9h12.55c-.54 2.7-2.16 4.98-4.58 6.51l7.11 5.53C43.78 36.35 46.5 30.88 46.5 24.5z"/>
            <path fill="#FBBC05" d="M10.19 28.13c-.5-1.47-.77-3.04-.77-4.63 0-1.59.27-3.16.77-4.63l-7.56-5.87C1.91 15.4 1 19.07 1 23.5s.91 8.1 2.63 11.5l7.56-5.87z"/>
            <path fill="#34A853" d="M24 46c5.47 0 10.08-1.8 13.44-4.89l-7.11-5.53c-2 1.34-4.56 2.12-7.33 2.12-6.67 0-12.27-4.76-13.81-11.37l-7.56 5.87C6.44 41.76 14.64 47 24 47z"/>
            <path fill="none" d="M1 1h46v46H1z"/>
        </svg>
        <span>Masuk dengan Google</span>
    </a>
</div>
@endsection
