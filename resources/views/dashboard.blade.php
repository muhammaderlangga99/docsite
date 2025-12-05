@extends('layout.dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <div class="space-y-4">
        <div class="space-y-1">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Payment Playgrounds</p>
            <h1 class="text-3xl font-semibold text-slate-900">Pilih metode yang mau diuji</h1>
            <p class="text-sm text-slate-500">Saat ini tersedia dua kanal: QRPS dan Credit/Debit.</p>
        </div>

        @if(session('success'))
            <div class="border border-emerald-200 bg-emerald-50 text-emerald-800 rounded-xl p-4 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="border border-rose-200 bg-rose-50 text-rose-800 rounded-xl p-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="group relative overflow-hidden rounded-2xl border border-white/40 bg-gradient-to-br from-white/80 via-white/40 to-slate-100/50 shadow-[0_20px_60px_-28px_rgba(15,23,42,0.35)] backdrop-blur">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(0,0,0,0.06),transparent_45%)]"></div>
                <div class="relative p-6 flex flex-col gap-2 text-left">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-slate-900">QRPS</span>
                        @if(!($qrpsReady ?? false))
                            <form method="POST" action="{{ route('bindings.qrps') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center w-24 h-10 rounded-xl bg-black/80 text-white text-sm shadow-lg hover:opacity-90 transition">
                                    Generate
                                </button>
                            </form>
                        @endif
                    </div>
                    @if($qrpsReady ?? false)
                        <span class="relative inline-flex items-center gap-2 text-xs font-semibold text-emerald-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_0_6px_rgba(16,185,129,0.15)]"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                            Not Generated
                        </span>
                    @endif
                    <p class="text-sm text-slate-600 leading-relaxed">Scan & pay cepat untuk kanal QR Payment Standard.</p>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl border border-white/40 bg-gradient-to-br from-white/80 via-white/40 to-slate-100/50 shadow-[0_20px_60px_-28px_rgba(15,23,42,0.35)] backdrop-blur">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(0,0,0,0.06),transparent_45%)]"></div>
                <div class="relative p-6 flex flex-col gap-2 text-left">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-slate-900">Credit / Debit</span>
                        @if(!($creditDebitReady ?? false))
                            <form method="POST" action="{{ route('bindings.credit-debit') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center w-24 h-10 rounded-xl bg-black/80 text-white text-sm shadow-lg hover:opacity-90 transition">
                                    Generate
                                </button>
                            </form>
                        @endif
                    </div>
                    @if($creditDebitReady ?? false)
                        <span class="relative inline-flex items-center gap-2 text-xs font-semibold text-emerald-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_0_6px_rgba(16,185,129,0.15)]"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                            Not Generated
                        </span>
                    @endif
                    <p class="text-sm text-slate-600 leading-relaxed">Insert credit/debit (CDCP) dan KEK/DEK untuk username Anda.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
