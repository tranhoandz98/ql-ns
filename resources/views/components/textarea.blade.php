{{-- @props(['disabled' => false, 'invalid' => false, 'value' => ''])

<textarea 
    name="{{ $name }}"
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'form-control' . ($invalid ? ' border-danger' : '')]) }}
>{{ old($name, $value) }}</textarea> --}}


<textarea
    {{ $attributes->merge(['class' => 'form-control']) }}
    {{ $invalid ? 'aria-invalid="true"' : '' }}
>{{ $slot }}</textarea>