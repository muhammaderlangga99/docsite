@props(['user'])

@php
    $appUrl = rtrim(config('app.url'), '/');
    $items = [
        [
            'label' => 'Overview',
            'icon' => '<span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span>',
            'url' => $appUrl . '/dashboard',
            'active' => request()->routeIs('dashboard'),
        ],
    ];

    $credentialItems = [
        [
            'label' => 'Erica',
            'icon' => '🪪',
            'url' => $appUrl . '/erica',
            'active' => request()->routeIs('erica.*'),
        ],
    ];
@endphp

<aside {{ $attributes->class('w-72 md:w-64 bg-zinc-100 text-slate-900 h-full overflow-y-auto border-r border-zinc-200') }}>
    <div class="px-6 py-6 border-b border-zinc-200">
        <div class="flex items-center gap-3">
            @if($user?->avatar)
                <img src="{{ $user->avatar }}" alt="Avatar" class="w-12 h-12 rounded-full border border-zinc-200">
            @else
                <div class="w-12 h-12 rounded-full bg-zinc-200 flex items-center justify-center text-lg font-semibold text-slate-800">
                    {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                </div>
            @endif
            <div>
                <p class="text-sm text-slate-500">Signed in</p>
                <p class="text-base font-semibold text-slate-900">{{ $user?->name ?? 'Guest' }}</p>
            </div>
        </div>
    </div>

    <nav class="px-3 py-4 space-y-1">
        @foreach($items as $item)
            <a href="{{ $item['url'] }}"
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                      {{ $item['active'] ? 'bg-zinc-200 text-slate-900' : 'text-slate-700 hover:bg-zinc-200' }}">
                <span>{!! $item['icon'] !!}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach

        <div class="pt-5 pb-2 px-3 text-[11px] uppercase tracking-[0.08em] text-slate-500">Credentials</div>
        @foreach($credentialItems as $item)
            <a href="{{ $item['url'] }}"
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                      {{ $item['active'] ? 'bg-zinc-200 text-slate-900' : 'text-slate-700 hover:bg-zinc-200' }}">
                <span>{{ $item['icon'] }}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="px-6 pb-6 mt-auto">
        <form action="{{ $appUrl }}/logout" method="POST">
            @csrf
            <button type="submit" class="w-full text-sm font-medium bg-slate-900 text-white py-2.5 rounded-lg hover:bg-slate-800 transition">
                Logout
            </button>
        </form>
    </div>
</aside>
