@props(['shown' => false, 'name' => 'showModal' , 'livewire' => false])

<div @if($livewire) x-data="{ {{$name}}: @entangle($entangle)}"
     @else x-data="{ {{$name}}: {{$shown}} }"  @endif
     x-show="{{$name}}"
     x-init="{{$name}} = {{$shown}}"
     x-trap.noscroll="{{$name}}"
     x-on:keydown.escape.window="{{$name}} = false"
     x-cloak
    {{ $attributes->class(['flex justify-center items-center h-full fixed inset-0 px-4 py-6 md:py-6 z-50']) }}>

    <!-- Modal Background -->
    <div x-show="{{$name}}" class="fixed inset-0 transform backdrop-blur-sm" x-on:click="{{$name}}=false">

    </div>

    <!-- Modal body -->
    {{$slot}}
    <!-- Modal body -->
</div>
