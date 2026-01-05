@extends('layout.dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
<div class="space-y-4">
    <div class="space-y-1">
        <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Payment Playgrounds</p>
        <h1 class="text-3xl font-semibold text-slate-900">Pilih metode yang mau diuji</h1>
        {{-- <p class="text-sm text-slate-500">: QRPS dan Credit/Debit.</p> --}}
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

    @php
        $cards = [
            [
                'title' => 'QRPS',
                'img' => 'img/qrps.png',
                'desc' => 'Scan & pay cepat untuk kanal QR Payment Standard.',
                'ready' => $qrpsReady ?? false,
                'tid' => null,
                'route' => 'bindings.qrps',
            ],
            // [
            //     'title' => 'BNPL Service',
            //     'img' => 'img/bnpl.png',
            //     'desc' => 'Aktifkan layanan BNPL host-to-host untuk akun ini.',
            //     'ready' => $bnplReady ?? false,
            //     'tid' => null,
            //     'route' => 'bindings.bnpl',
            // ],
            [
                'title' => 'Credit / Debit',
                'img' => 'img/cdcp.png',
                'desc' => 'Insert credit/debit (CDCP) dan KEK/DEK untuk username Anda.',
                'ready' => $creditDebitReady ?? false,
                'tid' => $creditDebitTid ?? null,
                'route' => 'bindings.credit-debit',
            ],
            [
                'title' => 'MiniATM Service',
                'img' => 'img/miniatm.png',
                'desc' => 'Aktifkan MiniATM simulator untuk akun ini.',
                'ready' => $miniAtmReady ?? false,
                'tid' => $miniAtmTid ?? null,
                'route' => 'bindings.mini-atm',
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($cards as $card)
            <div class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-gradient-to-br from-white/80 via-white/40 to-slate-100/50  backdrop-blur">
                <img class="w-full bg-[#f1ebe5]" src="{{ asset($card['img']) }}" alt="{{ $card['title'] }}">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(0,0,0,0.06),transparent_45%)]"></div>

                <div class="relative p-6 flex flex-col gap-2 text-left">
                    <span class="text-lg font-semibold text-slate-900">{{ $card['title'] }}</span>

                    @if($card['ready'])
                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_0_6px_rgba(16,185,129,0.15)]"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                            Not Activated
                        </span>
                    @endif

                    @if($card['tid'])
                        <p class="text-xs font-semibold text-slate-700">TID: {{ $card['tid'] }}</p>
                    @endif

                    <p class="text-sm text-slate-600 leading-relaxed">{{ $card['desc'] }}</p>

                    <div class="flex gap-x-2">
                        <a href="#" class="px-2.5 py-1.5 bg-green-700 hover:bg-[#2f5376] text-white font-medium text-sm rounded-xl capitalize">
                            read doc
                        </a>

                        @unless($card['ready'])
                            <form method="POST" action="{{ route($card['route']) }}">
                                @csrf
                                <button class="px-3 py-1.5 rounded-xl font-medium capitalize bg-blue-900 text-white text-sm shadow hover:opacity-90">
                                    activate
                                </button>
                            </form>
                        @endunless
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
