@extends('layout.app')

{{-- (Opsional) Set judul halaman --}}
@section('title', 'The Framework for the Web')

{{-- 
  Ini adalah CSS khusus buat nambahin background grid tipis
  kayak di contoh. Kita "push" style ini ke @stack('styles') 
  yang ada di layouts/app.blade.php lo.
--}}
{{-- @push('styles')
<style>
    .hero-grid-bg {
        /* Background putih */
        background-color: #ffffff; 
        
        /* Grid tipis pake linear-gradient.
          Kita pake warna abu-abu yang sangat transparan.
        */
        background-image: 
            linear-gradient(to right, rgba(211, 211, 211, 0.4) 1px, transparent 1px), 
            linear-gradient(to bottom, rgba(211, 211, 211, 0.4) 1px, transparent 1px);
        
        /* Ukuran kotaknya. Lo bisa ganti misal 40px 40px kalo mau lebih rapat.
          Di gambar aslinya keliatan gede-gede.
        */
        background-size: 100px 100px; 
        
        /* Ini buat ngatur posisi awal grid-nya.
          Penting biar garisnya keliatan pas di edge.
        */
        background-position: -1px -1px; 
    }
</style>
@endpush --}}


{{-- Ini adalah konten Hero Section-nya --}}
@section('content')
    
    {{-- Kita pake class .hero-grid-bg yang kita definisiin di atas --}}
    <section class="relative overflow-hidden hero-grid-bg px-3">
        {{-- Kontainer utama --}}
        <div class="container mx-auto md:py-32 text-center">


            <div class="flex flex-wrap justify-center items-center gap-2 md:gap-4 mb-6 mt-10 md:mt-0">
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">New</span>
                <span class="text-sm text-gray-700">Explore real-time transaction insights with CashPortal, your complete reporting dashboard.
            </span>
                
                {{-- Tombol "Find out more" (versi lebih simpel) --}}
                <a href="https://dashboard.cashup.id" class="bg-black text-white text-sm px-3 py-1 rounded-full font-medium hover:bg-gray-800 transition-colors">
                    Go to cashPortal  &rarr;
                </a>
               
            </div>

            {{-- 2. Headline Utama --}}
            <h1 class="text-4xl md:text-6xl font-semibold md:font-[700] tracking-tighter mb-6 text-gray-900 text-center">
                The Payment Integration Platform by <img src="/img/logo-nav.png" class="h-8 md:h-15 inline -translate-y-1" alt="">
            </h1>

            {{-- 3. Sub-headline / Deskripsi --}}
            <p class="text-sm md:text-xl text-gray-600 max-w-2xl mx-auto mb-10">
                {{-- Used by some of the world's largest companies, Next.js enables you to create 
                <strong class="text-gray-900">high-quality web applications</strong> 
                with the power of React components. --}}
                Used by merchants and partners across industries, cashUP provides a robust API that makes it easy to integrate secure and scalable payment solutions into your applications.
            </p>

            {{-- 4. Tombol Call to Action (CTA) --}}
            <div class="flex sm:flex-row justify-center items-center gap-4 mb-4 px-5">
                {{-- Tombol Hitam --}}
                <a href="https://docs.cashup.test/docs/introduction"  class="w-full sm:w-auto bg-black text-white px-5 py-3 rounded-md font-semibold text-md hover:bg-gray-800 transition-colors">
                    Get Started
                </a>
                {{-- Tombol Putih --}}
                <a href="https://cashup.id" class="w-full sm:w-auto bg-white text-black border border-gray-300 px-5 py-3 rounded-md font-semibold text-md hover:bg-gray-50 transition-colors">
                    About Us
                </a>
            </div>
        </div>
    </section>

@endsection
