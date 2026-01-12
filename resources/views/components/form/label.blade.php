@props(['for'])

<label for="{{ $for }}" class="form-label">
    {{ $slot }}
</label>
