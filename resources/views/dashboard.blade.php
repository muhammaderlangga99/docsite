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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="group relative overflow-hidden rounded-2xl border border-white/40 bg-gradient-to-br from-white/80 via-white/40 to-slate-100/50 shadow-[0_20px_60px_-28px_rgba(15,23,42,0.35)] backdrop-blur">
                <img class="w-full bg-[#f1ebe5]" src="{{ asset('img/qrps.png') }}" alt="QRPS">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(0,0,0,0.06),transparent_45%)]"></div>
                <div class="relative p-6 flex flex-col gap-2 text-left">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-slate-900">QRPS</span>
                    </div>
                    @if($qrpsReady ?? false)
                        <span class="relative inline-flex items-center gap-2 text-xs font-semibold text-emerald-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_0_6px_rgba(16,185,129,0.15)]"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                            Not Activated
                        </span>
                    @endif
                    <p class="text-sm text-slate-600 leading-relaxed">Scan & pay cepat untuk kanal QR Payment Standard.</p>
                    <div class="flex gap-x-2">
                        <a href="" class="px-2.5 py-1.5 bg-[#4b7eae] hover:bg-[#2f5376]  text-white font-medium text-sm rounded-lg inline-block capitalize">read doc ›</a>
                        @if(!($qrpsReady ?? false))
                            <form method="POST" action="{{ route('bindings.qrps') }}">
                                @csrf
                                <button type="submit" class="inline-flex capitalize items-center gap-x-2 justify-center px-2.5 py-1.5 rounded-lg bg-black/55 text-white text-sm shadow-lg hover:opacity-90 transition">
                                    <span>activate</span> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-dot-dashed-icon lucide-circle-dot-dashed"><path d="M10.1 2.18a9.93 9.93 0 0 1 3.8 0"/><path d="M17.6 3.71a9.95 9.95 0 0 1 2.69 2.7"/><path d="M21.82 10.1a9.93 9.93 0 0 1 0 3.8"/><path d="M20.29 17.6a9.95 9.95 0 0 1-2.7 2.69"/><path d="M13.9 21.82a9.94 9.94 0 0 1-3.8 0"/><path d="M6.4 20.29a9.95 9.95 0 0 1-2.69-2.7"/><path d="M2.18 13.9a9.93 9.93 0 0 1 0-3.8"/><path d="M3.71 6.4a9.95 9.95 0 0 1 2.7-2.69"/><circle cx="12" cy="12" r="1"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl border border-white/40 bg-gradient-to-br from-white/80 via-white/40 to-slate-100/50 shadow-[0_20px_60px_-28px_rgba(15,23,42,0.35)] backdrop-blur">
                <img class="w-full" src="{{ asset('img/cdcp.png') }}" alt="Credit / Debit">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(0,0,0,0.06),transparent_45%)]"></div>
                <div class="relative p-6 flex flex-col gap-2 text-left">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-slate-900">Credit / Debit</span>
                    </div>
                    @if($creditDebitReady ?? false)
                        <span class="relative inline-flex items-center gap-2 text-xs font-semibold text-emerald-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_0_6px_rgba(16,185,129,0.15)]"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                            Not Activated
                        </span>
                    @endif
                    @if($creditDebitTid ?? false)
                        <p class="text-xs font-semibold text-slate-700">TID: {{ $creditDebitTid }}</p>
                    @endif
                    <p class="text-sm text-slate-600 leading-relaxed">Insert credit/debit (CDCP) dan KEK/DEK untuk username Anda.</p>
                    <div class="flex gap-x-2">
                        <a href="" class="px-2.5 py-1.5 bg-[#4b7eae] hover:bg-[#2f5376]  text-white font-medium text-sm rounded-lg inline-block capitalize">read doc ›</a>
                        @if(!($creditDebitReady ?? false))
                            <form method="POST" action="{{ route('bindings.credit-debit') }}">
                                @csrf
                                <button type="submit" class="inline-flex capitalize items-center gap-x-2 justify-center px-2.5 py-1.5 rounded-lg bg-black/55 text-white text-sm shadow-lg hover:opacity-90 transition">
                                    <span>activate</span> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-dot-dashed-icon lucide-circle-dot-dashed"><path d="M10.1 2.18a9.93 9.93 0 0 1 3.8 0"/><path d="M17.6 3.71a9.95 9.95 0 0 1 2.69 2.7"/><path d="M21.82 10.1a9.93 9.93 0 0 1 0 3.8"/><path d="M20.29 17.6a9.95 9.95 0 0 1-2.7 2.69"/><path d="M13.9 21.82a9.94 9.94 0 0 1-3.8 0"/><path d="M6.4 20.29a9.95 9.95 0 0 1-2.69-2.7"/><path d="M2.18 13.9a9.93 9.93 0 0 1 0-3.8"/><path d="M3.71 6.4a9.95 9.95 0 0 1 2.7-2.69"/><circle cx="12" cy="12" r="1"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl border border-white/40 bg-gradient-to-br from-white/80 via-white/40 to-slate-100/50 shadow-[0_20px_60px_-28px_rgba(15,23,42,0.35)] backdrop-blur">
                <img class="w-full" src="{{ asset('img/miniatm.png') }}" alt="MiniATM Service">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(0,0,0,0.06),transparent_45%)]"></div>
                <div class="relative p-6 flex flex-col gap-2 text-left">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-slate-900">MiniATM Service</span>
                    </div>
                    @if($miniAtmReady ?? false)
                        <span class="relative inline-flex items-center gap-2 text-xs font-semibold text-emerald-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_0_6px_rgba(16,185,129,0.15)]"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                            Not Activated
                        </span>
                    @endif
                    @if($miniAtmTid ?? false)
                        <p class="text-xs font-semibold text-slate-700">TID: {{ $miniAtmTid }}</p>
                    @endif
                    <p class="text-sm text-slate-600 leading-relaxed">Aktifkan MiniATM simulator untuk akun ini.</p>
                    <div class="flex gap-x-2">
                        <a href="" class="px-2.5 py-1.5 bg-[#4b7eae] hover:bg-[#2f5376]  text-white font-medium text-sm rounded-lg inline-block capitalize">read doc ›</a>
                        @if(!($miniAtmReady ?? false))
                            <form method="POST" action="{{ route('bindings.mini-atm') }}">
                                @csrf
                                <button type="submit" class="inline-flex capitalize items-center gap-x-2 justify-center px-2.5 py-1.5 rounded-lg bg-black/55 text-white text-sm shadow-lg hover:opacity-90 transition">
                                    <span>activate</span> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-dot-dashed-icon lucide-circle-dot-dashed"><path d="M10.1 2.18a9.93 9.93 0 0 1 3.8 0"/><path d="M17.6 3.71a9.95 9.95 0 0 1 2.69 2.7"/><path d="M21.82 10.1a9.93 9.93 0 0 1 0 3.8"/><path d="M20.29 17.6a9.95 9.95 0 0 1-2.7 2.69"/><path d="M13.9 21.82a9.94 9.94 0 0 1-3.8 0"/><path d="M6.4 20.29a9.95 9.95 0 0 1-2.69-2.7"/><path d="M2.18 13.9a9.93 9.93 0 0 1 0-3.8"/><path d="M3.71 6.4a9.95 9.95 0 0 1 2.7-2.69"/><circle cx="12" cy="12" r="1"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
