<div {{ $attributes->merge(['class' => 'flex-col gap-1']) }}>
	<label class="opacity-40 text-sm" for="user_id">Korisnik ID</label>
	<input type="number" id="user_id" min="0"
	       class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70 w-16"
	       wire:model="user_id" wire:change="resetPage"/>
</div>
