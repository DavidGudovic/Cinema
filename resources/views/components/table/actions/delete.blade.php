@props(['model', 'enabled' => true])

@if($enabled)
    <a href="#" wire:click.prevent="openDeleteModal({{$model}})"
        {{ $attributes->class(['text-red-700 hover:text-gray-300']) }}>
        <i class="fa-solid fa-trash"></i>
    </a>
@else
    <a href="#" aria-disabled="true" class='opacity-50 cursor-default text-red-700'>
        <i class="fa-solid fa-trash"></i>
    </a>
@endif
