@extends('layout.dashboard')

@section('title', 'Erica Credentials')

@section('dashboard-content')
@php
    $appUrl = rtrim(config('app.url'), '/');
@endphp
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-xs uppercase tracking-[0.08em] text-slate-500 mb-1">Credentials</p>
        <h1 class="text-2xl font-semibold text-slate-900">Erica</h1>
        <p class="text-sm text-slate-500 mt-1">Generate and manage ECR credentials (Bridge API DB).</p>
    </div>
    @if(! $credentials)
        <form action="{{'/erica/generate'}}" method="POST" class="inline-flex items-center gap-2 px-3 py-2 bg-slate-900 text-white rounded-lg text-sm hover:bg-slate-800 transition">
            @csrf
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12h15m0 0-5.25-5.25M19.5 12l-5.25 5.25" />
            </svg>
            <button>{{ isset($existing) && $existing ? 'Generate API Key' : 'Generate credentials' }}</button>
        </form>
    @endif
</div>

@if(session('erica_error'))
    <div class="border border-rose-200 bg-rose-50 text-rose-800 rounded-xl p-4 mb-4 text-sm">
        {{ session('erica_error') }}
    </div>
@endif

@if($credentials)
    <div class="border border-slate-200 bg-white text-slate-900 rounded-xl p-6 text-sm shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.08em] text-emerald-600 mb-1">Credentials</p>
                <p class="font-semibold text-lg text-slate-900">Aktif</p>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Ready</span>
        </div>
        <div class="grid md:grid-cols-2 gap-3">
            <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
                <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Username</p>
                <div class="flex items-center justify-between gap-2">
                    <span class="font-semibold text-slate-900 break-all">{{ $credentials['username'] }}</span>
                    <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $credentials['username'] }}">Copy</button>
                </div>
            </div>
            <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
                <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Client ID</p>
                <div class="flex items-center justify-between gap-2">
                    <span class="font-semibold text-slate-900 break-all">{{ $credentials['client_id'] }}</span>
                    <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $credentials['client_id'] }}">Copy</button>
                </div>
            </div>
            <div class="md:col-span-2 border border-slate-200 rounded-lg p-3 bg-slate-50/70">
                <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">API Key</p>
                <div class="flex items-center justify-between gap-2">
                    <span class="font-semibold text-slate-900 break-all">{{ $credentials['api_key'] }}</span>
                    <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $credentials['api_key'] }}">Copy</button>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100">
            <p class="text-sm font-semibold text-slate-900 mb-3">Endpoint Payment Request</p>
            <div class="overflow-hidden rounded-xl border border-slate-200 text-xs">
                <div class="grid grid-cols-12 bg-slate-50 border-b border-slate-200">
                    <div class="col-span-3 font-semibold text-slate-800 px-3 py-2">Development</div>
                    <div class="col-span-9 px-3 py-2 bg-slate-900 text-slate-50 break-all">https://tucanos-miniatm.cashlez.com/MmBridgeApi/v1/payment-request</div>
                </div>
                <div class="grid grid-cols-12 bg-slate-50 border-b border-slate-200">
                    <div class="col-span-3 font-semibold text-slate-800 px-3 py-2">Production</div>
                    <div class="col-span-9 px-3 py-2 bg-slate-900 text-slate-50 break-all">https://oarfish.cashlez.com/MmApiEcrHost/v1/payment-request</div>
                </div>
                <div class="grid grid-cols-12 border-b border-slate-200">
                    <div class="col-span-3 bg-slate-50 font-semibold text-slate-800 px-3 py-2">Method</div>
                    <div class="col-span-9 bg-slate-900 text-amber-300 font-semibold px-3 py-2">POST</div>
                </div>
                <div class="grid grid-cols-12">
                    <div class="col-span-3 bg-slate-50 font-semibold text-slate-800 px-3 py-2">Header</div>
                    <div class="col-span-9">
                        <div class="grid grid-cols-12 border-b border-slate-800/30">
                            <div class="col-span-6 bg-slate-50 font-semibold text-slate-800 px-3 py-2">Key</div>
                            <div class="col-span-6 bg-slate-50 font-semibold text-slate-800 px-3 py-2">Value</div>
                        </div>
                        <div class="grid grid-cols-12 bg-slate-900 text-slate-50">
                            <div class="col-span-6 px-3 py-2">ApiKey</div>
                            <div class="col-span-6 px-3 py-2 font-semibold wrap-anywhere">{{ $credentials['api_key'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="border border-dashed border-slate-200 rounded-xl p-6 text-sm text-slate-600">
        <p class="font-medium text-slate-800 mb-2">Belum ada credentials</p>
        <p>Tekan tombol "Generate credentials" untuk membuat user_details dan melihat API Key / Client ID.</p>
    </div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.copy-btn').forEach((btn) => {
            btn.addEventListener('click', async () => {
                const value = btn.dataset.copy;
                if (!value) return;
                try {
                    await navigator.clipboard.writeText(value);
                    const previous = btn.textContent;
                    btn.textContent = 'Copied';
                    setTimeout(() => { btn.textContent = previous; }, 1200);
                } catch (err) {
                    console.error('Copy failed', err);
                }
            });
        });
    });
</script>
@endpush
@endsection
