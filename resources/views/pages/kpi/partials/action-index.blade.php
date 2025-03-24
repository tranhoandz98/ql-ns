<div class="d-flex gap-2">
    @can('view', App\Models\KPI::class)
        <a href="{{ route('kpi.show', $item->id) }}" title="Xem" class="text-primary">
            <x-icon :icon="'eye'"></x-icon>
        </a>
    @endcan
    @canany(['update', 'delete', 'send', 'approve', 'reject'], App\Models\KPI::class)
        @if (
            $item->status === App\Enums\DayOff\StatusDayOffEnum::DRAFT->value ||
                $item->status === App\Enums\DayOff\StatusDayOffEnum::REJECT->value ||
                $item->status === App\Enums\DayOff\StatusDayOffEnum::WAIT_MANAGER->value)
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <x-icon :icon="'dots-vertical'"></x-icon>
                </button>
                <div class="dropdown-menu">
                    @can('update', App\Models\KPI::class)
                        @php
                        @endphp
                        @if (
                            $item->status === App\Enums\DayOff\StatusDayOffEnum::DRAFT->value ||
                                $item->status === App\Enums\DayOff\StatusDayOffEnum::REJECT->value)
                            <a class="dropdown-item" href={{ route('kpi.edit', $item->id) }}>
                                <x-icon :icon="'edit'" class="me-2"></x-icon>
                                {{ __('messages.edit') }}
                            </a>
                        @endif
                    @endcan
                    @can('send', App\Models\KPI::class)
                        @if ($item->status === App\Enums\DayOff\StatusDayOffEnum::DRAFT->value)
                            <a class="dropdown-item" href={{ route('kpi.send', $item->id) }}>
                                <x-icon :icon="'send'" class="me-2"></x-icon>
                                {{ __('messages.send') }}
                            </a>
                        @endif
                    @endcan
                    @if ($item->status === App\Enums\DayOff\StatusDayOffEnum::WAIT_MANAGER->value && $item->isApprove)
                        @can('approve', App\Models\KPI::class)
                            <a class="dropdown-item" href={{ route('kpi.approve', $item->id) }}>
                                <x-icon :icon="'check'" class="me-2"></x-icon>
                                {{ __('messages.approve') }}
                            </a>
                        @endcan
                        @can('reject', App\Models\KPI::class)
                            <a class="dropdown-item" href={{ route('kpi.reject', $item->id) }}>
                                <x-icon :icon="'x'" class="me-2"></x-icon>
                                {{ __('messages.reject') }}
                            </a>
                        @endcan
                    @endif

                    @can('delete', App\Models\KPI::class)
                        @if ($item->status !== App\Enums\DayOff\StatusDayOffEnum::DONE->value)
                            <form action="{{ route('kpi.destroy', $item->id) }}" method="POST" style="display:inline;"
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
        @endif
    @endcanany

</div>
