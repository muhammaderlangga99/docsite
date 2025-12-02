@extends('layout.guest')

@section('title', 'Verifikasi Email')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold text-slate-900 mt-1">Verifikasi email</h1>
    <p class="text-sm text-slate-600 leading-relaxed mt-2">
        Kami sudah mengirim link verifikasi ke <span class="font-semibold text-slate-900">{{ auth()->user()->email }}</span>.
        Cek inbox atau folder spam.
    </p>
</div>

@if (session('status') === 'verification-link-sent')
    <div class="mb-4 p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm">
        Link verifikasi baru sudah dikirim. Silakan cek email kamu.
    </div>
@elseif (session('status') === 'verification-complete')
    <div class="mb-4 p-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm">
        Email sudah terverifikasi. Kamu bisa lanjut ke dashboard.
    </div>
@endif

<div class="space-y-3">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 h-12 px-4 rounded-xl bg-black text-white text-sm font-semibold transition hover:opacity-90">
            Kirim ulang email verifikasi
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 h-12 px-4 rounded-xl border border-slate-200 text-slate-700 text-sm font-semibold bg-white transition hover:shadow hover:-translate-y-px">
            Keluar
        </button>
    </form>
</div>
@endsection
