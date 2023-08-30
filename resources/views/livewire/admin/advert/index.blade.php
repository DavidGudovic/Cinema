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

    <!-- Filter for Status -->
    <x-table.status-filter/>

    <!-- Filter for User -->
    <x-table.user-filter class="md:flex hidden"/>

    <!-- Sort all or shown-->
    <x-table.sort-options/>

@endsection

@section('right_filters')
    <!-- Paginate quantity-->
    <x-table.paginate-quantity class="hidden md:flex "/>
    <!-- End Paginate quantity-->

    <!-- Filter for User -->
    <x-table.user-filter class="md:hidden flex"/>

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
        <tr x-data="{showToolTip{{$advert->id}}: false}" class="odd:bg-dark-blue text-center relative">

            <x-table.data class="text-sm">
                <x-slot:sort>businessRequest.created_at</x-slot:sort>
                {{ $advert->businessRequest->created_at->format('H:i d/m/y') }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>title</x-slot:sort>
                {{ $advert->title }}
            </x-table.data>

            <td x-on:mouseenter="showToolTip{{$advert->id}} = true"
                x-on:mouseleave="showToolTip{{$advert->id}} = false"
                class="group m-2 line-clamp-2">{{ implode(' ',explode(' ', $advert->businessRequest->text, 3))}}
                <span x-cloak x-show="showToolTip{{$advert->id}}"
                      class=" transition-opacity bg-gray-800 text-gray-100 p-2 text-sm rounded-md  absolute left-52 top-0 z-20 w-96 h-auto">
                    {{$advert->businessRequest->text}}
                </span>
            </td>

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

            <x-table.data class="p-2">
                <div class="flex gap-5 justify-center items-center h-full">
                    @if($advert->businessRequest->status == 'PENDING')
                        <a href="{{route('adverts.edit', ['advert' => $advert, 'action' => 'ACCEPT'])}}">
                            <i class="fa-solid fa-check"></i>
                        </a>
                        <a href="{{route('adverts.edit', ['advert' => $advert, 'action' => 'REJECT'])}}"
                           class="text-red-700 hover:text-white">
                            <i class="fa-solid fa-x"></i>
                        </a>

                    @else
                        <a href="#" aria-disabled="true" class="hover:text-white opacity-30 cursor-default">
                            <i class="fa-solid fa-check"></i>
                        </a>
                        <a href="#" aria-disabled="true" class="opacity-30 cursor-default text-red-700">
                            <i class="fa-solid fa-x"></i>
                        </a>

                    @endif
                </div>
            </x-table.data>
        </tr>
    @endforeach
@endsection

@section('pagination')
    {{$adverts->links()}}
@endsection


