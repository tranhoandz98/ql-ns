@section('title', __('messages.404_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}" />
@endsection
<x-guest-layout>
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">404</h1>
            <h4 class="mb-2 mx-2">
                {{ __('messages.404_title') }}
                ⚠️</h4>
            <p class="mb-6 mx-2">
                {{ __('messages.404_message') }}

            </p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary mb-10">
                {{ __('messages.back_to_home') }}
            </a>
            <div class="mt-4">
                <img src="{{ asset('assets/img/illustrations/page-misc-error.png') }}" alt="page-misc-error-light"
                    width="225" class="img-fluid" />
            </div>
        </div>
    </div>

</x-guest-layout>
