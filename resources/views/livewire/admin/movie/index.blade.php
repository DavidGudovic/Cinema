@extends('templates.components.table')

@section('left_filters')
    <!-- Filter for Genre -->
    <x-table.filter>
        <x-slot:title>Žanr</x-slot:title>
        <x-slot:model>genre</x-slot:model>
        <x-slot:options>
            <option class="cursor-pointer" value="">Svi</option>
            @foreach($genres as $genre)
                <option class="cursor-pointer" value="{{$genre->id}}">{{$genre->name}}</option>
            @endforeach
        </x-slot:options>
    </x-table.filter>
    <!-- End filter for Genre-->

    <!-- Filter for Next Screening -->
    <x-table.screening-time/>
    <!-- End filter for next screening -->

    <!-- Sort all or shown-->
    <x-table.sort-options/>
    <!-- End Sort all or shown-->

    <!-- Paginate quantity-->
    <x-table.paginate-quantity class="hidden md:flex "/>
    <!-- End Paginate quantity-->
@endsection


@section('right_filters')

    <!-- Search Bar -->
    <x-table.search-bar>
        <x-slot:placeholder>Naziv, Žanr, Režiser</x-slot:placeholder>
    </x-table.search-bar>

    <!-- Add -->
    <x-table.button>
        <x-slot:route>{{route('movies.create')}}</x-slot:route>
        <span>Dodaj </span>
        <i class="fa-solid fa-plus"></i>
    </x-table.button>
    <!-- End Add -->

    <!-- CSV -->
    <x-table.csv-button/>

@endsection

@section('table_header')
    <x-table.header-sortable>
        <x-slot:sort>title</x-slot:sort>
        Naslov
    </x-table.header-sortable>

    <th class="p-2 w-32">Opis</th>

    <th class="p-2">Slika</th>

    <x-table.header-sortable>
        <x-slot:sort>release_date</x-slot:sort>
        Godina
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>duration</x-slot:sort>
        Trajanje
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>genre_id</x-slot:sort>
        Žanr
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>director</x-slot:sort>
        Režiser
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>is_showcased</x-slot:sort>
        Istaknuto
    </x-table.header-sortable>

    <th class="p-2"> Akcije</th>
@endsection

@section('table_body')
    @foreach($movies as $movie)
        <tr x-data="{showToolTip{{$movie->id}}: false}" class="odd:bg-dark-blue text-center relative ">

            <x-table.data>
                <x-slot:sort>title</x-slot:sort>
                {{ $movie->title }}
            </x-table.data>

           <x-table.data-with-tooltip>
               <x-slot:model>{{$movie->id}}</x-slot:model>
               <x-slot:text>{{$movie->description}}</x-slot:text>
               <x-slot:position>left-36 top-0</x-slot:position>
           </x-table.data-with-tooltip>

            <x-table.data>
                <x-slot:sort>none</x-slot:sort>
                {{ $movie->image_url }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>release_date</x-slot:sort>
                {{ $movie->release_year }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>duration</x-slot:sort>
                {{ $movie->duration }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>genre_id</x-slot:sort>
                {{ $genres[$movie->genre_id - 1]->name }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>director</x-slot:sort>
                {{ $movie->director }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>is_showcased</x-slot:sort>
                {{ $movie->is_showcased ? 'Da' : 'Ne' }}
            </x-table.data>

            <x-table.data>
                <div class="flex gap-5 justify-center items-center h-full">
                    <a href="{{route('screenings.create', ['movie' => $movie])}}">
                        <i class="fa-solid fa-clapperboard"></i>
                    </a>
                    <a href="{{route('movies.edit', $movie)}}" class="hover:text-gray-300">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="#" wire:click.prevent="openDeleteModal({{$movie->id}})"
                       class="text-red-700 hover:text-gray-300">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>
            </x-table.data>
        </tr>
    @endforeach
@endsection

@section('pagination')
    {{$movies->links()}}
@endsection

@section('modals')
    @livewire('admin.movie.delete-modal')
@endsection


