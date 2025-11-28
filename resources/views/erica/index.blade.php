@extends('layout.dashboard')

@section('title', 'Erica Credentials')

@section('dashboard-content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-xs uppercase tracking-[0.08em] text-slate-500 mb-1">Credentials</p>
        <h1 class="text-2xl font-semibold text-slate-900">Erica</h1>
        <p class="text-sm text-slate-500 mt-1">Generate and manage ECR credentials (Bridge API DB).</p>
    </div>
    <form action="{{ route('erica.generate') }}" method="POST" class="inline-flex items-center gap-2 px-3 py-2 bg-slate-900 text-white rounded-lg text-sm hover:bg-slate-800 transition">
        @csrf
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12h15m0 0-5.25-5.25M19.5 12l-5.25 5.25" />
        </svg>
        <span>Generate credentials</span>
    </form>
</div>

@if(session('erica_error'))
    <div class="border border-rose-200 bg-rose-50 text-rose-800 rounded-xl p-4 mb-4 text-sm">
        {{ session('erica_error') }}
    </div>
@endif

@if(session('erica_credentials'))
    @php $c = session('erica_credentials'); @endphp
    <div class="border border-emerald-200 bg-emerald-50 text-emerald-900 rounded-xl p-6 text-sm space-y-2">
        <p class="font-medium text-emerald-900">Credentials generated</p>
        <div class="flex items-center gap-2">
            <span class="text-slate-600 w-24">Username</span>
            <span class="font-semibold text-slate-900">{{ $c['username'] }}</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-slate-600 w-24">Client ID</span>
            <span class="font-semibold text-slate-900">{{ $c['client_id'] }}</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-slate-600 w-24">API Key</span>
            <span class="font-semibold text-slate-900 break-all">{{ $c['api_key'] }}</span>
        </div>
    </div>
@else
    <div class="border border-dashed border-slate-200 rounded-xl p-6 text-sm text-slate-600">
        <p class="font-medium text-slate-800 mb-2">Belum ada credentials</p>
        <p>Tekan tombol “Generate credentials” untuk membuat user_details dan melihat API Key / Client ID.</p>
    </div>
@endif
@endsection
