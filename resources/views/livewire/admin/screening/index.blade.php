@extends('templates.components.table')

@section('left_filters')
    <!-- Filter for Movies -->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="movie">Film</label>
        <select wire:change="resetPage" id="movie"
                class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70 w-36 md:w-auto" wire:model="movie">
            <option class="cursor-pointer" value='all'>Sve</option>
            @foreach($movies as $movie)
                <option class="cursor-pointer" value='{{$movie->id}}'>{{$movie->title}}</option>
            @endforeach
        </select>
    </div>

    <!-- Filter for Halls -->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="hall">Sala</label>
        <select wire:change="resetPage" id="hall"
                class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70"
                wire:model="hall">
            <option class="cursor-pointer" value="all">Sve</option>
            @foreach($halls as $hall)
                <option class="cursor-pointer" value="{{$hall->id}}">{{$hall->name}}</option>
            @endforeach
        </select>
    </div>

    <!-- Filter for Next Screening -->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="screening_time">Vreme</label>
        <select wire:change="resetPage" id="screening_time"
                class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70"
                wire:model="screening_time">
            <option class="cursor-pointer" value="any">Bilo kada</option>
            <option class="cursor-pointer" value="now">Danas</option>
            <option class="cursor-pointer" value="tomorrow">Sutra</option>
            <option class="cursor-pointer" value="week">Ove nedelje</option>
            <option class="cursor-pointer" value="with past">Sa prošlim</option>
        </select>
    </div>


    <!-- Sort all or shown MD-->
    <div class="hidden md:flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="sort">Sortiraj</label>
        <select id="sort" class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70"
                wire:model="global_sort">
            <option class="cursor-pointer" value='false'>Prikazano</option>
            <option class="cursor-pointer" value='true'>Sve podatke</option>
        </select>
    </div>
@endsection

@section('right_filters')

    <!-- Sort all or shown SM-->
    <div class="md:hidden flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="sort">Sortiraj</label>
        <select id="sort" class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70"
                wire:model="global_sort">
            <option class="cursor-pointer" value='false'>Prikazano</option>
            <option class="cursor-pointer" value='true'>Sve podatke</option>
        </select>
    </div>

    <!-- Paginate quantity-->
    <div class="hidden md:flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="sort">Prikaži</label>
        <select wire:change="resetPage" id="sort"
                class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70" wire:model="quantity">
            <option class="cursor-pointer" value="5">5</option>
            <option class="cursor-pointer" value="10">10</option>
            <option class="cursor-pointer" value="15">15</option>
            <option class="cursor-pointer" value="20">20</option>
            <option class="cursor-pointer" value="25">25</option>
            <option class="cursor-pointer" value="50">50</option>
            <option class="cursor-pointer" value="100">100</option>
        </select>
    </div>
    <!-- End Paginate quantity-->

    <!-- Search Bar -->
    <div class="relative flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="search">Pretraži po</label>
        <input id="search" type="text" wire:model.debounce.300ms="search_query" wire:change.debounce="refreshPage"
               placeholder="Tagu, zanru, reziseru..."
               class="border rounded p-2 pl-8 bg-neutral-700 bg-opacity-70 w-36 md:w-auto">
        <i class="fa-solid fa-search absolute left-2 bottom-1 transform -translate-y-2/4"></i>
    </div>
    <!-- End Search Bar -->

    <!-- CSV -->
    <div x-on:click="showExcelDropdown = !showExcelDropdown" x-on:click.outside="showExcelDropdown = false"
         wire:loading.class.remove="cursor-pointer hover:text-red-700" wire:loading.class="opacity-50"
         class=" flex items-center cursor-pointer group relative border rounded p-2 gap-2 mt-6 bg-neutral-700 bg-opacity-70">
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
    <!-- End CSV -->
@endsection

@section('table_header')
    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'movie_id' }"
        wire:click="setSort('movie_id')" class="cursor-pointer p-2 w-48"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Film
    </th>

    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'hall_id' }"
        wire:click="setSort('hall_id')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Sala
    </th>

    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'start_time' }"
        wire:click="setSort('start_time')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Početak
    </th>

    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'end_time' }"
        wire:click="setSort('end_time')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Kraj
    </th>
    <th class="p-2">
        Tag
    </th>
    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'tickets_count' }"
        wire:click="setSort('tickets_count')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Rezervacije
    </th>
    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'adverts_count' }"
        wire:click="setSort('adverts_count')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
       Reklame
    </th>
    <th class="cursor-pointer p-2 w-24">
        Otkaži
    </th>
@endsection

@section('table_body')
    @foreach($screenings as $screening)
        <tr class="odd:bg-neutral-950 odd:bg-opacity-30 text-center relative">

            <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'movie_id' }"
                class="p-2 text-start">{{ $screening->movie->title }}</td>
            <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'hall_id' }"
                class="p-2">{{ $screening->hall->name }}</td>
            <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'start_time' }"
                class="m-2">{{ Carbon\Carbon::parse($screening->start_time)->format('d/m H:i') }}</td>
            <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'end_time' }"
                class="p-2">{{ Carbon\Carbon::parse($screening->end_time)->format('H:i') }}</td>
            <!-- Tags -->
            <td class="p-2 text-sm">
                @foreach($screening->tags as $tag)
                    {{$tag->name}}
                    @if(!$loop->last)
                        ,
                    @endif
                @endforeach
            </td>
            <!-- End tags -->
            <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'tickets_count' }"
                class="p-2">{{ $screening->tickets_count }}</td>
            <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'adverts_count' }"
                class="p-2">{{ $screening->adverts_count }}</td>

            <!-- Cancel Screening -->
            <td class="p-2">
                <div class="flex gap-5 justify-center items-center h-full">
                    @if($screening->start_time > now())
                        <a wire:click.prevent="$emit('showModal', {{$screening}})" class="text-red-700 hover:text-white">
                            <i class="fa-solid fa-x"></i>
                        </a>
                    @else

                        <a href="#" aria-disabled="true" class="opacity-30 cursor-default text-red-700" >
                            <i class="fa-solid fa-x"></i>
                        </a>
                    @endif
                </div>
            </td>
            <!-- End Cancel Screening -->
        </tr>
    @endforeach
@endsection

@section('pagination')
    {{$screenings->links()}}
@endsection

@section('modals')
    @livewire('admin.screening.delete-modal')
@endsection


