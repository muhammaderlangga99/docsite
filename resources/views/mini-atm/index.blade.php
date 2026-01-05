@extends('layout.dashboard')

@section('title', 'Mini ATM Credentials')

@section('dashboard-content')
@php
    $hasPrivateKey = !empty($privateKey);
    $maskedPrivateKey = $hasPrivateKey ? substr($privateKey, 0, 18) . '****' : '-----BEGIN PRI****';
@endphp
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-xs uppercase tracking-[0.08em] text-slate-500 mb-1">Credentials</p>
        <h1 class="text-2xl font-semibold text-slate-900">Mini ATM</h1>
        <p class="text-sm text-slate-500 mt-1">Generate and manage Host-to-Host Mini ATM credentials.</p>
    </div>
    @if(! $credentials)
        <form action="{{ route('mini-atm.generate') }}" method="POST" class="inline-flex items-center gap-2 px-3 py-2 bg-slate-900 text-white rounded-lg text-sm hover:bg-slate-800 transition">
            @csrf
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12h15m0 0-5.25-5.25M19.5 12l-5.25 5.25" />
            </svg>
            <button type="submit">Generate Credentials</button>
        </form>
    @endif
</div>

@if($error)
    <div class="border border-rose-200 bg-rose-50 text-rose-800 rounded-xl p-4 mb-4 text-sm">
        {{ $error }}
    </div>
@endif

@if($message)
    <div class="border border-emerald-200 bg-emerald-50 text-emerald-800 rounded-xl p-4 mb-4 text-sm">
        {{ $message }}
    </div>
@endif

<div class="border border-slate-200 bg-white text-slate-900 rounded-xl p-6 text-sm shadow-sm space-y-4 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.08em] text-emerald-600 mb-1">Host2Host</p>
            <p class="font-semibold text-lg text-slate-900">Mini ATM Access</p>
        </div>
        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Ready</span>
    </div>

    <div class="grid md:grid-cols-2 gap-3">
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Host</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $host }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $host }}">Copy</button>
            </div>
        </div>
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">TID</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $miniAtmTid ?? '-' }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $miniAtmTid }}" @if(! $miniAtmTid) disabled @endif>Copy</button>
            </div>
            @if(! $miniAtmTid)
                <p class="text-xs text-amber-600 mt-2">TID belum tersedia. Silakan generate Mini ATM terlebih dahulu.</p>
            @endif
        </div>
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">MID</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $merchantMid ?? '-' }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $merchantMid }}">Copy</button>
            </div>
        </div>
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Device ID</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $user?->device_id ?? '-' }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $user?->device_id }}">Copy</button>
            </div>
        </div>
    </div>
</div>

@if($credentials)
    <div class="border border-slate-200 bg-white text-slate-900 rounded-xl p-6 text-sm shadow-sm space-y-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.08em] text-emerald-600 mb-1">Credentials</p>
                <p class="font-semibold text-lg text-slate-900">Aktif</p>
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('mini-atm.regenerate') }}" method="POST" class="inline-flex items-center gap-2 px-3 py-2 border border-slate-200 text-slate-700 rounded-lg text-sm hover:bg-slate-50 transition">
                    @csrf
                    <input type="hidden" name="partner_id" value="{{ $credentials->partner_id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12h15m-15 0 4.5 4.5M4.5 12l4.5-4.5" />
                    </svg>
                    <button type="submit">Regenerate Credentials</button>
                </form>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Ready</span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-3">
            <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
                <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Partner</p>
                <div class="flex items-center justify-between gap-2">
                    <span class="font-semibold text-slate-900 break-all">{{ $credentials->partner_name }}</span>
                    <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $credentials->partner_id }}">Copy ID</button>
                </div>
            </div>
            <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
                <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Client ID</p>
                <div class="flex items-center justify-between gap-2">
                    <span class="font-semibold text-slate-900 break-all">{{ $credentials->client_id }}</span>
                    <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $credentials->client_id }}">Copy</button>
                </div>
            </div>
            <div class="md:col-span-2 border border-slate-200 rounded-lg p-3 bg-slate-50/70">
                <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">API Key</p>
                <div class="flex items-center justify-between gap-2">
                    <span class="font-semibold text-slate-900 break-all">{{ $credentials->api_key }}</span>
                    <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $credentials->api_key }}">Copy</button>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="border border-dashed border-slate-200 rounded-xl p-6 text-sm text-slate-600">
        <p class="font-medium text-slate-800 mb-2">Belum ada credentials</p>
        <p>Tekan tombol "Generate Credentials" untuk membuat partner, client, dan RSA key pair baru.</p>
    </div>
@endif

@if($hasPrivateKey)
    <div class="border border-amber-200 bg-white text-slate-900 rounded-xl p-6 text-sm shadow-sm space-y-3 mt-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.08em] text-amber-600 mb-1">Private Key</p>
                <p class="font-semibold text-lg text-slate-900">Disimpan sekali</p>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">One-time view</span>
        </div>
        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
            <pre id="private-key-text" class="text-xs leading-relaxed text-slate-800 whitespace-pre-wrap break-all blur-sm select-all" data-full="{{ $privateKey }}" data-masked="{{ $maskedPrivateKey }}">{{ $maskedPrivateKey }}</pre>
        </div>
        <div class="space-y-2">
            <button id="reveal-btn" type="button" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Reveal Private Key
            </button>
            <div id="confirm-section" class="hidden space-y-2">
                <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                    <input type="checkbox" id="confirm-checkbox" class="rounded border-slate-300 text-slate-700">
                    Saya mengerti bahwa private key hanya dapat dilihat sekali
                </label>
                <div class="flex flex-wrap items-center gap-2">
                    <button id="show-btn" type="button" class="px-3 py-2 rounded-lg bg-slate-900 text-white text-sm hover:bg-slate-800 transition disabled:opacity-50" disabled>Tampilkan</button>
                    <button id="copy-btn" type="button" class="px-3 py-2 rounded-lg border border-slate-200 text-slate-700 text-sm hover:bg-slate-50 transition disabled:opacity-50" disabled>Copy to Clipboard</button>
                    <span id="copy-feedback" class="text-xs text-emerald-600 hidden">Disalin</span>
                </div>
            </div>
        </div>
        <div class="text-xs font-semibold text-amber-600 leading-relaxed">
            Private key ini hanya ditampilkan sekali dan tidak dapat dipulihkan. Jika hilang, Anda wajib melakukan regenerate key.
        </div>
    </div>
@endif
@endsection

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

        const revealBtn = document.getElementById('reveal-btn');
        const confirmSection = document.getElementById('confirm-section');
        const confirmCheckbox = document.getElementById('confirm-checkbox');
        const showBtn = document.getElementById('show-btn');
        const copyBtn = document.getElementById('copy-btn');
        const copyFeedback = document.getElementById('copy-feedback');
        const privateKeyText = document.getElementById('private-key-text');

        if (revealBtn && confirmSection && confirmCheckbox && showBtn && copyBtn && privateKeyText) {
            revealBtn.addEventListener('click', () => {
                confirmSection.classList.remove('hidden');
                revealBtn.classList.add('hidden');
            });

            confirmCheckbox.addEventListener('change', () => {
                const checked = confirmCheckbox.checked;
                showBtn.disabled = !checked;
                copyBtn.disabled = !checked;
            });

            showBtn.addEventListener('click', () => {
                privateKeyText.textContent = privateKeyText.dataset.full;
                privateKeyText.classList.remove('blur-sm');
            });

            copyBtn.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(privateKeyText.dataset.full);
                    copyFeedback.classList.remove('hidden');
                    setTimeout(() => copyFeedback.classList.add('hidden'), 1500);
                } catch (err) {
                    console.error('Copy failed', err);
                }
            });
        }
    });
</script>
@endpush
