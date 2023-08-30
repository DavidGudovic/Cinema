@props(['sort' => null])

<td x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === '{{$sort}}' }"
		{{ $attributes->merge(['class' => 'p-2']) }}>
    {{ $slot }}
</td>
