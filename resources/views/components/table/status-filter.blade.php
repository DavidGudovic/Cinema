<div {{ $attributes->merge(['class' => 'flex flex-col gap-1']) }}>
	<label class="opacity-40 text-sm" for="status">Status</label>
	<select wire:change="resetPage" id="status"
	        class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70"
	        wire:model="status">
		<option class="cursor-pointer" value="all">Sve</option>
		<option class="cursor-pointer" value="pending">Na čekanju</option>
		<option class="cursor-pointer" value="accepted">Odobreno</option>
		<option class="cursor-pointer" value="cancelled">Otkazano</option>
		<option class="cursor-pointer" value="rejected">Odbijeno</option>
	</select>
</div>
