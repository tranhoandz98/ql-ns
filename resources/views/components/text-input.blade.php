@props(['disabled' => false, 'invalid' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'form-control' . ($invalid ? ' border-danger' : '')]) }}>
