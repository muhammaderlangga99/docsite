@extends('layout.guest')

@section('title', 'Reset Password')

@section('content')
@php
    $appUrl = rtrim(config('app.url'), '/');
@endphp
<div class="mb-6">
    <p class="text-sm text-slate-500 font-medium">Atur ulang akses</p>
    <h1 class="text-2xl font-semibold text-slate-900">Reset password</h1>
    <p class="text-sm text-slate-600 leading-relaxed mt-1">
        Buat password baru untuk akun kamu.
    </p>
</div>

<form method="POST" action="{{ $appUrl }}/reset-password" class="space-y-4">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="space-y-2">
        <label for="email" class="text-sm font-medium text-slate-700">Email</label>
        <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" required
               class="w-full h-12 px-5 rounded-full border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#e77355]/40"
               placeholder="email@domain.com">
        @error('email')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="password" class="text-sm font-medium text-slate-700">Password baru</label>
        <input type="password" name="password" id="password" required
               class="w-full h-12 px-5 rounded-full border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#e77355]/40"
               placeholder="Minimal 8 karakter">
        @error('password')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="password_confirmation" class="text-sm font-medium text-slate-700">Konfirmasi password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required
               class="w-full h-12 px-5 rounded-full border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#e77355]/40"
               placeholder="Ulangi password">
    </div>

    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 h-12 px-4 rounded-full bg-[#e77355] text-white text-sm font-semibold transition hover:opacity-90">
        Simpan password baru
    </button>
</form>

<div class="mt-6 text-sm text-slate-600">
    Sudah ingat password?
    <a href="{{ $appUrl }}/login" class="font-semibold text-slate-900 hover:underline">Kembali ke login</a>
</div>
@endsection
