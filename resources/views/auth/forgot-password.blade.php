@extends('layout.guest')

@section('title', 'Lupa Password')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Lupa password</h1>
    <p class="text-sm text-slate-600 leading-relaxed mt-1">
        Masukkan email terverifikasi. Kami akan kirim link reset password.
    </p>
</div>

@if (session('status'))
    <div class="mb-4 p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-4">
    @csrf
    <div class="space-y-2 flex flex-col">
        <label for="email" class="text-sm font-medium text-slate-700">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
               class="w-full h-12 px-5 rounded-xl border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-black/40"
               placeholder="email@domain.com">
        @error('email')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 h-12 px-4 rounded-xl bg-black text-white text-sm font-semibold transition hover:opacity-90">
        Kirim link reset
    </button>
</form>

<div class="mt-6 text-sm text-slate-600">
    Ingat password?
    <a href="{{ route('login') }}" class="font-semibold text-slate-900 hover:underline">Kembali ke login</a>
</div>
@endsection
