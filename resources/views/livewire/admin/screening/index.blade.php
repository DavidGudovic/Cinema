@extends('templates.components.table')

@section('left_filters')
    <!-- Filter for Movies -->
    <x-table.filter class="w-32 md:w-auto">
        <x-slot:title>Film</x-slot:title>
        <x-slot:model>movie</x-slot:model>
        <x-slot:options>
            <option class="cursor-pointer" value='all'>Sve</option>
            @foreach($movies as $movie)
                <option class="cursor-pointer" value='{{$movie->id}}'>{{$movie->title}}</option>
            @endforeach
        </x-slot:options>
    </x-table.filter>
    <!-- End filter for Movies-->

    <!-- Filter for Halls -->
    <x-table.filter>
        <x-slot:title>Sala</x-slot:title>
        <x-slot:model>hall</x-slot:model>
        <x-slot:options>
            <option class="cursor-pointer" value="all">Sve</option>
            @foreach($halls as $hall)
                <option class="cursor-pointer" value="{{$hall->id}}">{{$hall->name}}</option>
            @endforeach
        </x-slot:options>
    </x-table.filter>
    <!-- End filter for Halls-->

    <!-- Filter for Next Screening -->
    <x-table.screening-time/>
    <!-- End filter for next screening -->


    <!-- Sort all or shown MD-->
    <x-table.sort-options class="hidden md:flex"/>
    <!-- End Sort all or shown MD-->
@endsection

@section('right_filters')

    <!-- Sort all or shown SM-->
    <x-table.sort-options class="md:hidden flex"/>
    <!-- End Sort all or shown SM-->

    <!-- Paginate quantity-->
    <x-table.paginate-quantity class="hidden md:flex "/>
    <!-- End Paginate quantity-->

    <!-- Search Bar -->
    <x-table.search-bar class="w-32 md:w-auto">
        <x-slot:placeholder>Tagu, zanru, reziseru</x-slot:placeholder>
    </x-table.search-bar>
    <!-- End Search Bar -->

    <!-- Add Screening -->
    <x-table.add-screening-dropdown :movies="$movies" class="hidden md:flex"/>
    <!-- End add screening -->

    <!-- CSV -->
    <x-table.csv-button/>
    <!-- End CSV -->
@endsection

@section('responsive_filters')
    <!-- Add Screening -->
    <x-table.add-screening-dropdown :movies="$movies" class="flex md:hidden"/>
    <!-- End add screening -->

    <!-- Paginate quantity-->
    <x-table.paginate-quantity class="md:hidden flex"/>
    <!-- End Paginate quantity-->
@endsection

@section('table_header')
    <x-table.header-sortable class="w-52">
        <x-slot:sort>movie_id</x-slot:sort>
        Film
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>hall_id</x-slot:sort>
        Sala
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>start_time</x-slot:sort>
        Početak
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>end_time</x-slot:sort>
        Kraj
    </x-table.header-sortable>

    <th class="p-2"> Tag</th>

    <x-table.header-sortable>
        <x-slot:sort>tickets_count</x-slot:sort>
        Rezervacije
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>adverts_count</x-slot:sort>
        Reklame
    </x-table.header-sortable>

    <th class="p-2 w-24"> Otkaži</th>
@endsection

@section('table_body')
    @foreach($screenings as $screening)
        <x-table.row :key="$screening->id">
            <x-table.data class="text-start">
                <x-slot:sort>movie_id</x-slot:sort>
                {{ $screening->movie->title }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>hall_id</x-slot:sort>
                {{ $screening->hall->name }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>start_time</x-slot:sort>
                {{ Carbon\Carbon::parse($screening->start_time)->format('d/m/y H:i') }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>end_time</x-slot:sort>
                {{ Carbon\Carbon::parse($screening->end_time)->format('H:i') }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>none</x-slot:sort>
                @foreach($screening->tags as $tag)
                    {{$tag->name}}
                    @if(!$loop->last)
                        ,
                    @endif
                @endforeach
            </x-table.data>

            <x-table.data>
                <x-slot:sort>tickets_count</x-slot:sort>
                {{ $screening->tickets_count }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>adverts_count</x-slot:sort>
                {{ $screening->adverts_count }}
            </x-table.data>

            <!-- Cancel Screening -->
            <x-table.actions>
                    @if($screening->start_time > now())
                        <a wire:click.prevent="$emit('showModal', {{$screening}})"
                           class="text-red-700 hover:text-white">
                            <i class="fa-solid fa-x"></i>
                        </a>
                    @else
                        <a href="#" aria-disabled="true" class="opacity-30 cursor-default text-red-700">
                            <i class="fa-solid fa-x"></i>
                        </a>
                    @endif
            </x-table.actions>
            <!-- End Cancel Screening -->
        </x-table.row>
    @endforeach
@endsection

@section('pagination')
    {{$screenings->links()}}
@endsection

@section('modals')
    @livewire('admin.screening.delete-modal')
@endsection


