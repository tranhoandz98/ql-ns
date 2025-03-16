@section('title', __('messages.reset_password'))

<x-guest-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-card>
            <h4>
                @lang('messages.reset_password')
            </h4>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('messages.description_reset_pass') }}
            </div>
            <!-- Session Status -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-input-text id="email" class="" type="email" name="email" :value="old('email')" required
                        autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="d-flex align-items-center justify-content-end mt-4">
                    <x-button class="submit-btn">
                        {{ __('messages.confirm') }}
                    </x-button>
                </div>
            </form>
        </x-card>

    </div>

</x-guest-layout>
