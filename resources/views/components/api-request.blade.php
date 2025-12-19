@props([
    'method' => 'POST',
    'path' => '/',
    'protocol' => 'HTTP/1.1',
    'headers' => [],
    'body' => null,
    'buttonLabel' => 'Test it',
])

@php
    $methodColor = match (strtoupper($method)) {
        'GET' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'POST' => 'bg-amber-100 text-amber-800 border-amber-200',
        'PUT', 'PATCH' => 'bg-blue-100 text-blue-800 border-blue-200',
        'DELETE' => 'bg-rose-100 text-rose-800 border-rose-200',
        default => 'bg-slate-100 text-slate-800 border-slate-200',
    };

    $headerLines = collect($headers ?: [])->map(function ($value, $key) {
        return $key . ': ' . $value;
    })->implode("\n");

    $bodyText = is_array($body)
        ? json_encode($body, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        : trim((string) $body);

    $requestBlock = trim(
        strtoupper($method) . ' ' . $path . ' ' . $protocol
        . ($headerLines ? "\n" . $headerLines : '')
        . ($bodyText ? "\n\n" . $bodyText : '')
    );
@endphp

<div class="api-card rounded-lg border border-slate-200 bg-white max-w-md overflow-hidden">
    <div class="flex items-center justify-between gap-3 px-2 py-1.5 border-b border-slate-100">
        <div class="flex items-center gap-1">
            <span class="text-xs font-semibold uppercase px-1 py-0 rounded-sm border {{ $methodColor }}">
                {{ strtoupper($method) }}
            </span>
            <span class="font-mono text-xs text-slate-900 truncate">{{ $path }}</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-slate-700 px-1 py-0 rounded-sm border border-slate-200 bg-zinc-50">
                {{ $protocol }}
            </span>
        </div>
    </div>

    <div>
        <div class="group api-body relative overflow-auto max-h-[420px] border border-slate-100 bg-slate-50 px-4 py-3">
            <button type="button"
                    onclick="navigator.clipboard.writeText(this.nextElementSibling.innerText); this.innerText='Copied'; setTimeout(() => this.innerText='Copy', 1500);"
                    class="opacity-0 group-hover:opacity-100 transition absolute top-2 right-2 text-[10px] px-2 py-1 z-[999] rounded-md border border-slate-200 bg-white/80 shadow-sm text-slate-600 hover:bg-white">
                Copy
            </button>
            <pre class="font-mono text-xs leading-6 text-slate-800 whitespace-pre">{{ $requestBlock }}</pre>
        </div>

        @if($buttonLabel)
            <div class="flex justify-end py-1.5 px-1.5 border-t border-slate-100 bg-white">
                <button type="button"
                        class="inline-flex text-xs items-center gap-2 px-2 py-1 rounded-lg bg-red-600 text-white font-mono font-semibold shadow-sm hover:bg-red-700 transition">
                    {{ $buttonLabel }}
                </button>
            </div>
        @endif
    </div>
</div>
