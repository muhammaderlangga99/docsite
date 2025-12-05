<nav class="space-y-4">
    {{-- Helper buat ngecek link aktif --}}
    @php
        $appUrl = rtrim(config('app.url'), '/');
        // Cek kalo Doc-nya aktif
        $isDocActive = fn($doc) => $doc?->id === $activeDoc?->id;
        // BARU: Cek kalo Category-nya aktif
        $isCategoryActive = fn($cat) => $cat?->id === $activeCategory?->id;
        @endphp


    {{-- 1. LOOPING POSTINGAN INDUK (Root Docs) --}}
    <h3 class="text-xs font-bold uppercase text-gray-500">Guides</h3>
    <ul class="space-y-5">
        @foreach($rootDocs->whereNull('deleted_at')->where('is_published', 1) as $doc)
            <li>
                <a href="{{ $appUrl }}/docs/{{ $doc->slug }}" 
                   class="block text-xs
                          {{ $isDocActive($doc) ? 'text-green-700' : 'text-gray-500' }}">
                    {{ $doc->name }}
                </a>
            </li>
        @endforeach
    </ul>

    @foreach($categories as $category)
        <div class="space-y-2" 
             x-data="{ 
                 // Accordion kebuka kalo:
                 // 1. Kategori-nya lagi aktif
                 // 2. ATAU, salah satu Doc di dalemnya lagi aktif
                 open: {{ ($isCategoryActive($category) || $category->id === $activeDoc?->category_id) ? 'true' : 'false' }} 
             }">
            
            {{-- INI YANG DI-UPGRADE TOTAL --}}
            <div class="flex justify-between items-center">
                {{-- A. LINK JUDUL KATEGORI (bisa diklik) --}}
                <a href="{{ $appUrl }}/docs/category/{{ $category->slug }}"
                   class="text-xs 
                          {{ $isCategoryActive($category) ? 'text-green-700' : 'text-gray-500 hover:text-gray-900' }}">
                    {{ $category->title }}
                </a>
                
                {{-- B. TOMBOL TOGGLE ACCORDION (chevron) --}}
                <button @click="open = !open" 
                        class="p-1 text-gray-500 rounded-md hover:bg-gray-100">
                    <svg class="w-4 h-4 transition-transform" 
                         :class="{ 'rotate-180': open }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            
            {{-- Konten Accordion (Daftar Postingan 'Anak') --}}
            <ul x-show="open" 
                x-transition
                class="space-y-4 pl-4 border-l border-gray-200" 
                style="display: none;">
                
                @foreach($category->posts->whereNull('deleted_at')->where('is_published', 1) as $doc)
                    <li>
                        <a href="{{ $appUrl }}/docs/{{ $doc->slug }}" 
                           class="block text-xs
                                  {{ $isDocActive($doc) ? ' text-green-700' : 'text-gray-600' }}">
                            {{ $doc->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</nav>
