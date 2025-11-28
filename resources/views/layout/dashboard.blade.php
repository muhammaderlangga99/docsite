@extends('layout.app')

@section('title', $title ?? 'Dashboard')

@section('content')
<div class="min-h-screen bg-white" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        {{-- Mobile top bar (below global navbar) --}}
        <div class="md:hidden fixed inset-x-0 top-16 z-40 bg-white border-b border-slate-200 flex items-center justify-between px-4 py-3">
            <div class="text-base font-semibold text-slate-900">{{ $title ?? 'Dashboard' }}</div>
            <button @click="sidebarOpen = true" class="p-2 rounded-md border border-slate-200 hover:bg-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Sidebar overlay mobile --}}
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-x-0 top-16 bottom-0 z-30 bg-black/30 md:hidden" @click="sidebarOpen = false" style="display: none;"></div>

        {{-- Sidebar --}}
        <div class="fixed left-0 z-40 md:static md:z-0 transform transition-transform duration-200 -translate-x-full md:translate-x-0"
             :class="{ 'translate-x-0': sidebarOpen }"
             style="width: 18rem; top: 64px; bottom: 0;">
            <x-dashboard.sidebar :user="auth()->user()" class="h-full" />
        </div>

        {{-- Main content --}}
        <main class="flex-1 overflow-y-auto bg-white pt-16 md:pt-0">
            <div class="p-6 md:p-10">
                @yield('dashboard-content')
            </div>
        </main>
    </div>
</div>
@endsection
