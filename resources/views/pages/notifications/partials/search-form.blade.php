<form class="dt_adv_search" method="GET">
    <div class="row g-2">
        <div class="col-12 col-sm-6 col-lg-4">
            <input type="search" class="form-control dt-input dt-full-name" data-column="1" value="{{ request('name') }}"
                placeholder="{{ __('messages.notification-search') }}" name="name" data-column-index="0" />
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <select class="select2 form-select" data-allow-clear="true" name="is_read" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($statusNotifyReadEnum as $item)
                    <option value="{{ $item['id'] }}" {{ request('is_read') == $item['id'] ? 'selected' : '' }}>
                        {{ $item['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <div class="d-flex gap-4 justify-content-end">
                <x-button :icon="'search'" class="submit-btn">
                    {{ __('messages.search') }}
                </x-button>
            </div>
        </div>
    </div>
    <script></script>
</form>
