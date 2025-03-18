<form class="dt_adv_search" method="GET">
    <div class="row g-2">
        <div class="col-12 col-sm-6 col-lg-4 ">
            <x-input-label for="manager_id" class="advance-search">
                @lang('messages.timekeeping-user_id')
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="manager_id" {{ $disabled ?? '' }}
                title="{{ __('messages.timekeeping-user_id') }}">
                <option value="" selected>Chọn</option>
                @foreach ($users as $userItem)
                    <option value="{{ $userItem->id }}" {{ request('manager_id') == $userItem->id ? 'selected' : '' }}>
                        {{ '[' . $userItem->code . '] ' . $userItem->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="checkin" class="">
                @lang('messages.timekeeping-checkin')
            </x-input-label>
            <input type="text" class="form-control bs-rangepicker-range" id="checkin" name="checkin"
                placeholder="DD/MM/YYYY to DD/MM/YYYY" value="{{ request('checkin') }}" />
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="manager_id" class="">
                @lang('messages.group_by')
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="group_by" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($typeGroupCheckInEnum as $item)
                    <option value="{{ $item['id'] }}" {{ request('group_by') == $item['id'] ? 'selected' : '' }}>
                        {{ $item['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <x-input-label class="advance-search">
                &nbsp;
            </x-input-label>
            <div class="d-flex gap-4 justify-content-end">
                <x-button :icon="'search'" class="submit-btn">
                    {{ __('messages.search') }}
                </x-button>
                <x-button :icon="'chevron-down'" type="button" class="btn-secondary extend-btn">
                    {{ __('messages.extend') }}
                </x-button>
                <x-button :icon="'chevron-up'" type="button" class="btn-secondary compact-btn advance-search">
                    {{ __('messages.compact') }}
                </x-button>
            </div>
        </div>
    </div>
    <script>
        filterSearch = localStorage.getItem('filterSearch')
        if (filterSearch) {
            filterSearch = JSON.parse(filterSearch)
        } else {
            filterSearch = {}
        }

        function compactAction() {
            var elements = document.querySelectorAll('.advance-search');
            elements.forEach(function(element) {
                element.classList.add('d-none');
            });
            document.querySelector('.extend-btn').classList.remove('d-none');
            filterSearch.timeKeeping = false;
            localStorage.setItem('filterSearch', JSON.stringify(filterSearch))
        }

        function extendAction() {
            var elements = document.querySelectorAll('.advance-search');
            elements.forEach(function(element) {
                element.classList.remove('d-none');
            });
            document.querySelector('.extend-btn').classList.add('d-none');
            filterSearch.timeKeeping = true;
            localStorage.setItem('filterSearch', JSON.stringify(filterSearch))
        }

        if (!filterSearch?.timeKeeping) {
            compactAction()
        } else {
            extendAction()
        }


        document.querySelector('.compact-btn').addEventListener('click', function() {
            compactAction()
        });
        document.querySelector('.extend-btn').addEventListener('click', function() {
            extendAction()
        });
        localStorage.setItem('filterSearch', JSON.stringify(filterSearch))
    </script>
</form>
