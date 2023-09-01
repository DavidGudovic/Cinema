@extends('templates.components.table')

@section('left_filters')
    <x-table.status-filter :with_cancelled="false"/>

    <x-table.filter>
        <x-slot:model>type</x-slot:model>
        <x-slot:title>Tip zahteva</x-slot:title>
        <x-slot:options>
            <option value="">Svi tipovi</option>
            <option value="booking">Rentiranje</option>
            <option value="advert">Oglašavanje</option>
        </x-slot:options>
    </x-table.filter>

    <x-table.user-filter class="hidden md:flex"/>

    <x-table.sort-options/>
@endsection

@section('right_filters')
    <x-table.paginate-quantity class="flex"/>

    <x-table.search-bar>
        <x-slot:placeholder>Korisnik, zahtev</x-slot:placeholder>
    </x-table.search-bar>

    <x-table.csv-button/>
@endsection

@section('responsive_filters')
@endsection

@section('table_header')
    <x-table.header-sortable>
        <x-slot:sort>created_at</x-slot:sort>
        Datum
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>user_id</x-slot:sort>
        Korisnik
    </x-table.header-sortable>

    <th class="p-2 w-32">Tekst</th>

    <x-table.header-sortable>
        <x-slot:sort>status</x-slot:sort>
        Status
    </x-table.header-sortable>

    <th class="p-2 w-32">Komentar</th>

    <x-table.header-sortable>
        <x-slot:sort>business_request_id</x-slot:sort>
        Zahtev ID
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>businessRequest.requestable_type</x-slot:sort>
        Tip zahteva
    </x-table.header-sortable>

    <th class="p-2">Akcije</th>

@endsection

@section('table_body')
    @foreach($reclamations as $reclamation)
        <x-table.row :key="$reclamation->id">
            <x-table.data>
                <x-slot:sort>created_at</x-slot:sort>
                {{\Carbon\Carbon::parse($reclamation->created_at)->format('m/d/y H:i')}}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>user_id</x-slot:sort>
                {{$reclamation->user_id}}
            </x-table.data>

            <x-table.data-with-tooltip>
                <x-slot:model>{{$reclamation->id}}</x-slot:model>
                <x-slot:text>{{$reclamation->text}}</x-slot:text>
                <x-slot:position>top-0 inset-x-0</x-slot:position>
            </x-table.data-with-tooltip>

            <x-table.data>
                <x-slot:sort>status</x-slot:sort>
                {{\App\Enums\Status::from($reclamation->status)->toSrLatinString()}}
            </x-table.data>

            <x-table.data-with-tooltip :tool-tip-index="1">
                <x-slot:model>{{$reclamation->id}}</x-slot:model>
                <x-slot:text>{{$reclamation->comment}}</x-slot:text>
                <x-slot:position>top-0 inset-x-100</x-slot:position>
            </x-table.data-with-tooltip>

            <x-table.data>
                <x-slot:sort>business_request_id</x-slot:sort>
                {{$reclamation->business_request_id}}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>businessRequest.requestable_type</x-slot:sort>
                {{($reclamation->businessRequest->requestable_type == 'App\Models\Booking') ? 'Rentiranje' : 'Oglašavanje'}}
            </x-table.data>

            <x-table.actions>
                <x-table.actions.button :enabled="$reclamation->status == 'PENDING'">
                    <x-slot:route>{{route('reclamations.edit', [$reclamation, 'action' => 'ACCEPT'])}}</x-slot:route>
                    <x-slot:icon><i class="fa-solid fa-check"></i></x-slot:icon>
                </x-table.actions.button>

                <x-table.actions.button :enabled="$reclamation->status == 'PENDING'" class="text-red-700 hover:text-gray-50" >
                    <x-slot:route>{{route('reclamations.edit', [$reclamation, 'action' => 'REJECT'])}}</x-slot:route>
                    <x-slot:icon><i class="fa-solid fa-x"></i></x-slot:icon>
                </x-table.actions.button>
            </x-table.actions>
        </x-table.row>
    @endforeach
@endsection

@section('pagination')
    {{$reclamations->links()}}
@endsection



