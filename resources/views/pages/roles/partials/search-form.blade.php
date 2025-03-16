<form class="dt_adv_search" method="GET">
    <div class="row">
        <div class="col-12 col-sm-6 col-lg-4">
            <input type="search" class="form-control dt-input dt-full-name" data-column="1"
                value="{{ request('name') }}" placeholder="Tên vai trò" name="name"
                data-column-index="0" />
        </div>
        <div class="col">
            <div class="d-flex gap-4">
                <x-button :icon="'search'" class="submit-btn">
                    {{ __('messages.search') }}
                </x-button>
            </div>
        </div>

    </div>

</form>