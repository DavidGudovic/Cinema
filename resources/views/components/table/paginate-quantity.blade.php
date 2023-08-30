<div {{ $attributes->merge(['class' => 'flex-col gap-1']) }}>
	<label class="opacity-40 text-sm" for="sort">Prikaži</label>
	<select wire:change="refreshPage" id="sort"
	        class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70" wire:model="quantity">
		<option class="cursor-pointer" value="5">5</option>
		<option class="cursor-pointer" value="10">10</option>
		<option class="cursor-pointer" value="15">15</option>
		<option class="cursor-pointer" value="20">20</option>
		<option class="cursor-pointer" value="25">25</option>
		<option class="cursor-pointer" value="50">50</option>
		<option class="cursor-pointer" value="100">100</option>
	</select>
</div>
