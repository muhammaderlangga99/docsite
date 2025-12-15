@props(['user', 'mid' => null])

@php
    $items = [
        [
            'label' => 'App2App',
            'icon' => '',
            'url' => url('/dashboard'),
            'active' => request()->routeIs('dashboard'),
        ],
    ];

    $credentialItems = [
        [
            'label' => 'ECR Credentials',
            'icon' => '',
            'url' => url('/erica'),
            'active' => request()->routeIs('erica.*'),
        ],
        [
            'label' => 'Mini ATM Credentials',
            'icon' => '',
            'url' => url('/mini-atm'),
            'active' => request()->routeIs('mini-atm.*'),
        ],
        [
            'label' => 'CashLink Credentials',
            'icon' => '',
            'url' => url('/cashlink'),
            'active' => request()->routeIs('cashlink.*'),
        ],
    ];
@endphp

<aside {{ $attributes->class('w-72 bg-white md:w-72 text-slate-900 h-full overflow-y-auto border-r border-zinc-100 flex flex-col') }}>
    <nav class="px-3 py-4 space-y-1">
        <div class="pt-5 pb-2 px-3 text-[11px] uppercase tracking-[0.08em] text-slate-500">Dashboard</div>
        @foreach($items as $item)
            <a href="{{ $item['url'] }}"
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                      {{ $item['active'] ? 'bg-zinc-100 text-slate-900' : 'text-slate-700 hover:bg-zinc-200' }}">
                <span>{!! $item['icon'] !!}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach

        <div class="pt-5 pb-2 px-3 text-[11px] uppercase tracking-[0.08em] text-slate-500">Host2Host</div>
        @foreach($credentialItems as $item)
            <a href="{{ $item['url'] }}"
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                      {{ $item['active'] ? 'bg-zinc-100 text-slate-900' : 'text-slate-700 hover:bg-zinc-200' }}">
                <span>{{ $item['icon'] }}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-auto" x-data="{ open: false }" @keydown.window.escape="open = false">
        <button
            type="button"
            class="w-full flex items-center justify-between gap-3 px-3 py-3 rounded-xl bg-white text-left transition"
            @click="open = !open"
        >
            <div class="flex items-center gap-3">
                @if($user?->avatar)
                    <img src="{{ $user->avatar }}" alt="Avatar" class="w-11 h-11 rounded-full border border-zinc-200">
                @else
                    <div class="w-11 h-11 rounded-full bg-zinc-200 flex items-center justify-center text-base font-semibold text-slate-800">
                        {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                    </div>
                @endif
                <div>
                    <p class="text-xs text-slate-500">Signed in</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $user?->name ?? 'Guest' }}</p>
                    <p class="text-xs text-slate-500">{{ '@' . ($user->username ?? 'guest') }}</p>
                </div>
            </div>
            <svg class="w-4 h-4 text-slate-500 transition-transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </button>

        <div x-show="open" x-transition.opacity class="fixed inset-0 z-40" @click="open = false" style="display: none;"></div>

        <div
            x-show="open"
            x-transition
            class="fixed inset-x-4 bottom-6 z-50 md:inset-x-auto md:left-6 md:right-6 md:bottom-8"
            style="display: none;"
        >
            <div class="w-full max-w-sm ml-auto mr-auto md:ml-0 md:mr-0 rounded-2xl border border-zinc-200 bg-white shadow-2xl shadow-black/10 overflow-hidden">
                <div class="px-4 py-3 border-b border-zinc-100 flex items-center gap-3">
                    @if($user?->avatar)
                        <img src="{{ $user->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full border border-zinc-200">
                    @else
                        <div class="w-10 h-10 rounded-full bg-zinc-200 flex items-center justify-center text-base font-semibold text-slate-800">
                            {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-slate-500">Signed in</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $user?->name ?? 'Guest' }}</p>
                        <p class="text-xs text-slate-500">{{ '@' . ($user->username ?? 'guest') }}</p>
                    </div>
                </div>

                <div class="px-4 py-3 border-b border-zinc-100 bg-slate-50">
                    <dl class="space-y-2 text-xs text-slate-700">
                        <div class="flex justify-between gap-3">
                            <dt class="text-slate-500">Password</dt>
                            <dd class="font-semibold text-slate-900">12345678</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-slate-500">Device ID</dt>
                            <dd class="font-semibold text-slate-900 break-all text-right">{{ $user?->device_id ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-slate-500">MID</dt>
                            <dd class="font-semibold text-slate-900 text-right">{{ $mid ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="p-2 space-y-1">
                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-rose-600 hover:bg-rose-50 transition">
                            <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>
