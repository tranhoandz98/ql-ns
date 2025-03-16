@section('cssVendor')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jstree/jstree.css') }}" />
@endsection

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <input name="id" value="{{ $result->id ?? '' }}" class="d-none" />
    <div class="row">

        <div class="form-group mb-4 col-12">
            <x-input-label for="nameRole">
                <span class="text-danger">*</span>
                Tên vai trò
            </x-input-label>
            <input type="text" class="form-control" id="name" name="name" {{ $disabled ?? '' }}
                value="{{ old('name', $result->name ?? '') }}" />
            <x-input-error :messages="$errors->get('name')" class="" />

        </div>

        <div class="form-group mb-4 col-12">
            <x-input-label for="description" :value="'Mô tả'"></x-input-label>
            <textarea id="description" name="description" {{ $disabled ?? '' }} class="form-control">{{ old('description', $result->description ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="" />

        </div>

        <div class="form-group mb-4 col-12">
            <x-input-label for="permission">
                <span class="text-danger">*</span>
                Phân quyền
            </x-input-label>
            <div id="jstree-checkbox"></div>
            <input class="d-none" name="permission" />
            <x-input-error :messages="$errors->get('permission')" class="" />

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

    <div class="gap-4 d-flex justify-content-center">
        <a href="{{ route('roles.index') }}">
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
@section('scriptVendor')
    <script src="{{ asset('assets/vendor/libs/jstree/jstree.js') }}"></script>
@endsection

@php
@endphp
@section('script')
    <script>
        $(function() {
            const permission = @json($permission);
            const permissionOld = @json($permissionOld);
            const t =
                "dark" === $("html").attr("data-bs-theme") ? "default-dark" : "default";
            const i = $("#jstree-checkbox");

            const formattedPermission = [];
            for (const [parentName, permissions] of Object.entries(permission)) {
                const children = permissions.map(p => ({
                    text: p.display_name,
                    id: p.id,
                    state: {
                        selected: permissionOld ? permissionOld.includes(p.id) : false
                    }
                }));

                formattedPermission.push({
                    text: parentName,
                    state: {
                        opened: true
                    },
                    children: children
                });
            }

            i.jstree({
                core: {
                    themes: {
                        name: t
                    },
                    data: formattedPermission,
                },

                plugins: ["types", "checkbox", "wholerow", "changed"],
                types: {
                    default: {
                        icon: "icon-base ti tabler-folder"
                    },
                },
            }).on('changed.jstree', function(e, data) {
                const selectedNodes = data.selected;
                $('input[name="permission"]').val(JSON.stringify(selectedNodes));
            })

        })
    </script>
@endsection
