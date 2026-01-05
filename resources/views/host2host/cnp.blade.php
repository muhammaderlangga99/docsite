@extends('layout.dashboard')

@section('title', 'Host2Host CNP')

@section('dashboard-content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-xs uppercase tracking-[0.08em] text-slate-500 mb-1">Host2Host</p>
        <h1 class="text-2xl font-semibold text-slate-900">CNP</h1>
        <p class="text-sm text-slate-500 mt-1">Credential data for the signed-in user.</p>
    </div>
</div>

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
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Host</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $host }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $host }}">Copy</button>
            </div>
        </div>
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Username</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $user?->username ?? '-' }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $user?->username }}">Copy</button>
            </div>
        </div>
        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/70">
            <p class="text-xs uppercase text-slate-500 tracking-[0.08em] mb-1">Password</p>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold text-slate-900 break-all">{{ $password }}</span>
                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 copy-btn" data-copy="{{ $password }}">Copy</button>
            </div>
        </div>
    </div>
</div>
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
    });
</script>
@endpush
