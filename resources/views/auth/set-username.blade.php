@extends('layout.guest')

@section('title', 'Atur Username')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Atur Username</h1>
    <p class="text-sm text-slate-600 mt-1">Pilih username untuk akun Anda.</p>
</div>

<form method="POST" action="{{ route('username.store') }}" class="space-y-4">
    @csrf
    <div class="space-y-2 flex flex-col">
        <label for="username" class="text-sm font-medium text-slate-700">Username</label>
        <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
               class="w-full h-12 px-5 rounded-xl border border-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-black/40"
               placeholder="huruf/angka/underscore">
        @error('username')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 h-12 px-4 rounded-xl bg-black text-white text-sm font-semibold transition hover:opacity-90">
        Simpan Username
    </button>
</form>
@endsection
