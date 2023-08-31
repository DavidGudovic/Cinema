@props(['text', 'model', 'toolTipIndex' => 0])

<td x-on:mouseenter="visibleToolTip = {{$model}}, toolTipIndex = {{$toolTipIndex}}"
    x-on:mouseleave="visibleToolTip = false"
    {{ $attributes->merge(['class' => 'group m-2 line-clamp-2']) }}>
    {{ implode(' ',explode(' ', $text, 3))}}
    <span x-cloak x-show="visibleToolTip == {{$model}} && toolTipIndex == {{$toolTipIndex}}"
          class=" transition-opacity bg-gray-800 text-gray-100 p-2 text-sm rounded-md  absolute {{$position}} z-20 w-96 h-auto">{{$text}}</span>
</td>
