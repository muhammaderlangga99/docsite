@props([
    'spec' => '/openapi/api-docs.yaml',
    'theme' => 'light',
    'height' => '720px',
    'hideModels' => true,
])

@php
    $scalarId = 'scalar-api-reference-' . uniqid();
    $specUrl = url($spec);
    $hideModels = filter_var($hideModels, FILTER_VALIDATE_BOOLEAN);
@endphp

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@scalar/api-reference@1.40.9"></script>
    @endpush

    @push('styles')
        <style>
            .scalar-playground {
                min-height: 480px;
            }

            .scalar-playground scalar-api-reference {
                display: block;
                height: var(--scalar-playground-height, 720px);
            }

        </style>
    @endpush
@endonce

<div class="scalar-playground mt-16" style="--scalar-playground-height: {{ $height }};">
    <div id="{{ $scalarId }}" class="scalar-playground-target"></div>
</div>

<script>
    (function () {
        if (!window.Scalar || !window.Scalar.createApiReference) {
            return;
        }

        window.Scalar.createApiReference('#' + @json($scalarId), {
            url: @json($specUrl),
            theme: @json($theme),
            hideModels: @json($hideModels),
        });

    })();
</script>
