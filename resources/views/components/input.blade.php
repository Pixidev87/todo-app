@props([
    'name',
    'type' => 'text',
    'value' => '',
])

<div class="mb-3">
    <x-form.label :for="$name">
        {{ ucfirst($name) }}
    </x-form.label>

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge([
            'class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')
        ]) }}
    >

    <x-form.error :name="$name" />
</div>
