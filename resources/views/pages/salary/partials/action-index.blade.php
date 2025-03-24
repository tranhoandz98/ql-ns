<div class="d-flex gap-2">
    @can('view', App\Models\Salary::class)
        <a href="{{ route('salary.show', $item->id) }}" title="Xem" class="text-primary">
            <x-icon :icon="'eye'"></x-icon>
        </a>
    @endcan
    @canany(['update', 'delete', 'approve'], App\Models\Salary::class)
        @if ($item->status === App\Enums\Salary\SalaryStatusEnum::DRAFT->value)
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <x-icon :icon="'dots-vertical'"></x-icon>
                </button>
                <div class="dropdown-menu">
                    @can('update', App\Models\Salary::class)
                        @if ($item->status === App\Enums\Salary\SalaryStatusEnum::DRAFT->value)
                            <a class="dropdown-item" href={{ route('salary.edit', $item->id) }}>
                                <x-icon :icon="'edit'" class="me-2"></x-icon>
                                {{ __('messages.edit') }}
                            </a>
                        @endif
                    @endcan
                    @can('approve', App\Models\Salary::class)
                        <a class="dropdown-item" href={{ route('salary.approve', $item->id) }}>
                            <x-icon :icon="'check'" class="me-2"></x-icon>
                            {{ __('messages.approve') }}
                        </a>
                    @endcan

                    @can('delete', App\Models\Salary::class)
                        @if ($item->status !== App\Enums\Salary\SalaryStatusEnum::DONE->value)
                            <form action="{{ route('salary.destroy', $item->id) }}" method="POST" style="display:inline;"
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
