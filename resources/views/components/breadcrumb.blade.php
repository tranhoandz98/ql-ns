@props([
    'labelParent' => '',
    'urlParent' => 'javascript:void(0);',
    'label' => '',
])

<nav aria-label="breadcrumb ">
    <ol class="breadcrumb mt-2">
        <li class="">
            <a href="{{ route('dashboard') }}">@lang('messages.home')</a>
            &nbsp;/&nbsp;
        </li>
        @if ($labelParent)
            <li class="">
                <a href={{ $urlParent }}>{{ $labelParent }}</a>
                &nbsp;/&nbsp;
            </li>
        @endif

        <li class=" active">{{ $label }}</li>
    </ol>
</nav>
