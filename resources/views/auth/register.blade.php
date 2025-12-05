@extends('layout.guest')

@section('title', 'Daftar')

@section('content')
@php
    $appUrl = rtrim(config('app.url'), '/');
@endphp
<div class="mb-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-slate-900">Daftar</h1>
    </div>
    <p class="text-sm text-slate-600 leading-relaxed mt-1">Gunakan email aktif, lalu verifikasi lewat inbox.</p>
</div>

@if (session('status') === 'verification-link-sent')
    <div class="mb-4 p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm">
        Link verifikasi baru sudah dikirim ke email kamu.
    </div>
@endif

<form method="POST" action="{{ url('/register') }}" class="space-y-4">
    @csrf
    <div class="space-y-2 flex flex-col">
        <label for="name" class="text-sm font-medium text-slate-700">Nama lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
               class="w-full h-12 px-5 rounded-xl border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-black/40"
               placeholder="Nama lengkap">
        @error('name')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 flex flex-col">
        <label for="username" class="text-sm font-medium text-slate-700">Username</label>
        <input type="text" name="username" id="username" value="{{ old('username') }}" required
               class="w-full h-12 px-5 rounded-xl border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-black/40"
               placeholder="username (huruf/angka/underscore)">
        @error('username')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 flex flex-col">
        <label for="email" class="text-sm font-medium text-slate-700">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required
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
               placeholder="Minimal 8 karakter">
        @error('password')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 flex flex-col">
        <label for="password_confirmation" class="text-sm font-medium text-slate-700">Konfirmasi password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required
               class="w-full h-12 px-5 rounded-xl border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-black/40"
               placeholder="Ulangi password">
    </div>

    <div class="space-y-2 flex flex-col">
        <label for="device_id" class="text-sm font-medium text-slate-700">Device Number</label>
        <div class="flex gap-2">
            <input type="text" name="device_id" id="device_id" value="{{ old('device_id') }}" required
                   class="w-full h-12 px-5 rounded-xl border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-black/40"
                   placeholder="contoh: TEST1234567890">
            <button type="button" id="generate-device"
                    class="px-3 py-2 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">
                Generate
            </button>
        </div>
        <p class="text-xs text-slate-500">Wajib diisi. Tombol Generate membuat ID acak 14 karakter diawali TEST.</p>
        @error('device_id')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 h-12 px-4 rounded-xl bg-black text-white text-sm font-semibold transition hover:opacity-90">
        Daftar
    </button>
    <p class="text-sm text-slate-600">Sudah punya akun?
        <a href="{{ $appUrl }}/login" class="font-semibold text-slate-900 hover:underline">Masuk</a>
    </p>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('generate-device');
        const input = document.getElementById('device_id');
        if (!btn || !input) return;

        btn.addEventListener('click', () => {
            const randomDigits = Array.from({ length: 10 }, () => Math.floor(Math.random() * 10)).join('');
            input.value = `TEST${randomDigits}`;
        });
    });
    </script>
@endpush
