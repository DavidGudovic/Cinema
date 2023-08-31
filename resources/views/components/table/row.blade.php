@props(['key'])

<tr wire:key="{{$key}}" {{ $attributes->class(['odd:bg-dark-blue text-center relative ']) }}>
    {{ $slot }}
</tr>
