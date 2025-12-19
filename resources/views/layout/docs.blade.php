{{-- resources/views/layouts/docs.blade.php --}}

{{-- Numpang ke layout utama lo --}}
@extends('layout.app') 

@section('content')
{{-- 
  ======================================================
  INI PERUBAHAN 1: Tambah x-data di sini
  ======================================================
  Kita taruh "state" Alpine.js di pembungkus paling luar
--}}
<div class="container mx-auto" x-data="{ mobileMenuOpen: false }">
    
    {{-- 
      Pas menu mobile kebuka, kita cegah body di belakangnya 
      ikut ke-scroll.
    --}}
    <div x-show="mobileMenuOpen" 
         x-transition
         class="fixed inset-0 z-30" 
         @click="mobileMenuOpen = false" 
         style="display: none;"></div>
         
    <div class="flex flex-col md:flex-row gap-8 py-8">
        <aside class="w-full md:w-1/5">
            
            {{-- 1. TOMBOL TRIGGER (Cuma muncul di HP) --}}
            <div class="md:hidden fixed top-20 w-full"> {{-- Dibuat sticky biar nempel --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="flex items-center justify-between w-full p-3 
                               bg-white/70 border border-gray-200 rounded-lg shadow-sm 
                               backdrop-blur-sm hover:bg-gray-50">
                    
                    <span class="text-sm font-semibold text-gray-700">Menu</span>
                    
                    <svg class="w-5 h-5 text-gray-500 transition-transform" 
                         :class="{ 'rotate-90': mobileMenuOpen }"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>

            {{-- 2. MENU OVERLAY (Cuma muncul di HP pas diklik) --}}
            {{-- 2. MENU OVERLAY (Cuma muncul di HP pas diklik) --}}
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="md:hidden fixed inset-0 z-50 w-full h-full bg-white/95 backdrop-blur-lg"
                 style="display: none;">
                
                {{-- 
                    WRAPPER KONTEN OVERLAY 
                    Kita kasih padding biar rapi
                --}}
                <div class="p-6 h-full flex flex-col">
                    
                    {{-- A. HEADER MENU (Judul & Tombol Close) --}}
                    <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                        {{-- Judul Menu (Opsional, biar keren aja) --}}
                        <span class="font-bold text-lg text-gray-900">Menu</span>
                        
                        {{-- TOMBOL CLOSE (X) --}}
                        <button @click="mobileMenuOpen = false" 
                                type="button" 
                                class="p-2 -mr-2 text-gray-500 rounded-md hover:bg-gray-100 hover:text-gray-900 transition-colors">
                            <span class="sr-only">Close menu</span>
                            {{-- Ikon X (Silang) --}}
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    {{-- B. ISI MENU (Sidebar lo) --}}
                    <div class="flex-1 overflow-y-auto">
                        <x-docs-sidebar 
                            :active-doc="$doc ?? null" 
                            :active-category="$category ?? null" 
                        />
                    </div>
                </div>
            </div>

            {{-- 3. SIDEBAR ASLI (Cuma muncul di PC) --}}
            <div class="hidden md:block sticky top-24">
                {{-- 
                  Sidebar kamu aslinya udah punya 'sticky top-24' 
                  di file docs-sidebar.blade.php, jadi kita panggil aja
                --}}
                <x-docs-sidebar 
                    :active-doc="$doc ?? null" 
                    :active-category="$category ?? null" 
                />
            </div>
        </aside>
        
        {{-- KOLOM 2: KONTEN UTAMA (Tengah) --}}
        <main class="w-full md:w-3/5 px-4 mt-16"> {{-- <-- Lebarnya diubah jadi 3/5 --}}
            @yield('doc-content')
        </main>
        
        {{-- KOLOM 3: DAFTAR ISI (Kanan) --}}
        <aside class="hidden lg:block w-1/5"> {{-- <-- Ini kolom baru --}}
            @yield('toc')
        </aside>
        
    </div>
</div>
@endsection