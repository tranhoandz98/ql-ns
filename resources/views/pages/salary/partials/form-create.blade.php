@section('cssVendor')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection
@section('scriptVendor')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection


@section('script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@endsection

@php

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
                <x-input-label for="user_id">
                    <span class="text-danger">*</span>
                    @lang('messages.user_id')
                </x-input-label>
                <select class="select2 form-select" data-allow-clear="true" name="user_id" {{ $disabled ?? '' }}
                    {{ $result && $result->user_id ? 'disabled' : '' }}>
                    <option value="" disabled selected>Chọn</option>
                    @foreach ($users as $userItem)
                        <option value="{{ $userItem->id }}"
                            {{ old('user_id', $result->user_id ?? '') == $userItem->id ? 'selected' : '' }}>
                            {{ '[' . $userItem->code . '] ' . $userItem->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('user_id')" class="" />
            </div>
        </div>

        <div class="gap-4 justify-content-center d-flex col-md-6">
            <a href="{{ route('salary.index') }}">
                <x-button :icon="'x'" type="button" class="btn-secondary">
                    @lang('messages.cancel')
                </x-button>
            </a>

            @if (!isset($disabled))
                <x-button :icon="'arrow-right'" class="submit-btn">
                    @lang('messages.continue')
                </x-button>
            @endif
        </div>

</form>
