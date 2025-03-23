@section('cssVendor')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('scriptVendor')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection


@section('script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/app/app-date.js') }}"></script>
    <script>
        $(document).ready(function() {
            let itemIndex = 0; // Khởi tạo chỉ số item

            // Hàm thêm item mới
            function addItem() {
                itemIndex++; // Tăng chỉ số
                const newItem = `
            <div data-repeater-item>
                <div class="row">
                    <div class="mb-4 col-lg-6 col-xl-4 col-12 ">
                        <label class="form-label" for="form-repeater-${itemIndex}-1">
                        <span class="text-danger">*</span>
                            @lang('messages.kpi_detail-title')
                        </label>
                        <input type="text" id="form-repeater-${itemIndex}-1" class="form-control" name="items[${itemIndex}][title]"
                            placeholder="" />
                    </div>
                     <div class="mb-4 col-lg-6 col-xl-2 col-12 ">
                        <label class="form-label" for="form-repeater-${itemIndex}-2">
                        <span class="text-danger">*</span>
                            @lang('messages.kpi_detail-ratio')
                        </label>
                        <input type="number" id="form-repeater-${itemIndex}-2" class="form-control" name="items[${itemIndex}][ratio]"
                            placeholder="" />
                    </div>

                    <div class="mb-4 col-lg-6 col-xl-2 col-12 ">
                        <label class="form-label" for="form-repeater-${itemIndex}-3">
                            <span class="text-danger">*</span>
                            @lang('messages.kpi_detail-staff_evaluation')
                        </label>
                        <input type="number" id="form-repeater-${itemIndex}-3" class="form-control"
                            name="items[${itemIndex}][staff_evaluation]" placeholder="" />
                    </div>
                    <div class="mb-4 col-lg-6 col-xl-2 col-12 ">
                        <label class="form-label" for="form-repeater-${itemIndex}-4">
                            <span class="text-danger">*</span>
                            @lang('messages.kpi_detail-assessment_manager')
                        </label>
                        <input type="number" id="form-repeater-${itemIndex}-4" class="form-control"
                            name="items[${itemIndex}][assessment_manager]" placeholder="" />
                    </div>
                    <div class="mb-4 col-lg-6 col-xl-4 col-12 ">
                        <label class="form-label" for="form-repeater-${itemIndex}-5">
                            @lang('messages.kpi_detail-target')
                        </label>
                        <input type="number" id="form-repeater-${itemIndex}-5" class="form-control" name="items[${itemIndex}][target]"
                            placeholder="" />
                    </div>
                    <div class="mb-4 col-lg-6 col-xl-6 col-12 ">
                        <label class="form-label" for="form-repeater-${itemIndex}-6">
                            @lang('messages.kpi_detail-manager_note')
                        </label>
                        <input type="text" id="form-repeater-${itemIndex}-6" class="form-control"
                            name="items[${itemIndex}][manager_note]" placeholder="" />
                    </div>
                    <div class="mb-4 col-lg-12 col-xl-1 col-12 d-flex align-items-center">
                        <button type="button" class="btn btn-label-danger mt-xl-6" data-repeater-delete>
                            <i class="icon-base ti tabler-x me-1"></i>
                            <span class="align-middle">
                                @lang('messages.delete')
                            </span>
                        </button>
                    </div>
                </div>
                <hr />
            </div>`;
                $('[data-repeater-list="group-a"]').append(newItem);
            }

            // Thêm sự kiện cho nút "Thêm Item"
            $('[data-repeater-create]').on('click', addItem);

            // Xử lý xóa item
            $('[data-repeater-list="group-a"]').on('click', '[data-repeater-delete]', function() {
                const itemToDelete = $(this).closest('[data-repeater-item]');
                if (itemToDelete) {
                    itemToDelete.remove(); // Xóa item
                    updateItemIndices(); // Cập nhật lại chỉ số cho các item còn lại
                }
            });

            // Hàm cập nhật chỉ số cho các item
            function updateItemIndices() {
                itemIndex = 0; // Reset lại chỉ số
                $('[data-repeater-item]').each(function() {
                    itemIndex++;
                    const inputs = $(this).find('input');
                    inputs.each(function(inputIndex) {
                        const newId = `form-repeater-${itemIndex}-${inputIndex + 1}`;
                        $(this).attr('id', newId);
                        $(this).attr('name',
                            `items[${itemIndex}][${$(this).attr('name').split('[')[1]}`);
                        $(this).siblings(`label[for="${$(this).attr('id')}"]`).attr('for', newId);
                    });
                });
            }

            $('[data-repeater-list="group-a"]').on('change', 'input[name*="staff_evaluation"]', function() {
                const itemToUpdate = $(this).closest('[data-repeater-item]');
                const assessmentManagerInput = itemToUpdate.find('input[name*="assessment_manager"]');
                assessmentManagerInput.val($(this)
                    .val()); // Set assessment_manager to the value of staff_evaluation

                const staffEvaluationInputs = $(
                    '[data-repeater-list="group-a"] input[name*="staff_evaluation"]');
                let totalNum = 0;

                staffEvaluationInputs.each(function() {
                    const value = parseFloat($(this).val()) ||
                        0; // Convert to float, default to 0 if NaN
                    totalNum += value; // Sum up the values
                });

                const numInput = $('#num');
                const numShowInput = $('#num_show'); // Find the num_show input
                numInput.val(totalNum); // Set the total to the num input
                numShowInput.val(totalNum); // Set the total to the num_show input
            });

            $('[data-repeater-list="group-a"]').on('change', 'input[name*="assessment_manager"]', function() {
                const staffEvaluationInputs = $(
                    '[data-repeater-list="group-a"] input[name*="assessment_manager"]');
                let totalNum = 0;

                staffEvaluationInputs.each(function() {
                    const value = parseFloat($(this).val()) ||
                        0; // Convert to float, default to 0 if NaN
                    totalNum += value; // Sum up the values
                });

                const numInput = $('#num');
                const numShowInput = $('#num_show'); // Find the num_show input
                numInput.val(totalNum); // Set the total to the num input
                numShowInput.val(totalNum); // Set the total to the num_show input
            });

        });
    </script>
@endsection

@php
    if ($result) {
        $result->start_at = !empty($result->start_at) ? \Carbon\Carbon::parse($result->start_at)->format('d/m/Y') : '';
        $result->end_at = !empty($result->end_at) ? \Carbon\Carbon::parse($result->end_at)->format('d/m/Y') : '';
    }
@endphp

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <input name="id" value="{{ $result->id ?? '' }}" class="d-none" />
    <div class="">
        <div class="row">
            <div class="form-group mb-4 col-6">
                <x-input-label for="name">
                    <span class="text-danger">*</span>
                    @lang('messages.kpi-name')
                </x-input-label>
                <input type="text" class="form-control" id="name" name="name" {{ $disabled ?? '' }}
                    value="{{ old('name', $result->name ?? '') }}" />
                <x-input-error :messages="$errors->get('name')" class="" />
            </div>
            <div class="form-group mb-4 col-6">
                <x-input-label for="user_id">
                    <span class="text-danger">*</span>
                    @lang('messages.user_id')
                </x-input-label>
                <select class="select2 form-select" data-allow-clear="true" name="user_id"
                    onchange="getRemainingLeave(event)" {{ $disabled ?? '' }}
                    {{ $result && $result->user_id ? 'disabled' : '' }}>
                    <option value="" disabled selected>Chọn</option>
                    @foreach ($users as $userItem)
                        <option value="{{ $userItem->id }}"
                            {{ old('user_id', $result->user_id ?? Auth::user()->id) == $userItem->id ? 'selected' : '' }}>
                            {{ '[' . $userItem->code . '] ' . $userItem->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('user_id')" class="" />
            </div>

            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="start_at">
                        <span class="text-danger">*</span>
                        @lang('messages.start_at')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-rangepicker-single" id="start_at"
                        name="start_at" placeholder="DD/MM/YYYY" {{ $disabled ?? '' }}
                        value="{{ old('start_at', $result->start_at ?? '') }}" />
                    <x-input-error :messages="$errors->get('start_at')" class="" />
                </div>

            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-4" id="end_at-form">
                    <x-input-label for="end_at">
                        <span class="text-danger">*</span>
                        @lang('messages.end_at')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-rangepicker-single" id="end_at"
                        name="end_at" placeholder="DD/MM/YYYY" {{ $disabled ?? '' }}
                        value="{{ old('end_at', $result->end_at ?? '') }}" />
                    <x-input-error :messages="$errors->get('end_at')" class="" />
                </div>
            </div>



            <div class="form-group mb-4 col-md-6">
                <x-input-label for="note">
                    @lang('messages.note')
                </x-input-label>
                <textarea id="note" name="note" {{ $disabled ?? '' }} class="form-control">{{ old('note', $result->note ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('note')" class="" />
            </div>

            <div class="form-group mb-4 col-md-6">
                <x-input-label for="description">
                    @lang('messages.description')
                </x-input-label>
                <textarea id="description" name="description" {{ $disabled ?? '' }} class="form-control">{{ old('description', $result->description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="" />
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="num">
                        @lang('messages.kpi-num')
                    </x-input-label>
                    <input type="text" class="form-control" id="num_show" name="num_show" placeholder="" disabled
                        value="{{ old('num', $result->num ?? '0') }}" />
                    <input type="text" class="form-control d-none" id="num" name="num" placeholder=""
                        value="{{ old('num', $result->num ?? '0') }}" />
                    <x-input-error :messages="$errors->get('num')" class="" />
                </div>
            </div>
            <h5 class="text-primary">
                @lang('messages.target')
            </h5>
            <x-input-error :messages="$errors->get('items')" class="" />

            <div class="form-repeater">
                <div data-repeater-list="group-a">
                    @if ($result)
                        @foreach ($result->details as $index => $detail)
                            <div data-repeater-item>
                                <div class="row">
                                    <div class="mb-4 col-lg-6 col-xl-4 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-1">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-title')
                                        </label>
                                        <input type="text" id="form-repeater-{{ $index }}-1"
                                            class="form-control" name="items[{{ $index }}][title]"
                                            placeholder=""
                                            value="{{ old('items.' . $index . '.title', $detail->title) }}"
                                            {{ $disabled ?? '' }} />
                                    </div>
                                    <div class="mb-4 col-lg-6 col-xl-2 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-2">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-ratio')
                                        </label>
                                        <input type="number" id="form-repeater-{{ $index }}-2"
                                            class="form-control" name="items[{{ $index }}][ratio]"
                                            placeholder=""
                                            value="{{ old('items.' . $index . '.ratio', $detail->ratio) }}"
                                            {{ $disabled ?? '' }} />
                                    </div>

                                    <div class="mb-4 col-lg-6 col-xl-2 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-3">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-staff_evaluation')
                                        </label>
                                        <input type="number" id="form-repeater-{{ $index }}-3"
                                            class="form-control" name="items[{{ $index }}][staff_evaluation]"
                                            placeholder=""
                                            value="{{ old('items.' . $index . '.staff_evaluation', $detail->staff_evaluation) }}"
                                            {{ $disabled ?? '' }} />
                                    </div>
                                    <div class="mb-4 col-lg-6 col-xl-2 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-4">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-assessment_manager')
                                        </label>
                                        <input type="number" id="form-repeater-{{ $index }}-4"
                                            class="form-control"
                                            name="items[{{ $index }}][assessment_manager]" placeholder=""
                                            value="{{ old('items.' . $index . '.assessment_manager', $detail->assessment_manager) }}"
                                            {{ isset($disabled) && $disabled && $result->status !== App\Enums\StatusApproveEnum::WAIT_MANAGER->value ? 'disabled' : '' }} />
                                    </div>
                                    <div class="mb-4 col-lg-6 col-xl-4 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-5">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-target')
                                        </label>
                                        <input type="number" id="form-repeater-{{ $index }}-5"
                                            class="form-control" name="items[{{ $index }}][target]"
                                            placeholder=""
                                            value="{{ old('items.' . $index . '.target', $detail->target) }}"
                                            {{ $disabled ?? '' }} />
                                    </div>
                                    <div class="mb-4 col-lg-6 col-xl-6 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-6">
                                            @lang('messages.kpi_detail-manager_note')
                                        </label>
                                        <input type="text" id="form-repeater-{{ $index }}-6"
                                            class="form-control" name="items[{{ $index }}][manager_note]"
                                            placeholder=""
                                            value="{{ old('items.' . $index . '.manager_note', $detail->manager_note) }}"
                                            {{ isset($disabled) && $disabled && $result->status !== App\Enums\StatusApproveEnum::WAIT_MANAGER->value ? 'disabled' : '' }} />
                                    </div>
                                    @if (!isset($disabled))
                                        <div class="mb-4 col-lg-12 col-xl-1 col-12 d-flex align-items-center">
                                            <button type="button" class="btn btn-label-danger mt-xl-6"
                                                data-repeater-delete>
                                                <i class="icon-base ti tabler-x me-1"></i>
                                                <span class="align-middle">
                                                    @lang('messages.delete')
                                                </span>
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <hr />
                            </div>
                        @endforeach
                    @endif

                    @if (old('items'))
                        @foreach (old('items') as $index => $item)
                            <div data-repeater-item>
                                <div class="row">
                                    <div class="mb-4 col-lg-6 col-xl-4 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-1">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-title')
                                        </label>
                                        <input type="text" id="form-repeater-{{ $index }}-1"
                                            class="form-control" name="items[{{ $index }}][title]"
                                            placeholder="" value="{{ old('items.' . $index . '.title') }}" />
                                        <x-input-error :messages="$errors->get('items.' . $index . '.title')" class="" />
                                    </div>
                                    <div class="mb-4 col-lg-6 col-xl-2 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-2">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-ratio')
                                        </label>
                                        <input type="number" id="form-repeater-{{ $index }}-2"
                                            class="form-control" name="items[{{ $index }}][ratio]"
                                            placeholder="" value="{{ old('items.' . $index . '.ratio') }}" />
                                        <x-input-error :messages="$errors->get('items.' . $index . '.ratio')" class="" />

                                    </div>
                                    <div class="mb-4 col-lg-6 col-xl-2 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-3">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-staff_evaluation')
                                        </label>
                                        <input type="number" id="form-repeater-{{ $index }}-3"
                                            class="form-control" name="items[{{ $index }}][staff_evaluation]"
                                            placeholder=""
                                            value="{{ old('items.' . $index . '.staff_evaluation') }}" />
                                        <x-input-error :messages="$errors->get('items.' . $index . '.staff_evaluation')" class="" />

                                    </div>
                                    <div class="mb-4 col-lg-6 col-xl-2 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-4">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-assessment_manager')
                                        </label>
                                        <input type="number" id="form-repeater-{{ $index }}-4"
                                            class="form-control"
                                            name="items[{{ $index }}][assessment_manager]" placeholder=""
                                            value="{{ old('items.' . $index . '.assessment_manager') }}" />
                                        <x-input-error :messages="$errors->get('items.' . $index . '.assessment_manager')" class="" />

                                    </div>
                                    <div class="mb-4 col-lg-6 col-xl-4 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-5">
                                            <span class="text-danger">*</span>
                                            @lang('messages.kpi_detail-target')
                                        </label>
                                        <input type="number" id="form-repeater-{{ $index }}-5"
                                            class="form-control" name="items[{{ $index }}][target]"
                                            placeholder="" value="{{ old('items.' . $index . '.target') }}"
                                            {{ $disabled ?? '' }} />
                                        <x-input-error :messages="$errors->get('items.' . $index . '.target')" class="" />

                                    </div>
                                    <div class="mb-4 col-lg-6 col-xl-6 col-12 ">
                                        <label class="form-label" for="form-repeater-{{ $index }}-6">
                                            @lang('messages.kpi_detail-manager_note')
                                        </label>
                                        <input type="text" id="form-repeater-{{ $index }}-6"
                                            class="form-control" name="items[{{ $index }}][manager_note]"
                                            placeholder="" value="{{ old('items.' . $index . '.manager_note') }}" />
                                        <x-input-error :messages="$errors->get('items.' . $index . '.manager_note')" class="" />

                                    </div>
                                    @if (!isset($disabled))
                                        <div class="mb-4 col-lg-12 col-xl-1 col-12 d-flex align-items-center">
                                            <button type="button" class="btn btn-label-danger mt-xl-6"
                                                data-repeater-delete>
                                                <i class="icon-base ti tabler-x me-1"></i>
                                                <span class="align-middle">
                                                    @lang('messages.delete')
                                                </span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <hr />
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            @if (!isset($disabled))
                <div class="mb-0">
                    <button class="btn btn-success" data-repeater-create type=button>
                        <i class="icon-base ti tabler-plus me-1"></i>
                        <span class="align-middle">@lang('messages.create')</span>
                    </button>
                </div>
            @endif

            @if (isset($disabled) && $disabled)
                <div class="form-group mb-4 col-md-6">
                    <x-input-label for="created_at">
                        @lang('messages.created_at')
                    </x-input-label>
                    <input type="text" class="form-control" id="created_at" name="created_at" disabled
                        value="{{ formatDateTimeView($result?->created_at) }}" />
                </div>
                <div class="form-group mb-4 col-md-6">
                    <x-input-label for="created_by">
                        @lang('messages.created_by')
                    </x-input-label>
                    <input type="text" class="form-control" id="created_by" name="created_by" disabled
                        value="{{ $result?->createdByData?->name }}" />
                </div>
                <div class="form-group mb-4 col-md-6">
                    <x-input-label for="updated_at">
                        @lang('messages.updated_at')
                    </x-input-label>
                    <input type="text" class="form-control" id="updated_at" name="updated_at" disabled
                        value="{{ formatDateTimeView($result?->updated_at) }}" />
                </div>
                <div class="form-group mb-4 col-md-6">
                    <x-input-label for="updated_by">
                        @lang('messages.updated_by')
                    </x-input-label>
                    <input type="text" class="form-control" id="updated_by" name="updated_by" disabled
                        value="{{ $result?->updatedByData?->name }}" />
                </div>
            @endif
        </div>

        <div class="gap-4 justify-content-center d-flex">
            <a href="{{ route('kpi.index') }}">
                <x-button :icon="'x'" type="button" class="btn-secondary">
                    @lang('messages.cancel')
                </x-button>
            </a>
            @can('send', App\Models\KPI::class)
                @if (!empty($disabled) && $result && $result->status === App\Enums\DayOff\StatusDayOffEnum::DRAFT->value)
                    <a class="btn btn-info" href={{ route('kpi.send', $result->id) }}>
                        <x-icon :icon="'send'" class="me-2"></x-icon>
                        {{ __('messages.send') }}
                    </a>
                @endif
            @endcan
            @if (!empty($disabled) && $result && $result->status === \App\Enums\DayOff\StatusDayOffEnum::WAIT_MANAGER->value)
                @can('reject', App\Models\KPI::class)
                    <a href="{{ route('kpi.reject', $result->id) }}" class="btn btn-danger">
                        <x-icon :icon="'x'" />
                        @lang('messages.reject')
                    </a>
                @endcan

                @can('approve', App\Models\KPI::class)
                    <a href="{{ route('kpi.approve', $result->id) }}" class="btn btn-success">
                        <x-icon :icon="'check'" />
                        @lang('messages.approve')
                    </a>
                @endcan
            @endif

            @if (!isset($disabled))
                <x-button :icon="'device-floppy'" class="submit-btn">
                    @lang('messages.save')
                </x-button>
            @endif
        </div>

</form>
