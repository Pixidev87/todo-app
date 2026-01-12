@props([
    'type' => 'submit',
    'variant' => 'primary',
    'size' => null,
])

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'btn btn-' . $variant . ($size ? ' btn-' . $size : '')
    ]) }}
>
    {{ $slot }}
</button>
