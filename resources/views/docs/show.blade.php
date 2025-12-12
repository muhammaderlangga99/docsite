@extends('layout.docs')

{{--
  Struktur file ini:
  Cek dulu, ini halaman artikel atau halaman kategori?
--}}

@push('styles')
<style>
    /* (BONUS) Bikin scroll-nya jadi alus, nggak loncat
    */
    html {
        scroll-behavior: smooth;
    }

    /* (INI INTI-NYA)
      Target H2/H3 yang ada di dalem class 'prisa' kamu
    */
    .prisa h2,
    .prisa h3 {
        /* Kasih "ganjelan" di atas heading-nya.
          Ganti 80px ini. Angka ini idealnya adalah
          tinggi dari navbar kamu yang nempel di atas (sticky header) + sedikit padding.
        */
        scroll-margin-top: 80px;
    }
</style>
@endpush

@if($doc)

    {{--
      ======================================================
      LANGKAH 1: PROSES KONTEN & BUAT TOC (PHP MANUAL)
      Kita lakukan ini di atas SEBELUM render HTML-nya
      ======================================================
    --}}
    @php
        $toc_headings = []; // Variabel untuk nampung daftar isi (TOC)
        $content_with_ids = ''; // Variabel untuk nampung konten yg sudah di-inject ID
        $index = 0; // Untuk bikin ID unik

        // 1. Konversi Markdown ke HTML dulu
        $htmlContent = Str::markdown($doc->content);

        // 2. Cari semua H2/H3, inject ID, dan simpan ke $toc_headings
        $content_with_ids = preg_replace_callback(
            '~<(h2|h3)(.*?)>(.*?)</\1>~si', // Regex: cari <h2...>...</h2> atau <h3...>...</h3>
            function ($matches) use (&$toc_headings, &$index) {

                $tag = $matches[1];        // 'h2' or 'h3'
                $attributes = $matches[2]; // ' class="foo"' (jika ada)
                $innerText = $matches[3];  // 'Isi Teks Judul'

                // 3. Bersihkan teks (buang tag lain jika ada di dalam H2)
                $cleanText = strip_tags($innerText);

                // 4. Buat ID (slug) yang unik
                $slug = Str::slug($cleanText) . '-' . $index;
                $index++; // Inkrement index biar ID selalu unik

                // 5. Simpan ke array TOC
                $toc_headings[] = [
                    'id' => $slug,
                    'text' => $cleanText,
                    'level' => $tag // 'h2' or 'h3'
                ];

                // 6. Kembalikan tag HTML-nya TAPI dengan ID baru yang di-inject
                return '<' . $tag . $attributes . ' id="' . $slug . '">' . $innerText . '</' . $tag . '>';
            },
            $htmlContent
        );
    @endphp


    {{--
      ======================================================
      LANGKAH 2: TAMPILKAN KONTEN ARTIKEL
      ======================================================
    --}}
    @section('doc-content')
        {{-- Breadcrumbs lo --}}
        <div class="text-sm text-gray-500 mb-4">
            @if($doc->category)
                {{-- <a href="https://docs.cashup.test/docs/category/{{ $doc->category->slug }}" class="hover:underline">
                    {{ $doc->category->title }}
                </a> --}}
                <a href="{{ url('docs/category/' . $doc->category->slug) }}" class="hover:underline">
                    {{ $doc->category->title }}
                </a>
                <span class="mx-2">&gt;</span>
                <span>{{ $doc->name }}</span>
            @endif
        </div>

        <h1 class="text-4xl font-bold mb-2">{{ $doc->name }}</h1>
        <p class="mb-5 text-xs text-zinc-400">Author: {{ $doc->author? $doc->author : 'Unknown' }}</p>

        {{-- thumbnail --}}
        @if($doc->thumbnail)
            <img src="{{ $doc->thumbnail }}" alt="{{ $doc->name }}" class="mb-5 rounded-lg">
        @endif
        {{-- Customisasi 'prisa' kamu, aman. --}}
        <div class="prisa max-w-none" id="doc-content-area">
            {{-- Tampilkan konten yang sudah di-inject ID --}}
            {!! $content_with_ids !!}
        </div>
    @endsection


    {{--
      ======================================================
      LANGKAH 3: TAMPILKAN DAFTAR ISI (TOC) MANUAL
      ======================================================
    --}}
    @section('toc')
        <div class="sticky top-24">
            <h3 class="text-sm font-medium uppercase text-gray-700">On This Page</h3>

            {{-- Kita pakai @forelse biasa, BUKAN <template x-for> --}}
            <ul class="mt-4 space-y-2 text-sm">
                @forelse($toc_headings as $heading)
                    <li>
                        <a href="#{{ $heading['id'] }}"
                           class="block text-gray-500 hover:text-gray-900 transition-colors
                                  @if($heading['level'] === 'h3') pl-2 text-gray-600 @endif
                                 ">
                            {{ $heading['text'] }}
                        </a>
                    </li>
                @empty
                    <li class="text-sm text-gray-400 italic">No sections found.</li>
                @endforelse
            </ul>
        </div>
    @endsection


    {{--
      ======================================================
      LANGKAH 4: KOSONGKAN SCRIPT
      ======================================================
    --}}
    @push('scripts')
        {{-- KOSONG. Kita tidak pakai Alpine.js 'toc()' lagi --}}
    @endpush


{{-- ================================================== --}}
{{-- BAGIAN 2: JIKA INI HALAMAN KATEGORI ($category)  --}}
{{-- ================================================== --}}
@elseif($category)

    {{-- Tampilkan Konten Kategori (daftar artikel) --}}
    @section('doc-content')
        {{-- Breadcrumbs lo --}}
        <div class="text-sm text-gray-500 mb-4">
            <span>{{ $category->title }}</span>
        </div>

        <h1 class="text-4xl font-bold mb-6">{{ $category->title }}</h1>

        {{-- ID #doc-content-area di sini gpp, karena script toc() nggak ke-load --}}
        <div class="prose prose-lg max-w-none" id="doc-content-area">
            <div>{{ $category->description }}</div>

            <h2 class="text-2xl font-bold mb-4 mt-24">Artikel di kategori ini:</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Loop @forelse lo --}}
                @forelse($category->posts as $post)
                 {{-- tampilkan yang deleted_at nya null  --}}
                    @if(is_null($post->deleted_at) && $post->is_published == 1)
                    <a href="{{ url('docs/' . $post->slug) }}" class="block border border-zinc-200 rounded-xl shadow hover:bg-gray-50 hover:border-gray-400">
                        @if($post->thumbnail)
                            <img src="{{ $post->thumbnail }}" alt="{{ $post->name }}" class="w-full h-40 object-cover rounded-md mb-3">
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-zinc-900">{{ $post->name }}</h3>
                            @php
                                // 1. Ubah dulu konten (yg mungkin Markdown) jadi HTML
                                $htmlContent = \Illuminate\Support\Str::markdown($post->content);

                                // 2. Baru cari <p> pertama di hasil HTML-nya
                                preg_match('~<p.*?>(.*?)</p>~si', $htmlContent, $p_matches);

                                // 3. Ambil isinya
                                $first_p = !empty($p_matches[1]) ? strip_tags($p_matches[1]) : '';
                            @endphp

                            {{-- Tampilkan hasilnya --}}
                            <p class="text-sm mt-2 text-gray-500">{{ Str::limit($first_p, 45, '...') }}</p>
                        </div>
                    </a>
                    @endif
                @empty
                    <p class="text-gray-500">Belum ada artikel di kategori ini.</p>
                @endforelse
            </div>
        </div>
    @endsection


    {{-- KOSONGIN SECTION TOC --}}
    @section('toc')
        {{-- Jangan isi apa-apa di sini --}}
    @endsection

@endif
