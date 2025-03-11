@section('cssVendor')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jstree/jstree.css') }}" />
@endsection

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <input name="id" value="{{ $result->id ??'' }}" class="d-none" />
    <div class="form-group mb-4">
        <x-input-label for="nameRole" :value="'Tên vai trò'"></x-input-label>
        <input type="text" class="form-control" id="name" name="name" {{ $disabled ?? '' }}
            value="{{ old('name', $result->name ?? '') }}" />
        <x-input-error :messages="$errors->get('name')" class="" />

    </div>

    <div class="form-group mb-4">
        <x-input-label for="description" :value="'Mô tả'"></x-input-label>
        <textarea id="description" name="description" {{ $disabled ?? '' }} class="form-control">{{ old('description', $result->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="" />

    </div>

    <div class="form-group mb-4">
        <x-input-label for="permission" :value="'Phân quyền'"></x-input-label>
        <div id="jstree-checkbox"></div>
        <input class="d-none" name="permission" />
        <x-input-error :messages="$errors->get('permission')" class="" />

    </div>
    <div class="gap-4 d-flex justify-content-center">
        <a href="{{ route('roles.index') }}">
            <x-button :icon="'x'" type="button" class="btn-secondary">Huỷ</x-button>
        </a>
        @if (!isset($disabled))
            <x-button :icon="'device-floppy'" class="">Lưu</x-button>
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
