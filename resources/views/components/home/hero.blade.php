@extends('layouts.app')

{{-- (Opsional) Set judul halaman --}}
@section('title', 'The Framework for the Web')

{{-- 
  Ini adalah CSS khusus buat nambahin background grid tipis
  kayak di contoh. Kita "push" style ini ke @stack('styles') 
  yang ada di layouts/app.blade.php lo.
--}}
@push('styles')
@endpush


{{-- Ini adalah konten Hero Section-nya --}}
@section('content')
    
    {{-- Kita pake class .hero-grid-bg yang kita definisiin di atas --}}
    <section class="relative overflow-hidden hero-grid-bg">
        {{-- Kontainer utama --}}
        <div class="container mx-auto px-4 py-20 md:py-32 text-center">

            {{-- 1. Banner "New" di atas --}}
            <div class="flex flex-wrap justify-center items-center gap-2 md:gap-4 mb-6">
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">New</span>
                <span class="text-sm text-gray-700">Catch up on what we released at Next.js Conf 25</span>
                
                {{-- Tombol "Find out more" (versi lebih simpel) --}}
                <a href="#" class="bg-black text-white text-sm px-3 py-1.5 rounded-full font-medium hover:bg-gray-800 transition-colors">
                    Find out more &rarr;
                </a>
                
                {{-- Tombol "Watch the recap" --}}
                <a href="#" class="text-sm font-medium text-gray-800 hover:text-black transition-colors">
                    Watch the recap &rarr;
                </a>
            </div>

            {{-- 2. Headline Utama --}}
            <h1 class="text-5xl sm:text-6xl md:text-8xl font-bold tracking-tighter mb-6 text-gray-900">
                The React Framework <br class="hidden md:block"> for the Web
            </h1>

            {{-- 3. Sub-headline / Deskripsi --}}
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-10">
                Used by some of the world's largest companies, Next.js enables you to create 
                <strong class="text-gray-900">high-quality web applications</strong> 
                with the power of React components.
            </p>

            {{-- 4. Tombol Call to Action (CTA) --}}
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-4">
                {{-- Tombol Hitam --}}
                <a href="#" class="w-full sm:w-auto bg-black text-white px-5 py-3 rounded-md font-semibold text-lg hover:bg-gray-800 transition-colors">
                    Get Started
                </a>
                {{-- Tombol Putih --}}
                <a href="#" class="w-full sm:w-auto bg-white text-black border border-gray-300 px-5 py-3 rounded-md font-semibold text-lg hover:bg-gray-50 transition-colors">
                    Learn Next.js
                </a>
            </div>

            {{-- 5. Command Line Hint --}}
            <p class="text-sm text-gray-500 font-mono">
                <span class="text-gray-400">▲</span> ~ npx create-react-app@latest
            </p>

        </div>
    </section>

@endsection