@props(['model'])

<a href="#" wire:click.prevent="openDeleteModal({{$model}})"
		{{ $attributes->class(['text-red-700 hover:text-gray-300']) }}>
	<i class="fa-solid fa-trash"></i>
</a>
