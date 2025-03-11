@props(['icon' => null])
<i {{ $attributes->merge([ 'class' => "icon-base ti tabler-$icon"]) }}></i>
