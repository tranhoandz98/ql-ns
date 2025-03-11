@props(['type'])

<div {{ $attributes->merge(['class' => 'alert alert-' . ($type ?? 'success') . ' alert-dismissible']) }} role="alert">
    @isset($title)
        <h5 class="alert-heading mb-2">
            {{ $title }}
        </h5>
    @endisset
    <p class="mb-0">{{ $slot }}.</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
