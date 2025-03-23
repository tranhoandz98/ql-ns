<div class="d-flex gap-2">
    @can('view', App\Models\Overtimes::class)
        <a href="{{ route('overtimes.show', $item->id) }}" title="Xem" class="text-primary">
            <x-icon :icon="'eye'"></x-icon>
        </a>
    @endcan
    @canany(['update', 'delete', 'send', 'approve', 'reject'], App\Models\Overtimes::class)
        <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <x-icon :icon="'dots-vertical'"></x-icon>
            </button>
            <div class="dropdown-menu">
                @can('update', App\Models\Overtimes::class)
                @php
                @endphp
                    @if ($item->status === App\Enums\User\StatusOverTimeEnum::DRAFT->value ||
                    $item->status === App\Enums\User\StatusOverTimeEnum::REJECT->value
                    )
                        <a class="dropdown-item" href={{ route('overtimes.edit', $item->id) }}>
                            <x-icon :icon="'edit'" class="me-2"></x-icon>
                            {{ __('messages.edit') }}
                        </a>
                    @endif
                @endcan
                @can('send', App\Models\Overtimes::class)
                    @if ($item->status === App\Enums\User\StatusOverTimeEnum::DRAFT->value)
                        <a class="dropdown-item" href={{ route('overtimes.send', $item->id) }}>
                            <x-icon :icon="'send'" class="me-2"></x-icon>
                            {{ __('messages.send') }}
                        </a>
                    @endif
                @endcan
                @can('approve', App\Models\Overtimes::class)
                    @if ($item->status === App\Enums\User\StatusOverTimeEnum::WAIT_MANAGER->value)
                        <a class="dropdown-item" href={{ route('overtimes.approve', $item->id) }}>
                            <x-icon :icon="'check'" class="me-2"></x-icon>
                            {{ __('messages.approve') }}
                        </a>
                    @endif
                @endcan
                @can('reject', App\Models\Overtimes::class)
                    @if ($item->status === App\Enums\User\StatusOverTimeEnum::WAIT_MANAGER->value)
                        <a class="dropdown-item" href={{ route('overtimes.reject', $item->id) }}>
                            <x-icon :icon="'x'" class="me-2"></x-icon>
                            {{ __('messages.reject') }}
                        </a>
                    @endif
                @endcan
                @can('delete', App\Models\Overtimes::class)
                    @if ($item->status !== App\Enums\User\StatusOverTimeEnum::DONE->value)
                        <form action="{{ route('overtimes.destroy', $item->id) }}" method="POST" style="display:inline;"
                            id="delete-form-{{ $item->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="dropdown-item" onclick="onDeleteItem({{ $item->id }})">
                                <x-icon :icon="'trash'" class="me-2"></x-icon>
                                {{ __('messages.delete') }}

                            </button>
                        </form>
                    @endif
                @endcan

            </div>
        </div>
    @endcanany

</div>
