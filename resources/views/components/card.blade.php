@props(['title' => '', 'subtitle' => null])

<div class="card h-100">
    @if ($title)
        <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
                <h5 class="mb-1">{{ $title }}</h5>
                <p class="card-subtitle">{{ $subtitle }}</p>
            </div>
            @isset($actionHeader)
                {{ $actionHeader }}
            @endisset
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
