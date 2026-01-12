@props([
    'name',
    'value' => '',
])

<div class="mb-3">
    <x-form.label :for="$name">
        {{ ucfirst($name) }}
    </x-form.label>

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'form-control'
        ]) }}
    >{{ old($name, $value) }}</textarea>

    <x-form.error :name="$name" />
</div>
