@extends('layout.app')

{{-- (Opsional) Set judul halaman --}}
@section('title', 'Introduction | cashUP Docs')

{{-- 
  Kita bisa nambahin style CSS khusus buat halaman ini.
  Di contoh ini, kita bikin background grid tipis di hero section.

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
    <section class="relative overflow-hidden hero-grid-bg px-3 h-screen flex">
        {{-- Kontainer utama --}}
        <div class="container m-auto">
            <div class="flex flex-col md:flex-row items-center gap-10 lg:gap-16">
                <div class="w-full md:w-1/2">
                    <img src="/img/docs-home.png" alt="cashUP Docs" class="w-full max-w-xl mx-auto rounded-3xl">
                </div>
                <div class="w-full md:w-1/2 space-y-6">
                    {{-- 2. Headline Utama --}}
                    <h1 class="text-4xl lg:text-6xl font-semibold md:font-[700] tracking-tight text-gray-900 leading-tight">
                        The Payment Integration Platform by <img src="/img/logo-nav.png" class="h-8 md:h-12 inline -translate-y-1" alt="">
                    </h1>

                    {{-- 3. Sub-headline / Deskripsi --}}
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed">
                        Used by merchants and partners across industries, cashUP provides a robust API that makes it easy to integrate secure and scalable payment solutions into your applications.
                    </p>

                    {{-- 4. Tombol Call to Action (CTA) --}}
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ url('docs/introduction') }}"  class="w-full text-center sm:w-auto bg-black text-white px-6 py-3.5 rounded-lg font-semibold text-base hover:bg-gray-800 transition-colors shadow-md">
                            Get Started
                        </a>
                        <a href="https://cashup.id" class="w-full sm:w-auto bg-white text-center text-black border border-gray-200 px-6 py-3.5 rounded-lg font-semibold text-base hover:bg-gray-50 transition-colors shadow-sm">
                            About Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
