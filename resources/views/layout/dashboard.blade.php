@extends('layout.app')

@section('title', $title ?? 'Dashboard')

@section('content')
<div class="overflow-hidden" x-data="{ sidebarOpen: false }">
    <div class="flex h-full overflow-hidden">
        {{-- Mobile top bar (below global navbar) --}}
        <div class="md:hidden fixed inset-x-0 top-16 z-40 bg-white border-b border-slate-200 flex items-center justify-between px-4 py-3">
            <div class="text-base font-semibold text-slate-900">{{ $title ?? 'Dashboard' }}</div>
            <button @click="sidebarOpen = true" class="p-2 rounded-md  hover:bg-slate-100">
                <svg class="w-5 h-5 text-gray-500 transition-transform" 
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
            </button>
        </div>

        {{-- Sidebar overlay mobile --}}
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-x-0 top-16 bottom-0 z-30 bg-black/30 md:hidden" @click="sidebarOpen = false" style="display: none;"></div>

        {{-- Sidebar --}}
        <div class="fixed left-0 z-40 md:static md:z-0 transform transition-transform duration-200 -translate-x-full md:translate-x-0"
             :class="{ 'translate-x-0': sidebarOpen }"
             style="width: 18rem; top: 64px; bottom: 0;">
            <x-dashboard.sidebar :user="auth()->user()" :mid="$merchantMid ?? null" class="h-full" />
        </div>

        {{-- Main content --}}
        <main class="flex-1 overflow-y-auto pt-16 md:pt-0">
            <div class="p-6 md:px-10">
                @yield('dashboard-content')
            </div>
        </main>
    </div>
</div>
@endsection
