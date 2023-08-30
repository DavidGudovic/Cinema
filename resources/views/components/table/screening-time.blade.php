<div {{ $attributes->class(['flex flex-col gap-1']) }}>
	<label class="opacity-40 text-sm" for="screening_time">Prikazuje se</label>
	<select wire:change="resetPage" id="screening_time"
	        class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70"
	        wire:model="screening_time">
		<option class="cursor-pointer" value="any">Bilo kada</option>
		<option class="cursor-pointer" value="now">Danas</option>
		<option class="cursor-pointer" value="tomorrow">Sutra</option>
		<option class="cursor-pointer" value="week">Ove nedelje</option>
		<option class="cursor-pointer" value="with past">Sa prošlim</option>
	</select>
</div>
