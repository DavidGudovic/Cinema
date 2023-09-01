@props(['shown' => false, 'name' => 'showModal'])
<div x-data="{ {{$name}}: {{$shown}} }" x-show="{{$name}}" x-trap.noscroll="{{$name}}"
     x-on:keydown.escape.window="{{$name}} = false" x-cloak
		{{ $attributes->class(['flex justify-center items-center h-full fixed inset-0 px-4 py-6 md:py-6 z-50']) }}>

	<!-- Modal Background -->
	<div x-show="{{$name}}" class="fixed inset-0 transform backdrop-blur-sm" x-on:click="{{$name}}=false">

	</div>

	<!-- Modal body -->
    {{$slot}}
	<!-- Modal body -->
</div>
