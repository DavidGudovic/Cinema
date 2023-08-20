@extends('templates.components.table')

@section('left_filters')
    <!-- Filter for Genre -->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="genres">Žanrovi</label>
        <select wire:change="refresh" id="genres"
                class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70" wire:model="genre">
            <option class="cursor-pointer" value=''>Svi žanrovi</option>
        </select>
    </div>

    <!-- Filter for Next Screening -->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="screening">Prikazuje se</label>
        <select wire:change="refresh" id="screening"
                class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70"
                wire:model="screening_time">
            <option class="cursor-pointer" value="with past">Ignoriši</option>
            <option class="cursor-pointer" value="week">Ove nedelje</option>
            <option class="cursor-pointer" value="now">Danas</option>
            <option class="cursor-pointer" value="tomorrow">Sutra</option>
            <option class="cursor-pointer" value="any">Bilo kada</option>
        </select>
    </div>

    <!-- Sort all or shown-->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="sort">Sortiraj</label>
        <select id="sort" class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70"
                wire:model="global_sort">
            <option class="cursor-pointer" value='false'>Prikazano</option>
            <option class="cursor-pointer" value='true'>Sve podatke</option>
        </select>
    </div>
@endsection

@section('right_filters')
    <!-- Paginate quantity-->
    <div class="hidden md:flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="sort">Prikaži</label>
        <select wire:change="refresh" id="sort"
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
        <input id="search" type="text" wire:model.debounce.300ms="search_query"
               placeholder="Naziv, Žanr, Režiser..."
               class="border rounded p-2 pl-8 bg-neutral-700 bg-opacity-70 w-44 md:w-auto">
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
    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'title' }"
        wire:click="setSort('title')" class="cursor-pointer p-2 w-40"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Naslov
    </th>
    <th class="p-2 w-32">Opis</th>
    <th class="p-2">Slika</th>
    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'release_date' }"
        wire:click="setSort('release_date')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Godina
    </th>
    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'duration' }"
        wire:click="setSort('duration')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Trajanje
    </th>
    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'genre_id' }"
        wire:click="setSort('genre_id')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Žanr
    </th>
    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'director' }"
        wire:click="setSort('director')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Režiser
    </th>
    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'is_showcased' }"
        wire:click="setSort('is_showcased')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Istaknuto
    </th>
    <th class="cursor-pointer p-2">
        Akcije
    </th>
@endsection

@section('table_body')
@endsection

@section('pagination')
@endsection

@section('modals')
@endsection


