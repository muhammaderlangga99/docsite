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
    <section class="relative overflow-hidden hero-grid-bg px-3 pt-24 pb-10 min-h-screen flex">
        <div class="pointer-events-none absolute inset-0">
                <div class="absolute hidden md:inline-block -left-20 -top-24 h-80 w-80 rounded-full bg-blue-100/70 blur-3xl"></div>
                <div class="absolute hidden md:inline-block right-10 top-10 h-72 w-72 rounded-full bg-indigo-100/70 blur-3xl"></div>
                <div class="absolute hidden md:inline-block -bottom-16 left-1/3 h-64 w-64 rounded-full bg-sky-100/70 blur-3xl"></div>
        </div>
        {{-- Kontainer utama --}}
        <div class="container m-auto">
            <div class="grid items-center gap-12 lg:grid-cols-[1.05fr_0.95fr] lg:gap-16">
                <div class="order-2 space-y-6 lg:order-1">
                    <p class="inline-flex items-center gap-2 rounded-full border border-blue-100/70 bg-white/80 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-blue-600/80 shadow-sm">
                        Payments Platform
                    </p>
                    {{-- 2. Headline Utama --}}
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-semibold md:font-[700] tracking-tight text-gray-900 leading-tight">
                        The Payment Integration Platform by
                        <span class="relative inline-flex items-center gap-2">
                            <span class="absolute inset-x-0 -bottom-1 h-2 rounded-full bg-gradient-to-r from-blue-100/80 via-blue-100/70 to-blue-50/80"></span>
                            <img src="/img/logo-nav.png" class="relative h-8 md:h-12 inline -translate-y-1" alt="">
                        </span>
                    </h1>

                    {{-- 3. Sub-headline / Deskripsi --}}
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed">
                        Used by merchants and partners across industries, cashUP provides a robust API that makes it easy to integrate secure and scalable payment solutions into your applications.
                    </p>

                    {{-- 4. Tombol Call to Action (CTA) --}}
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ url('docs/introduction') }}"  class="w-full text-center sm:w-auto bg-black text-white px-6 py-3.5 rounded-xl font-semibold text-base hover:bg-gray-800 transition-colors shadow-[0_14px_30px_rgba(15,23,42,0.2)]">
                            Get Started
                        </a>
                        <a href="https://cashup.id" class="w-full sm:w-auto bg-white text-center text-black border border-gray-200 px-6 py-3.5 rounded-xl font-semibold text-base hover:bg-gray-50 transition-colors shadow-sm">
                            About Us
                        </a>
                    </div>

                    <div class="grid gap-4 pt-2 sm:grid-cols-3 text-sm text-gray-500">
                        <div class="rounded-2xl border border-gray-100 bg-white/80 px-4 py-3 shadow-sm">
                            <p class="text-base font-semibold text-gray-900">99.9%</p>
                            <p class="text-xs uppercase tracking-[0.18em] text-gray-500">Uptime SLA</p>
                        </div>
                        <div class="rounded-2xl border border-gray-100 bg-white/80 px-4 py-3 shadow-sm">
                            <p class="text-base font-semibold text-gray-900">500+</p>
                            <p class="text-xs uppercase tracking-[0.18em] text-gray-500">Merchants</p>
                        </div>
                        <div class="rounded-2xl border border-gray-100 bg-white/80 px-4 py-3 shadow-sm">
                            <p class="text-base font-semibold text-gray-900">24/7</p>
                            <p class="text-xs uppercase tracking-[0.18em] text-gray-500">Monitoring</p>
                        </div>
                    </div>
                </div>

                <div class="relative order-1 lg:order-2">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-2xl bg-gradient-to-br from-blue-200/70 to-blue-100/60 blur-xl"></div>
                    <div class="relative rounded-[28px]  bg-white p-5">
                        <img src="/img/docs-home.png" alt="cashUP Docs" class="w-full rounded-2xl">
                        <div class="absolute -left-8 bottom-10 hidden w-40 rounded-2xl border border-gray-100 bg-white p-4 shadow-[0_16px_32px_rgba(15,23,42,0.12)] lg:block">
                            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">API LATENCY</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">120ms</p>
                            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-gray-100">
                                <div class="h-full w-3/4 rounded-full bg-gradient-to-r from-blue-500 to-blue-400"></div>
                            </div>
                        </div>
                        <div class="absolute -right-6 top-8 hidden w-36 rounded-2xl border border-gray-100 bg-white p-4 shadow-[0_16px_32px_rgba(15,23,42,0.12)] lg:block">
                            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">TRANSACTIONS</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">2.4M</p>
                            <p class="text-xs text-gray-500">Monthly processed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white border-t border-gray-100">
        <div class="container mx-auto px-3 py-10">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                    Trusted, Secure, and Fully Regulated
                </p>
                <p class="mt-2 text-base text-gray-600 leading-relaxed">
                    Built for mission-critical payments with enterprise-grade security and nationwide reach.
                </p>
            </div>

            <div class="mt-6 flex gap-4 overflow-x-auto pb-2 md:flex-nowrap md:overflow-visible">
                <div class="flex shrink-0 items-center gap-3 rounded-xl bg-white px-4 py-2 ring-1 ring-gray-200/70 shadow-[0_6px_14px_rgba(15,23,42,0.08)] transition-all duration-200 hover:ring-blue-200/80 hover:shadow-[0_0_0_4px_rgba(37,99,235,0.12)]">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z" />
                        </svg>
                    </span>
                    <span class="text-sm font-semibold text-gray-800">Regulated by Bank Indonesia</span>
                </div>
                <div class="flex shrink-0 items-center gap-3 rounded-xl bg-white px-4 py-2 ring-1 ring-gray-200/70 shadow-[0_6px_14px_rgba(15,23,42,0.08)] transition-all duration-200 hover:ring-blue-200/80 hover:shadow-[0_0_0_4px_rgba(37,99,235,0.12)]">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 4H8a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9h6m-6 4h6" />
                        </svg>
                    </span>
                    <span class="text-sm font-semibold text-gray-800">PCI DSS Ready</span>
                </div>
                <div class="flex shrink-0 items-center gap-3 rounded-xl bg-white px-4 py-2 ring-1 ring-gray-200/70 shadow-[0_6px_14px_rgba(15,23,42,0.08)] transition-all duration-200 hover:ring-blue-200/80 hover:shadow-[0_0_0_4px_rgba(37,99,235,0.12)]">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </span>
                    <span class="text-sm font-semibold text-gray-800">ISO 27001 Certified</span>
                </div>
                <div class="flex shrink-0 items-center gap-3 rounded-xl bg-white px-4 py-2 ring-1 ring-gray-200/70 shadow-[0_6px_14px_rgba(15,23,42,0.08)] transition-all duration-200 hover:ring-blue-200/80 hover:shadow-[0_0_0_4px_rgba(37,99,235,0.12)]">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 11h6m-6 4h6" />
                        </svg>
                    </span>
                    <span class="text-sm font-semibold text-gray-800">500+ Active Merchants</span>
                </div>
                <div class="flex shrink-0 items-center gap-3 rounded-xl bg-white px-4 py-2 ring-1 ring-gray-200/70 shadow-[0_6px_14px_rgba(15,23,42,0.08)] transition-all duration-200 hover:ring-blue-200/80 hover:shadow-[0_0_0_4px_rgba(37,99,235,0.12)]">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16M12 4v16" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </span>
                    <span class="text-sm font-semibold text-gray-800">Nationwide Payment Coverage</span>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white border-t border-gray-100">
        <div class="bg-gradient-to-b from-blue-50/40 via-white to-white">
            <div class="container mx-auto px-3 py-14">
                <div class="max-w-3xl">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-gray-900">
                        Everything You Need to Accept Payments in Indonesia
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-gray-600 leading-relaxed">
                        One powerful platform to integrate Mini ATM, QRIS, Web Payments, Card Payments, and POS-to-EDC automation.
                    </p>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_10px_24px_rgba(15,23,42,0.08)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_16px_30px_rgba(15,23,42,0.12)]">
                        <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 ring-1 ring-blue-100">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 11h16" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15h6" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Mini ATM</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Balance inquiry, transfer, and cash withdrawal directly from your system.
                        </p>
                    </div>

                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_10px_24px_rgba(15,23,42,0.08)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_16px_30px_rgba(15,23,42,0.12)]">
                        <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 ring-1 ring-blue-100">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 3h8a2 2 0 012 2v14a2 2 0 01-2 2H8a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h10M7 16h10" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">QRIS</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Dynamic and static QR payments compliant with Bank Indonesia standard.
                        </p>
                    </div>

                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_10px_24px_rgba(15,23,42,0.08)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_16px_30px_rgba(15,23,42,0.12)]">
                        <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 ring-1 ring-blue-100">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 7h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 11h6" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11h1" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Cashlez Link</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Web-based payments for cards, virtual accounts, and QRIS with auto callback.
                        </p>
                    </div>

                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_10px_24px_rgba(15,23,42,0.08)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_16px_30px_rgba(15,23,42,0.12)]">
                        <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 ring-1 ring-blue-100">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 11h18" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 15h3" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Credit &amp; Debit Card Payment</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Real-time debit and credit card transactions with transaction history API.
                        </p>
                    </div>

                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_10px_24px_rgba(15,23,42,0.08)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_16px_30px_rgba(15,23,42,0.12)]">
                        <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 ring-1 ring-blue-100">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8h6M9 12h6M9 16h4" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">ERICA (ECR API)</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Trigger EDC transactions directly from your POS system.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-t border-gray-100 bg-white">
        <div class="bg-gradient-to-b from-white via-white to-blue-50/30">
            <div class="container mx-auto px-3 py-14">
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600/80">
                        Flexible Integration Models
                    </p>
                    <h2 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-gray-900">
                        Flexible Integration Models
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-gray-600">
                        Choose the integration style that matches your product architecture and operational flow.
                    </p>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_10px_22px_rgba(15,23,42,0.08)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_0_0_4px_rgba(37,99,235,0.08)]">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 ring-1 ring-blue-100">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <rect x="3.5" y="5" width="8" height="14" rx="2"></rect>
                                <rect x="12.5" y="5" width="8" height="14" rx="2"></rect>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6"></path>
                            </svg>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">App-to-App</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Dual app experience on a single device for fast payment handoff.
                        </p>
                    </div>

                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_10px_22px_rgba(15,23,42,0.08)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_0_0_4px_rgba(37,99,235,0.08)]">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 ring-1 ring-blue-100">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <rect x="3" y="6" width="7" height="12" rx="2"></rect>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 12h4"></path>
                                <rect x="14.5" y="7" width="6.5" height="10" rx="2"></rect>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.5 10h1.5M17.5 13h1.5"></path>
                            </svg>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Host-to-Host</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            Direct API integration with companion app support for device actions.
                        </p>
                    </div>

                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_10px_22px_rgba(15,23,42,0.08)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_0_0_4px_rgba(37,99,235,0.08)]">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 ring-1 ring-blue-100">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <rect x="2.5" y="6" width="6" height="8" rx="1.5"></rect>
                                <rect x="9.5" y="9" width="5" height="6" rx="1.5"></rect>
                                <rect x="16.5" y="7" width="5.5" height="10" rx="1.5"></rect>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 10h1M14.5 12h1"></path>
                            </svg>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">ERICA</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            POS to API to EDC orchestration with automated transaction control.
                        </p>
                    </div>

                    <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_10px_22px_rgba(15,23,42,0.08)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_0_0_4px_rgba(37,99,235,0.08)]">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 ring-1 ring-blue-100">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <rect x="3" y="6" width="7" height="10" rx="2"></rect>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 11h4"></path>
                                <rect x="16" y="5.5" width="5" height="11" rx="2"></rect>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 13c1.5-1.5 2.5-2 4-2"></path>
                            </svg>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">CARLA</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            POS to EDC via cable for reliable, low latency in-store flows.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-t border-gray-100 bg-white">
        <div class="bg-gradient-to-r from-white via-white to-blue-50/40">
            <div class="container mx-auto px-3 py-14">
                <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600/80">
                            SANDBOX &amp; API PLAYGROUND
                        </p>
                        <h2 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-gray-900">
                            Build, Test, and Go Live with Confidence
                        </h2>
                        <p class="mt-4 text-base sm:text-lg text-gray-600 leading-relaxed">
                            A developer-first staging area that mirrors production behavior with clear telemetry and
                            streamlined onboarding for enterprise teams.
                        </p>

                        <div class="mt-6 space-y-3">
                            <div class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5l3 3 8-8"></path>
                                    </svg>
                                </span>
                                Live API Playground (OpenAPI / Scalar)
                            </div>
                            <div class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5l3 3 8-8"></path>
                                    </svg>
                                </span>
                                Auto-Generated API Credentials
                            </div>
                            <div class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5l3 3 8-8"></path>
                                    </svg>
                                </span>
                                Real-Time Request &amp; Response Preview
                            </div>
                            <div class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5l3 3 8-8"></path>
                                    </svg>
                                </span>
                                Environment Switcher (Staging / Production)
                            </div>
                            <div class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5l3 3 8-8"></path>
                                    </svg>
                                </span>
                                Example Code Snippets
                            </div>
                        </div>

                        <div class="mt-8">
                            <a href="{{ url('docs/introduction') }}" class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(15,23,42,0.18)] transition hover:bg-gray-800">
                                Open API Playground
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-2xl bg-gradient-to-br from-blue-100/60 to-indigo-100/60 blur-2xl"></div>
                        <div class="relative rounded-2xl border border-gray-200 bg-white shadow-[0_16px_34px_rgba(15,23,42,0.12)]">
                            <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3">
                                <span class="text-xs font-semibold text-gray-500">POST</span>
                                <span class="text-sm font-semibold text-gray-900">/v1/payments</span>
                                <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-600">Staging</span>
                            </div>
                            <div class="flex gap-2 border-b border-gray-200 px-4 py-2 text-xs font-semibold text-gray-500">
                                <span class="rounded-full bg-gray-900 px-3 py-1 text-white">Request</span>
                                <span class="rounded-full px-3 py-1">Response</span>
                            </div>
                            <div class="grid gap-4 p-4 text-xs">
                                <div class="rounded-xl bg-gray-900 px-4 py-3 font-mono text-[11px] leading-relaxed text-emerald-50">
                                    <div class="text-gray-400">{</div>
                                    <div class="ml-4 text-emerald-200">"amount": 125000,</div>
                                    <div class="ml-4 text-emerald-200">"currency": "IDR",</div>
                                    <div class="ml-4 text-emerald-200">"reference_id": "INV-239812",</div>
                                    <div class="ml-4 text-emerald-200">"payment_method": "QRIS"</div>
                                    <div class="text-gray-400">}</div>
                                </div>
                                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 font-mono text-[11px] leading-relaxed text-emerald-900">
                                    <div class="text-emerald-700">{</div>
                                    <div class="ml-4">"status": "success",</div>
                                    <div class="ml-4">"payment_id": "pay_7f3d8a2",</div>
                                    <div class="ml-4">"qr_string": "000201010211...6304",</div>
                                    <div class="ml-4">"created_at": "2026-01-02T10:14:22Z"</div>
                                    <div class="text-emerald-700">}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-t border-[#e5e7eb] bg-gradient-to-b from-white via-[#f6f8fc] to-[#e9eff9]">
        <div class="container mx-auto px-3 py-14">
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="text-base font-semibold text-slate-900">Company</p>
                    <div class="mt-4 space-y-2 text-base text-slate-500">
                        <a href="#" class="block transition hover:text-blue-600">About Cashlez</a>
                        <a href="#" class="block transition hover:text-blue-600">Careers</a>
                        <a href="#" class="block transition hover:text-blue-600">Blog</a>
                        <a href="#" class="block transition hover:text-blue-600">Contact Us</a>
                    </div>
                </div>
                <div>
                    <p class="text-base font-semibold text-slate-900">Products</p>
                    <div class="mt-4 space-y-2 text-base text-slate-500">
                        <a href="#" class="block transition hover:text-blue-600">Mini ATM (CashMove API)</a>
                        <a href="#" class="block transition hover:text-blue-600">QRIS API</a>
                        <a href="#" class="block transition hover:text-blue-600">Cashlez Link</a>
                        <a href="#" class="block transition hover:text-blue-600">Card Payment API</a>
                        <a href="#" class="block transition hover:text-blue-600">ERICA &amp; CARLA</a>
                    </div>
                </div>
                <div>
                    <p class="text-base font-semibold text-slate-900">Developers</p>
                    <div class="mt-4 space-y-2 text-base text-slate-500">
                        <a href="#" class="block transition hover:text-blue-600">API Documentation</a>
                        <a href="#" class="block transition hover:text-blue-600">Sandbox &amp; Playground</a>
                        <a href="#" class="block transition hover:text-blue-600">Integration Models</a>
                        <a href="#" class="block transition hover:text-blue-600">System Status</a>
                        <a href="#" class="block transition hover:text-blue-600">Changelog</a>
                    </div>
                </div>
                <div>
                    <p class="text-base font-semibold text-slate-900">Legal</p>
                    <div class="mt-4 space-y-2 text-base text-slate-500">
                        <a href="#" class="block transition hover:text-blue-600">Terms of Service</a>
                        <a href="#" class="block transition hover:text-blue-600">Privacy Policy</a>
                        <a href="#" class="block transition hover:text-blue-600">Compliance</a>
                    </div>
                </div>
            </div>

            <div class="mt-10 border-t border-[#e5e7eb] pt-6">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-slate-500">
                        © 2026 PT Cashlez Worldwide Indonesia Tbk. All rights reserved.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-400 transition hover:border-blue-200 hover:text-blue-500">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 8a6 6 0 01-6 6H6v-2h4a4 4 0 000-8H6V2h4a6 6 0 016 6z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4v10h-4z"></path>
                            </svg>
                        </a>
                        <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-400 transition hover:border-blue-200 hover:text-blue-500">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19c-4-1-6-6-4-10 1-2 3-3 5-3"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5c4 1 6 6 4 10-1 2-3 3-5 3"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>
                        <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-400 transition hover:border-blue-200 hover:text-blue-500">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 9l5 3-5 3V9z"></path>
                                <rect x="3" y="6" width="18" height="12" rx="3"></rect>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@endsection




