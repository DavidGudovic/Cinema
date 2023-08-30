@props(['text', 'model'])

<td x-on:mouseenter="showToolTip{{$model}} = true"
    x-on:mouseleave="showToolTip{{$model}} = false"
		{{ $attributes->class(['group m-2 line-clamp-2']) }}>{{ implode(' ',explode(' ', $text, 3))}}
	<span x-cloak x-show="showToolTip{{$model}}"
	      class=" transition-opacity bg-gray-800 text-gray-100 p-2 text-sm rounded-md  absolute {{$position}} z-20 w-96 h-auto">{{$text}}</span>
</td>
