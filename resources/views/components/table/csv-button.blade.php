<div x-on:click="showExcelDropdown = !showExcelDropdown" x-on:click.outside="showExcelDropdown = false"
     wire:loading.class.remove="cursor-pointer hover:text-red-700" wire:loading.class="opacity-50"
		{{ $attributes->class([' flex items-center cursor-pointer group relative border rounded p-2 gap-2 mt-6 bg-gray-700 bg-opacity-70']) }}>
	<span class="group-hover:text-red-700">Excel</span>
	<i class="group-hover:text-red-700 fa-solid fa-file-csv"></i>
	<i class="group-hover:text-red-700 fa-solid fa-angle-down fa-xs pt-1"></i>
	<!-- Dropdown -->
	<div x-cloak x-show="showExcelDropdown"
	     class="absolute z-10 top-10 left-0 flex flex-col justify-center p-2 bg-neutral-500 rounded-lg">
		<a href="#" wire:click.prevent="export('global')" class="text-center w-full">Sve</a>
		<a href="#" wire:click.prevent="export('displayed')" class="text-center w-full">Prikazano</a>
	</div>
	<!-- End Dropdown -->
</div>
