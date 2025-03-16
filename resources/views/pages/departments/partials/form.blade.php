@section('cssVendor')
@endsection
@section('scriptVendor')
@endsection

@section('script')
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

            <div class="form-group mb-4 col-12">
                <x-input-label for="name">
                    <span class="text-danger">*</span>
                    @lang('messages.position-name')
                </x-input-label>
                <input type="text" class="form-control" id="name" name="name" {{ $disabled ?? '' }}
                    value="{{ old('name', $result->name ?? '') }}" />
                <x-input-error :messages="$errors->get('name')" class="" />
            </div>
            <div class="form-group mb-4 col-12">
                <x-input-label for="description">
                    @lang('messages.description')
                </x-input-label>
                <textarea id="description" name="description" {{ $disabled ?? '' }} class="form-control">{{ old('description', $result->description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="" />
            </div>

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
            <a href="{{ route('positions.index') }}">
                <x-button :icon="'x'" type="button" class="btn-secondary">
                    @lang('messages.cancel')
                </x-button>
            </a>
            @if (!isset($disabled))
                <x-button :icon="'device-floppy'" class="submit-btn">
                    @lang('messages.save')
                </x-button>
            @endif
        </div>
</form>
