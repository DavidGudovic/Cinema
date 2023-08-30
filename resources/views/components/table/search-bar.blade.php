<div {{ $attributes->merge(['class' => 'relative flex flex-col gap-1']) }}>
	<label class="opacity-40 text-sm" for="search">Pretraži po</label>
	<input id="search" type="text" wire:model.debounce.300ms="search_query" wire:change.debounce="refreshPage"
	       placeholder="{{$placeholder}}..."
	       class="border rounded p-2 pl-8 bg-gray-700 bg-opacity-70 md:w-auto">
	<i class="fa-solid fa-search absolute left-2 bottom-1 transform -translate-y-2/4"></i>
</div>
