@props(['movies'])

<div x-on:click="showAddDropdown = !showAddDropdown" x-on:click.outside="showAddDropdown = false"
		{{ $attributes->merge(['class' => 'group cursor-pointer relative border rounded p-2 gap-2 mt-6 items-center bg-gray-700 bg-opacity-70']) }}>
	<span class="group-hover:text-red-700" >Dodaj </span>
	<i class="group-hover:text-red-700 fa-solid fa-plus"></i>
	<!-- Dropdown -->
	<div x-cloak x-show="showAddDropdown"
	     class="absolute z-10 top-10 left-0 flex flex-col justify-center p-2 bg-neutral-500 rounded-lg w-44">
		@foreach($movies as $movie)
			<a href="{{route('screenings.create', ['movie' => $movie])}}"
			   class="text-center w-full">{{$movie->title}}</a>
		@endforeach
	</div>
	<!-- End Dropdown -->
</div>
