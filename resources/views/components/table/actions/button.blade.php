@props(['icon', 'route' => '#', 'enabled' => true])

@if($enabled)
<a {{$attributes->merge(['class'])}} href="{{$route}}">
    {{$icon}}
</a>
@else
<a href="#" aria-disabled="true" class='opacity-50 cursor-default text-red-700'>
    {{$icon}}
</a>
@endif
