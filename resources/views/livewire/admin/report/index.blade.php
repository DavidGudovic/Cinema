@extends('templates.components.table')

@section('left_filters')
    <x-table.filter class="w-16 md:w-auto">
        <x-slot:title>Sala</x-slot:title>
        <x-slot:model>hall_id</x-slot:model>
        <x-slot:options>
            <option value="0">Sve</option>
            @foreach($halls as $hall)
                <option value="{{ $hall->id }}">{{ $hall->name }}</option>
            @endforeach
        </x-slot:options>
    </x-table.filter>

    <x-table.filter class="w-24 md:w-auto">
        <x-slot:title>Menadžer</x-slot:title>
        <x-slot:model>user_id</x-slot:model>
        <x-slot:options>
            <option value="0">Sve</option>
            <option value="">Bez menadžera</option>
            @foreach($managers as $manager)
                <option value="{{ $manager->id }}">{{ $manager->username }}</option>
            @endforeach
        </x-slot:options>
    </x-table.filter>

    <x-table.filter>
        <x-slot:title>Period</x-slot:title>
        <x-slot:model>period</x-slot:model>
        <x-slot:options>
            <option value="0">Sve</option>
            @foreach($periods as $key => $period)
                <option value="{{ $key }}">{{ $period }}</option>
            @endforeach
        </x-slot:options>
    </x-table.filter>

    <x-table.sort-options class="w-20 md:w-auto"/>

@endsection

@section('right_filters')
    <x-table.paginate-quantity class="flex"/>

    <x-table.search-bar>
        <x-slot:placeholder>Period, sala, menadžer</x-slot:placeholder>
    </x-table.search-bar>

    <x-table.csv-button/>
@endsection

@section('responsive_filters')
@endsection

@section('table_header')
    <x-table.header-sortable>
        <x-slot:sort>created_at</x-slot:sort>
        Kreiran
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>hall_id</x-slot:sort>
        Sala
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>user_id</x-slot:sort>
        Menadžer
    </x-table.header-sortable>

    <th class="p-2">Tekst</th>

    <x-table.header-sortable>
        <x-slot:sort>period</x-slot:sort>
        Period
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>date_from</x-slot:sort>
        Od datuma
    </x-table.header-sortable>

    <th class="p-2">PDF</th>
@endsection

@section('table_body')
    @foreach($reports as $report)
        <x-table.row :key="$report->id">

            <x-table.data class="text-sm">
                <x-slot:sort>created_at</x-slot:sort>
                {{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y H:i') }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>hall_id</x-slot:sort>
                {{ $report->hall->name }}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>user_id</x-slot:sort>
                {{ $report->user?->username ?? 'Menadžer izbrisan' }}
            </x-table.data>

            <x-table.data-with-tooltip>
                <x-slot:model>{{$report->id}}</x-slot:model>
                <x-slot:text>{{$report->text}}</x-slot:text>
                <x-slot:position>top-0 right-40</x-slot:position>
            </x-table.data-with-tooltip>

            <x-table.data>
                <x-slot:sort>period</x-slot:sort>
                {{ $periods[$report->period->value] }}
            </x-table.data>

            <x-table.data class="text-sm">
                <x-slot:sort>date_from</x-slot:sort>
                {{ \Carbon\Carbon::parse($report->date_from)->format('d/m/Y') }}
            </x-table.data>

            <x-table.actions>
                <x-table.actions.button :livewire='true' wire:click.prevent="exportReport({{$report}})">
                    <x-slot:icon><i class="fa-solid fa-download"></i></x-slot:icon>
                </x-table.actions.button>
            </x-table.actions>
        </x-table.row>
    @endforeach
@endsection

@section('pagination')
    {{$reports->links()}}
@endsection

@section('modals')
        <x-modal :name="'errorModal'" :livewire="true">
            <x-slot:entangle>showErrorModal</x-slot:entangle>
            <div class="relative flex flex-col gap-2 rounded-2xl bg-neutral-800 p-4 z-20">
                <x-close-button :modal="'errorModal'" class="top-6"/>
                <p class="text-center text-xl text-red-700">Fajl nije dostupan!</p>
                <p class="text-center font-bold">PDF koji ste tražili nije pronađen na serveru ili je korumpiran</p>
            </div>
        </x-modal>
@endsection



