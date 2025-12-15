{{-- 
    File: resources/views/components/navbar.blade.php
    Udah pake Alpine.js (x-data, @click, x-show, x-transition)
    dan Tailwind CSS.
--}}
<nav class="bg-white/60 backdrop-blur-lg p-4 border-b border-zinc-100 fixed top-0 z-50 w-full" x-data="{ open: false }">
    @php
        $appUrl = rtrim(config('app.url'), '/');
    @endphp
    <div class="container md:px-20 mx-auto flex items-center justify-between">
        
        {{-- Grup Kiri: Logo & Navigasi Desktop --}}
        <div class="flex items-center space-x-4">
            {{-- Logo --}}
            <a href="/" class="flex items-center text-lg font-bold">
                <img src="/img/logo-nav.png" alt="Logo" class="w-28 mr-2">
            </a>
            
            {{-- Navigasi Utama (Hanya Desktop) --}}
            <div class="hidden md:flex space-x-5 text-sm text-gray-500">
                <a href="{{ $appUrl }}/docs/introduction" class="hover:text-gray-300">Docs</a>
                <a href="https://cashup.id" class="hover:text-gray-300">About Us <sup class="text-xs ml-0.5">↗</sup></a>
            </div>
        </div>

        {{-- Grup Kanan: Search, Buttons & Toggle Mobile --}}
        <div class="flex items-center space-x-4">
            @php
                $user = auth()->user();
                $displayName = null;
                if ($user) {
                    $parts = array_values(array_filter(explode(' ', trim($user->name))));
                    $displayName = count($parts) ? $parts[count($parts) - 1] : $user->name;
                }
            @endphp

            @if($user)
                <a href="{{ $appUrl }}/dashboard"
                   class="flex items-center gap-1 lowercase p-1 md:pr-3 font-[400] py-1 rounded-full bg-gray-100 border border-gray-200 text-sm text-gray-700 hover:bg-gray-200 transition">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Avatar" class="w-7 h-7 rounded-full">
                    @else
                        <span class="w-7 h-7 rounded-full bg-gray-300 flex items-center justify-center text-xs font-semibold">
                            {{ strtoupper(substr($displayName ?? $user->name, 0, 1)) }}
                        </span>
                    @endif
                    <span class="hidden -translate-y-0.5 sm:inline">{{ $displayName }}</span>
                </a>
            @else
                <a href="{{ $appUrl }}/login"
                   class="px-3 py-1.5 rounded-full border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                    Sign in
                </a>
            @endif

            {{-- Tombol Toggle Menu (Hanya Mobile) --}}
            <button @click="open = !open" class="md:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500" aria-label="Toggle menu">
                {{-- Ikon Burger (muncul pas 'open' false) --}}
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                {{-- Ikon Close (muncul pas 'open' true) --}}
                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- Dropdown Menu Mobile (Pake Transisi Alpine.js) --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden px-2 pt-2 pb-3 space-y-1 sm:px-3"
         style="display: none;"
         @click.away="open = false" {{-- Bonus: klik di luar menu bakal nutup --}}
         >
        
        <a href="https://cashup.id" class="block py-2 rounded-md text-base">About</a>
        <a href="{{ $appUrl }}/docs/introduction" class="block py-2 rounded-md text-base">Docs</a>
        
    </div>
</nav>
