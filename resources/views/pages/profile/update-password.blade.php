<x-app-layout>
    <x-card>
            <h3 class="">
                Đổi mật khẩu
            </h3>

            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')
                <div class="mb-4">
                    <x-input-label for="update_password_current_password" :value="'Mật khẩu hiện tại'" />
                    <x-text-input id="update_password_current_password" name="current_password" type="password"
                        class="" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="update_password_password" :value="'Mật khẩu mới'" />
                    <x-text-input id="update_password_password" name="password" type="password" class=""
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="update_password_password_confirmation" :value="'Nhập lại mật khẩu mới'" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                        type="password" class="" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-button :icon="'device-floppy'">Lưu</x-button>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
    </x-card>

</x-app-layout>
