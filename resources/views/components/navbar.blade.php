{{-- 
    File: resources/views/components/navbar.blade.php
    Udah pake Alpine.js (x-data, @click, x-show, x-transition)
    dan Tailwind CSS.
--}}
<nav class="bg-white/60 backdrop-blur-lg p-4 border-b border-zinc-100 fixed top-0 z-50 w-full" x-data="{ open: false, apiOpen: false }">
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
                <div class="relative" @mouseenter="apiOpen = true" @mouseleave="apiOpen = false">
                    <button type="button" class="hover:text-gray-300 flex items-center gap-1">
                        API Playground
                        <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="apiOpen"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="absolute left-0 mt-2 w-56 rounded-xl overflow-hidden border border-gray-100 bg-white shadow-lg text-gray-600"
                         style="display: none;">
                        <a href="{{ $appUrl }}/api-playground/api-czlink" class="block px-4 py-2 hover:bg-gray-50">API CZLink</a>
                        <a href="{{ $appUrl }}/api-playground/api-cdcp" class="block px-4 py-2 hover:bg-gray-50">API CDCP</a>
                        <a href="{{ $appUrl }}/api-playground/api-qris" class="block px-4 py-2 hover:bg-gray-50">API QRIS</a>
                        <a href="{{ $appUrl }}/api-playground/api-bnpl" class="block px-4 py-2 hover:bg-gray-50">API BNPL</a>
                        <a href="{{ $appUrl }}/api-playground/api-mini-atm" class="block px-4 py-2 hover:bg-gray-50">API Mini ATM</a>
                    </div>
                </div>
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
                <a href="{{ $appUrl }}/auth/google"
                   class="px-3 py-1.5 flex gap-2 rounded-full border w-44 border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                    <svg viewBox="-3 0 262 262" class="w-5" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" fill="#4285F4"></path><path d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" fill="#34A853"></path><path d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" fill="#FBBC05"></path><path d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" fill="#EB4335"></path></g></svg>
                    <span class="w-full my-auto">Sign in with google</span>
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
         class="md:hidden z-50 px-2 pt-2 pb-3 space-y-1 sm:px-3"
         style="display: none;"
         @click.away="open = false" {{-- Bonus: klik di luar menu bakal nutup --}}
         >
        
        <a href="https://cashup.id" class="block py-2 rounded-md text-base">About</a>
        <a href="{{ $appUrl }}/docs/introduction" class="block py-2 rounded-md text-base">Docs</a>
        <div class="pt-2">
            <div class="text-xs uppercase tracking-wide text-gray-400">API Playground</div>
            <a href="{{ $appUrl }}/api-playground/api-czlink" class="block py-2 rounded-md text-base">API CZLink</a>
            <a href="{{ $appUrl }}/api-playground/api-cdcp" class="block py-2 rounded-md text-base">API CDCP</a>
            <a href="{{ $appUrl }}/api-playground/api-qris" class="block py-2 rounded-md text-base">API QRIS</a>
            <a href="{{ $appUrl }}/api-playground/api-bnpl" class="block py-2 rounded-md text-base">API BNPL</a>
            <a href="{{ $appUrl }}/api-playground/api-mini-atm" class="block py-2 rounded-md text-base">API Mini ATM</a>
        </div>
        
    </div>
</nav>



