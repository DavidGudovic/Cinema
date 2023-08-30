<div {{ $attributes->class(['flex flex-col gap-1']) }}>
	<label class="opacity-40 text-sm" for="sort">Sortiraj</label>
	<select id="sort" class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70"
	        wire:model="global_sort">
		<option class="cursor-pointer" value='false'>Prikazano</option>
		<option class="cursor-pointer" value='true'>Sve podatke</option>
	</select>
</div>
