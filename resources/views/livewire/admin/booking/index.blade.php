@extends('templates.components.table')

@section('left_filters')
    <!-- Filter for Hall-->
    <x-table.filter>
        <x-slot:title>Sala</x-slot:title>
        <x-slot:model>hall_id</x-slot:model>
        <x-slot:options>
            <option class="cursor-pointer" value="0">Sve</option>
            @foreach($halls as $hall)
                <option class="cursor-pointer" value="{{$hall->id}}">{{$hall->name}}</option>
            @endforeach
        </x-slot:options>
    </x-table.filter>
    <!-- End filter for Hall-->

    <!-- Filter for Status -->
    <x-table.status-filter/>
    <!-- End filter for Status -->

    <!-- Filter for User -->
    <x-table.user-filter class="hidden md:flex"/>
    <!-- End filter for User -->

    <!-- Sort all or shown-->
    <x-table.sort-options/>
    <!-- End Sort all or shown-->

@endsection

@section('right_filters')
    <!-- Paginate quantity-->
    <x-table.paginate-quantity class="hidden md:flex "/>
    <!-- End Paginate quantity-->

    <!-- Filter for User Responsive workaround-->
    <x-table.user-filter class="md:hidden flex"/>

    <!-- Search Bar -->
    <x-table.search-bar>
        <x-slot:placeholder>Sali</x-slot:placeholder>
    </x-table.search-bar>
    <!-- End Search Bar -->

    <!-- CSV -->
    <x-table.csv-button/>
    <!-- End CSV -->
@endsection

@section('table_header')
    <x-table.header-sortable>
        <x-slot:sort>businessRequest.created_at</x-slot:sort>
        Kreiran
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>hall.name</x-slot:sort>
        Sala
    </x-table.header-sortable>

    <th class="p-2 w-32">Tekst</th>

    <x-table.header-sortable>
        <x-slot:sort>start_time</x-slot:sort>
        Početak
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>end_time</x-slot:sort>
        Kraj
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>businessRequest.status</x-slot:sort>
        Status
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>businessRequest.user_id</x-slot:sort>
        Korisnik
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>businessRequest.price</x-slot:sort>
        Cena
    </x-table.header-sortable>

    <th class="p-2"> Akcije</th>
@endsection

@section('table_body')
    @foreach($bookings as $booking)
        <tr wire:key="{{$booking->id}}" class="odd:bg-dark-blue text-center relative">

            <x-table.data class="text-sm">
                <x-slot:sort>businessRequest.created_at</x-slot:sort>
                {{ $booking->businessRequest->created_at->format('H:i d/m/y') }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>hall.name</x-slot:sort>
                {{ $booking->hall->name }}
            </x-table.data>

            <x-table.data-with-tooltip>
                <x-slot:model>{{$booking->id}}</x-slot:model>
                <x-slot:text>{{$booking->businessRequest->text}}</x-slot:text>
                <x-slot:position>left-52 top-0</x-slot:position>
            </x-table.data-with-tooltip>

            <x-table.data class="text-sm">
                <x-slot:sort>start_time</x-slot:sort>
                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $booking->start_time)->format('m/d/y H:i') }}
            </x-table.data>

            <x-table.data class="text-sm">
                <x-slot:sort>end_time</x-slot:sort>
                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $booking->end_time)->format('H:i')  }}
            </x-table.data>

            <x-table.data class="text-sm">
                <x-slot:sort>businessRequest.status</x-slot:sort>
                {{ $status_translations[$booking->businessRequest->status] }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>businessRequest.user_id</x-slot:sort>
                {{ $booking->businessRequest->user_id }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>businessRequest.price</x-slot:sort>
                {{ $booking->businessRequest->price }}
            </x-table.data>

            <x-table.actions>
                <x-table.actions.button
                    :enabled="$booking->businessRequest->status == 'PENDING' && $booking->start_time > now()">
                    <x-slot:route> {{route('bookings.edit', ['booking' => $booking, 'action' => 'ACCEPT'])}} </x-slot:route>
                    <x-slot:icon><i class="fa-solid fa-check"></i></x-slot:icon>
                </x-table.actions.button>

                <x-table.actions.button
                    :enabled="$booking->businessRequest->status == 'PENDING' && $booking->start_time > now()"
                    class="text-red-700 hover:text-white">
                    <x-slot:route> {{route('bookings.edit', ['booking' => $booking, 'action' => 'REJECT'])}} </x-slot:route>
                    <x-slot:icon><i class="fa-solid fa-x"></i></x-slot:icon>
                </x-table.actions.button>
            </x-table.actions>
        </tr>
    @endforeach
@endsection

@section('pagination')
    {{$bookings->links()}}
@endsection


