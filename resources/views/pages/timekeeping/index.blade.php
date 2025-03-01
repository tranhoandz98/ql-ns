@section('title', 'Chấm công')

<x-app-layout>
    <x-card :title="'Chấm công'">
        @slot('actionHeader')
            <div class="d-flex gap-2">
                <a href="{{ route('cham-cong.add-me') }}">
                    <x-button :icon="'plus'">
                        Thêm
                    </x-button>
                </a>

            </div>
        @endslot
        content
    </x-card>
</x-app-layout>
