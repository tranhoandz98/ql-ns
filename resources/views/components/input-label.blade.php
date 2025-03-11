@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label text-fw-500']) }}>
    {{ $value ?? $slot }}
</label>
