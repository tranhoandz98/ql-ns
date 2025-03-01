@props(['icon' => null])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary']) }}>
    @if ($icon)
        <i class="me-2 icon-xs  icon-base ti tabler-{{ $icon }}"></i>
    @endif
    {{ $slot }}
</button>
