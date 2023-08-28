@extends('templates.components.table')

@section('left_filters')
    <!-- Filter for Hall-->
    <div class="flex flex-col gap-1">
        <label class="opacity-40 text-sm" for="genres">Sala</label>
        <select wire:change="resetPage" id="genres"
                class="border rounded cursor-pointer p-2 bg-gray-700 bg-opacity-70" wire:model="hall_id">
            <option class="cursor-pointer" value="0">Sve</option>
            @foreach($halls as $hall)
                <option class="cursor-pointer" value="{{$hall->id}}">{{$hall->name}}</option>
            @endforeach
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

    <!-- Filter for User Responsive workaround-->
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
               placeholder="Sali..."
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
    <th x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'businessRequest.created_at' }"
        wire:click="setSort('businessRequest.created_at')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Kreiran
    </th>

    <th x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'hall.name' }"
        wire:click="setSort('hall.name')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Sala
    </th>

    <th class="p-2 w-32">Tekst</th>

    <th x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'start_time' }"
        wire:click="setSort('start_time')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Početak
    </th>

    <th x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'end_time' }"
        wire:click="setSort('end_time')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Kraj
    </th>

    <th x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'businessRequest.status' }"
        wire:click="setSort('businessRequest.status')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Status
    </th>
    <th x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'businessRequest.user_id' }"
        wire:click="setSort('businessRequest.user_id')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Korisnik
    </th>
    <th x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'businessRequest.price' }"
        wire:click="setSort('businessRequest.price')" class="cursor-pointer p-2"><i
            class="fa-solid fa-sort opacity-40 fa-xs"></i>
        Cena
    </th>
    <th class="cursor-pointer p-2">
        Akcije
    </th>
@endsection

@section('table_body')
    @foreach($bookings as $booking)
        <tr x-data="{showToolTip{{$booking->id}}: false}"
            class="odd:bg-dark-blue text-center relative">
            <td x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'businessRequest.created_at' }"
                class="p-2 text-sm">{{ $booking->businessRequest->created_at->format('H:i d/m/y') }}</td>

            <td x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'hall.name' }"
                class="p-2">{{ $booking->hall->name }}</td>

            <td x-on:mouseenter="showToolTip{{$booking->id}} = true"
                x-on:mouseleave="showToolTip{{$booking->id}} = false"
                class="group m-2 line-clamp-2">{{ implode(' ',explode(' ', $booking->businessRequest->text, 3))}}
                <span x-cloak x-show="showToolTip{{$booking->id}}"
                      class=" transition-opacity bg-gray-800 text-gray-100 p-2 text-sm rounded-md  absolute left-52 top-0 z-20 w-96 h-auto">
                    {{$booking->businessRequest->text}}
                </span>
            </td>

            <td x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'start_time' }"
                class="p-2 text-sm">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $booking->start_time)->format('m/d/y H:i') }}</td>
            <td x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'end_time' }"
                class="p-2 text-sm">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $booking->end_time)->format('H:i')  }}</td>
            <td x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'businessRequest.status' }"
                class="p-2 text-sm">{{ $status_translations[$booking->businessRequest->status] }}</td>
            <td x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'businessRequest.user_id' }"
                class="p-2">{{ $booking->businessRequest->user_id }}</td>
            <td x-bind:class="{ 'bg-gray-700 bg-opacity-30': sortBy === 'businessRequest.price' }"
                class="p-2">{{ $booking->businessRequest->price}}
            </td>
            <td class="p-2">
                <div class="flex gap-5 justify-center items-center h-full">
                    @if($booking->businessRequest->status == 'PENDING' && $booking->start_time > now())
                        <a href="{{route('bookings.edit', ['booking' => $booking, 'action' => 'ACCEPT'])}}">
                            <i class="fa-solid fa-check"></i>
                        </a>
                        <a href="{{route('bookings.edit', ['booking' => $booking, 'action' => 'REJECT'])}}"
                           class="text-red-700 hover:text-white">
                            <i class="fa-solid fa-x"></i>
                        </a>

                    @else
                        <a href="#" aria-disabled="true" class="hover:text-white opacity-10 cursor-default">
                            <i class="fa-solid fa-check"></i>
                        </a>
                        <a href="#" aria-disabled="true" class="opacity-10 cursor-default text-red-700">
                            <i class="fa-solid fa-x"></i>
                        </a>

                    @endif
                </div>
            </td>
        </tr>
    @endforeach
@endsection

@section('pagination')
    {{$bookings->links()}}
@endsection

@section('modals')
@endsection


