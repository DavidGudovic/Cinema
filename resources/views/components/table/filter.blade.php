<div {{ $attributes->class(['flex flex-col gap-1']) }}>
	<label class="opacity-40 text-sm" for="{{$model}}">{{$title}}</label>
	<select wire:change="resetPage" id="{{$model}}"
	        class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70" wire:model="{{$model}}">
            {{$options}}
	</select>
</div>
