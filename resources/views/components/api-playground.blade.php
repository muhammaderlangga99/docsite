@props([
    'spec' => '/openapi/' . config('openapi.default', 'api-docs'),
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
    <div
        id="{{ $scalarId }}"
        class="scalar-playground-target"
        data-scalar-playground
        data-spec-url="{{ $specUrl }}"
        data-theme="{{ $theme }}"
        data-hide-models="{{ $hideModels ? 'true' : 'false' }}"
    ></div>
</div>
