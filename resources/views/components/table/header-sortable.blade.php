<th x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === '{{$sort}}' }"
    wire:click="setSort('{{$sort}}')" {{ $attributes->merge(['class' => 'cursor-pointer p-2']) }}><i
			class="fa-solid fa-sort opacity-40 fa-xs"></i>
	{{$slot}}
</th>
