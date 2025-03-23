<form class="dt_adv_search" method="GET">
    <div class="row g-2">
        <div class="col-12 col-sm-6 col-lg-4">
            <x-input-label for="code" class="advance-search">
                @lang('messages.code')
            </x-input-label>
            <input type="search" class="form-control dt-input dt-full-name" data-column="1" value="{{ request('name') }}"
                placeholder="{{ __('messages.overtime-search') }}" name="name" data-column-index="0" />
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="manager_id" class="">
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
            <x-input-label for="expected_start" class="">
                @lang('messages.overtime-expected_start')
            </x-input-label>
            <input type="text" class="form-control flatpickr-rangepicker-range" id="expected_start"
                name="expected_start" placeholder="DD/MM/YYYY to DD/MM/YYYY" value="{{ request('expected_start') }}" />
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="status">
                @lang('messages.status')
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="status" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($statusOverTimeEnum as $item)
                    <option value="{{ $item['id'] }}" {{ request('status') == $item['id'] ? 'selected' : '' }}>
                        {{ $item['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="manager_id" class="">
                @lang('messages.group_by')
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="group_by" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($typeGroupExpectedStartEnum as $item)
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
    <script></script>
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
            filterSearch.overtimes = false;
            localStorage.setItem('filterSearch', JSON.stringify(filterSearch))
        }

        function extendAction() {
            var elements = document.querySelectorAll('.advance-search');
            elements.forEach(function(element) {
                element.classList.remove('d-none');
            });
            document.querySelector('.extend-btn').classList.add('d-none');
            filterSearch.overtimes = true;
            localStorage.setItem('filterSearch', JSON.stringify(filterSearch))
        }

        if (!filterSearch?.overtimes) {
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
