<form class="dt_adv_search" method="GET">
    <div class="row g-2">
        <div class="col-12 col-sm-6 col-lg-4">
            <x-input-label for="name" class="advance-search">
                @lang('messages.user-search')
            </x-input-label>
            <input type="search" class="form-control dt-input dt-full-name" data-column="1" value="{{ request('name') }}"
                placeholder="{{ __('messages.user-search') }}" name="name" data-column-index="0" />
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="position_id">
                <span class="text-danger">*</span>
                Vai trò
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="role_id" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="type">
                Loại người dùng
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="type" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($typeUser as $item)
                    <option value="{{ $item['id'] }}" {{ request('type') == $item['id'] ? 'selected' : '' }}>
                        {{ $item['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="status">
                Trạng thái
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="status" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($statusUser as $item)
                    <option value="{{ $item['id'] }}" {{ request('status') == $item['id'] ? 'selected' : '' }}>
                        {{ $item['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="department_id">
                <span class="text-danger">*</span>
                Phòng ban
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="department_id" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ request('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="position_id">
                <span class="text-danger">*</span>
                Chức vụ
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="position_id" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}"
                        {{ request('position_id') == $position->id ? 'selected' : '' }}>
                        {{ $position->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 advance-search">
            <x-input-label for="manager_id">
                @lang('messages.user-manager_id')
            </x-input-label>
            <select class="select2 form-select" data-allow-clear="true" name="manager_id" {{ $disabled ?? '' }}>
                <option value="" selected>Chọn</option>
                @foreach ($users as $userItem)
                    <option value="{{ $userItem->id }}"
                        {{ request('manager_id') == $userItem->id ? 'selected' : '' }}>
                        {{ '[' . $userItem->code . '] ' . $userItem->name }}
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

        function compactAction(){
            var elements = document.querySelectorAll('.advance-search');
            elements.forEach(function(element) {
                element.classList.add('d-none');
            });
            document.querySelector('.extend-btn').classList.remove('d-none');
            filterSearch.user = false;
            localStorage.setItem('filterSearch', JSON.stringify(filterSearch))
        }
        function extendAction(){
            var elements = document.querySelectorAll('.advance-search');
            elements.forEach(function(element) {
                element.classList.remove('d-none');
            });
            document.querySelector('.extend-btn').classList.add('d-none');
            filterSearch.user = true;
            localStorage.setItem('filterSearch', JSON.stringify(filterSearch))
        }

        if (!filterSearch?.user) {
            compactAction()
        }else{
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
