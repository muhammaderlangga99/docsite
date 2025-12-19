@props([
    'status' => '200',
    'label' => 'Successful',
    'body' => null,
])

@php
    $statusColor = str_starts_with((string) $status, '2')
        ? 'bg-emerald-100 text-emerald-800 border-emerald-200'
        : (str_starts_with((string) $status, '4') || str_starts_with((string) $status, '5')
            ? 'bg-rose-100 text-rose-800 border-rose-200'
            : 'bg-amber-100 text-amber-800 border-amber-200');

    $bodyText = is_array($body)
        ? json_encode($body, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        : trim((string) $body);
@endphp

<div class="api-card rounded-md border border-slate-200 bg-white max-w-md overflow-hidden">
    <div class="flex items-center gap-1 px-2 py-1 border-b border-slate-100">
        <span class="text-[11px] font-semibold uppercase px-1 py-0 rounded-sm border {{ $statusColor }}">
            {{ $status }}
        </span>
        <span class="text-xs text-slate-500">{{ $label }}</span>
    </div>
    <div>
        <div class="api-body relative overflow-auto max-h-[320px] border border-slate-100 bg-slate-50 px-4 py-3">
            <button type="button"
                    onclick="navigator.clipboard.writeText(this.nextElementSibling.innerText); this.innerText='Copied'; setTimeout(() => this.innerText='Copy', 1500);"
                    class="transition absolute top-2 right-2 text-[10px] px-1 py-0.5 z-[999] rounded-md border border-slate-200 bg-white/80 text-slate-600 hover:bg-white">
                Copy
            </button>
            <pre class="font-mono text-xs leading-6 text-slate-900 whitespace-pre">{{ $bodyText }}</pre>
        </div>
    </div>
</div>
