@extends('templates.components.table')

@section('left_filters')
    <!-- Filter for Quantity -->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="genres">Količina</label>
        <select wire:change="resetPage" id="genres"
                class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70">
            <option class="cursor-pointer" value=''>Sve</option>
            <option class="cursor-pointer" value='done'>Ispunjena</option>
            <option class="cursor-pointer" value='in_progress'>Započeta</option>
            <option class="cursor-pointer" value='never_shown'>Nezapočeta</option>
        </select>
    </div>

    <!-- Filter for Status -->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="status">Status</label>
        <select wire:change="resetPage" id="status"
                class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70"
                wire:model="status">
            <option class="cursor-pointer" value="all">Sve</option>
            <option class="cursor-pointer" value="pending">Na čekanju</option>
            <option class="cursor-pointer" value="accepted">Odobreno</option>
            <option class="cursor-pointer" value="cancelled">Otkazano</option>
            <option class="cursor-pointer" value="rejected">Odbijeno</option>
        </select>
    </div>

    <!-- Filter for User -->
    <div class="hidden md:flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="user_id">Korisnik ID</label>
        <input type="number" id="user_id" min="0"
               class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70 w-24"
               wire:model="user_id" wire:change="resetPage"/>
    </div>

    <!-- Sort all or shown-->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="sort">Sortiraj</label>
        <select id="sort" class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70"
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
        <select wire:change="resetPage" id="sort"
                class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70" wire:model="quantity">
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

    <!-- Filter for User -->
    <div class="flex md:hidden flex-col gap-1">
        <label class="opacity-40 text-sm" for="user_id">Korisnik ID</label>
        <input type="number" id="user_id" min="0"
               class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70 w-16"
               wire:model="user_id" wire:change="resetPage"/>
    </div>

    <!-- Search Bar -->
    <div class="relative flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="search">Pretraži po</label>
        <input id="search" type="text" wire:model.debounce.300ms="search_query" wire:change.debounce="refreshPage"
               placeholder="Naziv, Delatnost..."
               class="border rounded p-2 pl-8 bg-gray-700 bg-opacity-70 w-44 md:w-auto">
        <i class="fa-solid fa-search absolute left-2 bottom-1 transform -translate-y-2/4"></i>
    </div>
    <!-- End Search Bar -->

    <!-- CSV -->
    <div x-on:click="showExcelDropdown = !showExcelDropdown" x-on:click.outside="showExcelDropdown = false"
         wire:loading.class.remove="cursor-pointer hover:text-red-700" wire:loading.class="opacity-50"
         class=" flex items-center cursor-pointer group relative border rounded p-2 gap-2 mt-6 bg-gray-700 bg-opacity-70">
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

@endsection

@section('table_body')

@endsection

@section('pagination')
@endsection

@section('modals')
@endsection


