@props(['with_cancelled' => true, 'with_rejected' => true, 'with_pending' => true, 'with_accepted' => true])
<div {{ $attributes->merge(['class' => 'flex flex-col gap-1']) }}>
	<label class="opacity-40 text-sm" for="status">Status</label>
	<select wire:change="resetPage" id="status"
	        class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70"
	        wire:model="status">
		<option class="cursor-pointer" value="all">Sve</option>
        @if($with_pending)
		<option class="cursor-pointer" value="pending">Na čekanju</option>
        @endif
        @if($with_accepted)
		<option class="cursor-pointer" value="accepted">Odobreno</option>
        @endif
        @if($with_cancelled)
		<option class="cursor-pointer" value="cancelled">Otkazano</option>
        @endif
        @if($with_rejected)
		<option class="cursor-pointer" value="rejected">Odbijeno</option>
        @endif
	</select>
</div>
