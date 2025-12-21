{{-- resources/views/layouts/docs.blade.php --}}

{{-- Numpang ke layout utama lo --}}
@extends('layout.app') 

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@scalar/api-reference@latest/dist/style.css">
    <style>
        .scalar-modal {
            align-items: center;
            display: none;
            justify-content: center;
            left: 0;
            top: 0;
        }
        .scalar-modal.is-open {
            display: flex;
        }
        .scalar-panel {
            max-height: 92vh;
        }
    </style>
@endpush

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
         
    <div class="flex flex-col md:flex-row gap-8 py-8 lg:w-[87%] mx-auto">
        
        {{-- KOLOM 1: SIDEBAR NAVIGASI (Kiri) --}}
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

<div class="scalar-modal fixed inset-0 z-[9999] bg-black/60 px-4 py-6" id="scalar-modal" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="scalar-panel relative w-full max-w-6xl overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
            <div class="text-sm font-semibold text-slate-800" id="scalar-title">API Playground</div>
            <button type="button" id="scalar-close"
                    class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                Close
            </button>
        </div>
        <div class="h-[78vh] overflow-hidden bg-white" id="scalar-root"></div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module">
        window.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('scalar-modal');
            const closeBtn = document.getElementById('scalar-close');
            const root = document.getElementById('scalar-root');
            const title = document.getElementById('scalar-title');
            let scalarApp = null;
            const defaultTrigger = document.querySelector('[data-scalar-spec]');

            if (!modal || !root) return;

            const openModal = async (trigger) => {
                const specUrl = trigger?.dataset?.scalarSpec;
                if (!specUrl) {
                    console.warn('Scalar spec URL is missing.');
                    return;
                }

                let operationId = trigger?.dataset?.scalarOperationId || null;
                const method = trigger?.dataset?.scalarMethod || null;
                const path = trigger?.dataset?.scalarPath || null;

                title.textContent = 'API Playground';
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');

                if (scalarApp) {
                    root.innerHTML = '';
                    scalarApp = null;
                }

                const { createApiReference } = await import('https://esm.sh/@scalar/api-reference@latest');
                if (!operationId && method && path) {
                    operationId = await resolveOperationId(specUrl, method, path);
                }

                scalarApp = createApiReference(root, {
                    spec: { url: specUrl },
                    layout: 'modern',
                    showSidebar: false,
                    hideModels: true,
                    darkMode: false,
                    forceDarkModeState: 'light',
                });

                if (operationId) {
                    window.location.hash = `#operation/${operationId}`;
                }

            };

            const openModalFromHash = async () => {
                if (!defaultTrigger) return;

                const hash = window.location.hash || '';
                if (hash.startsWith('#operation/')) {
                    const operationId = decodeURIComponent(hash.replace('#operation/', '').trim());
                    if (!operationId) return;
                    await openModal({
                        dataset: {
                            scalarSpec: defaultTrigger.dataset.scalarSpec,
                            scalarOperationId: operationId,
                        },
                    });
                    return;
                }

                if (hash.startsWith('#tag/')) {
                    const parts = hash.split('/').filter(Boolean);
                    if (parts.length < 4) return;
                    const method = parts[2];
                    const path = '/' + parts.slice(3).join('/');
                    await openModal({
                        dataset: {
                            scalarSpec: defaultTrigger.dataset.scalarSpec,
                            scalarMethod: method,
                            scalarPath: path,
                        },
                    });
                }
            };

            const closeModal = () => {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                root.innerHTML = '';
                scalarApp = null;
            };

            document.addEventListener('click', (event) => {
                const trigger = event.target.closest('[data-scalar-spec]');
                if (!trigger) return;
                event.preventDefault();
                openModal(trigger);
            });

            closeBtn?.addEventListener('click', closeModal);
            modal.addEventListener('click', (event) => {
                if (event.target === modal) closeModal();
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                    closeModal();
                }
            });
            openModalFromHash();
            const specCache = new Map();

            const resolveOperationId = async (specUrl, method, path) => {
                const specText = await loadSpec(specUrl);
                if (!specText) return null;

                const upperMethod = method.toLowerCase();
                const json = tryParseJson(specText);
                if (json?.paths?.[path]?.[upperMethod]?.operationId) {
                    return json.paths[path][upperMethod].operationId;
                }

                return findOperationIdFromYaml(specText, upperMethod, path);
            };

            const loadSpec = async (specUrl) => {
                if (specCache.has(specUrl)) {
                    return specCache.get(specUrl);
                }
                try {
                    const response = await fetch(specUrl, { credentials: 'same-origin' });
                    if (!response.ok) return null;
                    const text = await response.text();
                    specCache.set(specUrl, text);
                    return text;
                } catch (error) {
                    console.warn('Failed to load spec URL.', error);
                    return null;
                }
            };

            const tryParseJson = (text) => {
                try {
                    return JSON.parse(text);
                } catch (error) {
                    return null;
                }
            };

            const findOperationIdFromYaml = (text, method, path) => {
                const lines = text.split(/\r?\n/);
                const pathRegex = new RegExp(`^\\s{2}${escapeRegex(path)}:\\s*$`);
                let inPath = false;
                let inMethod = false;

                for (const line of lines) {
                    if (!inPath && pathRegex.test(line)) {
                        inPath = true;
                        inMethod = false;
                        continue;
                    }

                    if (inPath) {
                        if (/^\\s{2}\\S/.test(line)) {
                            break;
                        }

                        const methodRegex = new RegExp(`^\\s{4}${method}:\\s*$`, 'i');
                        if (methodRegex.test(line)) {
                            inMethod = true;
                            continue;
                        }

                        if (inMethod) {
                            if (/^\\s{4}\\S/.test(line)) {
                                inMethod = false;
                                continue;
                            }

                            const match = line.match(/^\\s{6}operationId:\\s*(.+)\\s*$/);
                            if (match) {
                                return match[1].trim();
                            }
                        }
                    }
                }

                return null;
            };

            const escapeRegex = (value) => value.replace(/[.*+?^${}()|[\\]\\\\]/g, '\\\\$&');
        });
    </script>
@endpush
