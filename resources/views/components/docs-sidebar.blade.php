<nav class="space-y-4">
    {{-- Helper buat ngecek link aktif --}}
    @php
        // Cek kalo Doc-nya aktif
        $isDocActive = fn($doc) => $doc?->id === $activeDoc?->id;
        // BARU: Cek kalo Category-nya aktif
        $isCategoryActive = fn($cat) => $cat?->id === $activeCategory?->id;
        @endphp


    {{-- 1. LOOPING POSTINGAN INDUK (Root Docs) --}}
    <h3 class="text-xs font-bold uppercase text-gray-500">Guides</h3>
    <ul class="space-y-5">
        @foreach($rootDocs as $doc)
            <li>
                <a href="{{ route('docs.show', $doc->slug) }} " 
                   class="block text-xs uppercase
                          {{ $isDocActive($doc) ? 'text-blue-700' : 'text-gray-500' }}">
                    {{ $doc->name }}
                </a>
            </li>
        @endforeach
    </ul>

    {{-- 2. LOOPING KATEGORI (Accordion) --}}
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
                <a href="{{ route('docs.category.show', $category->slug) }}"
                   class="text-xs uppercase 
                          {{ $isCategoryActive($category) ? 'text-blue-700' : 'text-gray-500 hover:text-gray-900' }}">
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
                
                @foreach($category->posts as $doc)
                    <li>
                        <a href="{{ route('docs.show', $doc->slug) }}" 
                           class="block text-xs uppercase
                                  {{ $isDocActive($doc) ? ' text-blue-700' : 'text-gray-600' }}">
                            {{ $doc->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</nav>