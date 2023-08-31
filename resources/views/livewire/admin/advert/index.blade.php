@extends('templates.components.table')

@section('left_filters')
    <!-- Filter for Quantity -->
    <x-table.filter>
        <x-slot:title>Količina</x-slot:title>
        <x-slot:model>quantity_left</x-slot:model>
        <x-slot:options>
            <option class="cursor-pointer" value=''>Sve</option>
            <option class="cursor-pointer" value='done'>Ispunjena</option>
            <option class="cursor-pointer" value='never_shown'>Nezapočeta</option>
        </x-slot:options>
    </x-table.filter>
    <!-- End Filter for Quantity -->

    <!-- Filter for Status -->
    <x-table.status-filter/>
    <!-- End Filter for Status -->

    <!-- Filter for User -->
    <x-table.user-filter class="md:flex hidden"/>
    <!-- End Filter for User -->

    <!-- Sort all or shown-->
    <x-table.sort-options/>
    <!-- End Sort all or shown-->

@endsection

@section('right_filters')
    <!-- Paginate quantity-->
    <x-table.paginate-quantity class="hidden md:flex "/>
    <!-- End Paginate quantity-->

    <!-- Filter for User -->
    <x-table.user-filter class="md:hidden flex"/>
    <!-- End Filter for User -->

    <!-- Search Bar -->
    <x-table.search-bar>
        <x-slot:placeholder>Naziv, Delatnost</x-slot:placeholder>
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
        <x-slot:sort>title</x-slot:sort>
        Naslov
    </x-table.header-sortable>

    <th class="p-2 w-32">Tekst</th>

    <x-table.header-sortable>
        <x-slot:sort>company</x-slot:sort>
        Delatnost
    </x-table.header-sortable>

    <th class="p-2 w-32">URL</th>

    <x-table.header-sortable>
        <x-slot:sort>quantity</x-slot:sort>
        Količina
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>quantity_remaining</x-slot:sort>
        Preostalo
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
    @foreach($adverts as $advert)
        <x-table.row :key="$advert->id">
            <x-table.data class="text-sm">
                <x-slot:sort>businessRequest.created_at</x-slot:sort>
                {{ $advert->businessRequest->created_at->format('H:i d/m/y') }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>title</x-slot:sort>
                {{ $advert->title }}
            </x-table.data>
            <x-table.data-with-tooltip>
                <x-slot:model>{{$advert->id}} </x-slot:model>
                <x-slot:text>{{$advert->businessRequest->text}}</x-slot:text>
                <x-slot:position>left-52 top-0</x-slot:position>
            </x-table.data-with-tooltip>

            <x-table.data>
                <x-slot:sort>company</x-slot:sort>
                {{ $advert->company }}
            </x-table.data>

            <x-table.data class="underlined">
                <x-slot:sort>none</x-slot:sort>
                <a target="_blank" href="{{ $advert->advert_url }}">
                    link
                    <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i>
                </a>
            </x-table.data>

            <x-table.data>
                <x-slot:sort>quantity</x-slot:sort>
                {{ $advert->quantity }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>quantity_remaining</x-slot:sort>
                {{ $advert->quantity_remaining }}
            </x-table.data>

            <x-table.data class="text-sm">
                <x-slot:sort>businessRequest.status</x-slot:sort>
                {{ $status_translations[$advert->businessRequest->status] }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>businessRequest.user_id</x-slot:sort>
                {{ $advert->businessRequest->user_id }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>businessRequest.price</x-slot:sort>
                {{ $advert->businessRequest->price }}
            </x-table.data>

            <x-table.actions>
                <x-table.actions.button :enabled="$advert->businessRequest->status == 'PENDING'">
                    <x-slot:route> {{route('adverts.edit', ['advert' => $advert, 'action' => 'ACCEPT'])}} </x-slot:route>
                    <x-slot:icon><i class="fa-solid fa-check"></i></x-slot:icon>
                </x-table.actions.button>

                <x-table.actions.button
                    :enabled="$advert->businessRequest->status == 'PENDING'"
                    class="text-red-700 hover:text-white">
                    <x-slot:route> {{route('adverts.edit', ['advert' => $advert, 'action' => 'REJECT'])}} </x-slot:route>
                    <x-slot:icon><i class="fa-solid fa-x"></i></x-slot:icon>
                </x-table.actions.button>
            </x-table.actions>
        </x-table.row>
    @endforeach
@endsection

@section('pagination')
    {{$adverts->links()}}
@endsection


