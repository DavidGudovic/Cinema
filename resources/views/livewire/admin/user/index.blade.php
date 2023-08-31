@extends('templates.components.table')

@section('left_filters')
    <x-table.filter>
        <x-slot:title>Verifikacija</x-slot:title>
        <x-slot:model>is_verified</x-slot:model>
        <x-slot:options>
            <option value="all">Svi</option>
            <option value="verified">Verifikovani</option>
            <option value="unverified">Ne verifikovani</option>
        </x-slot:options>
    </x-table.filter>

    <x-table.filter>
        <x-slot:title>Rola</x-slot:title>
        <x-slot:model>role</x-slot:model>
        <x-slot:options>
            <option value="">Svi</option>
            @foreach($roles as $role => $name)
                <option value="{{$role}}">{{$name}}</option>
            @endforeach
        </x-slot:options>
    </x-table.filter>

    <x-table.sort-options/>
@endsection

@section('right_filters')

    <x-table.paginate-quantity class="flex"/>

    <x-table.search-bar>
        <x-slot:placeholder>Ime, Email, Korisničko ime</x-slot:placeholder>
    </x-table.search-bar>

    <x-table.csv-button/>
@endsection

@section('table_header')
    <x-table.header-sortable class="w-24">
        <x-slot:sort>id</x-slot:sort>
        ID
    </x-table.header-sortable>

    <x-table.header-sortable class="w-52">
        <x-slot:sort>email</x-slot:sort>
        Email
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>username</x-slot:sort>
        Korisničko ime
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>name</x-slot:sort>
        Ime
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>email_verified_at</x-slot:sort>
        Verifikovan
    </x-table.header-sortable>

    <x-table.header-sortable>
        <x-slot:sort>role</x-slot:sort>
        Rola
    </x-table.header-sortable>

    <th class="p-2">Akcije</th>
@endsection

@section('table_body')
    @foreach($users as $user)
        <x-table.row :key="$user->id">
            <x-table.data>
                <x-slot:sort>id</x-slot:sort>
                {{$user->id}}
            </x-table.data>

            <x-table.data class="text-left pl-2 text-sm">
                <x-slot:sort>email</x-slot:sort>
                {{$user->email}}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>username</x-slot:sort>
                {{$user->username}}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>name</x-slot:sort>
                {{$user->name}}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>email_verified_at</x-slot:sort>
                {{$user->email_verified_at?->format('d/m/y H:i') ?? 'Ne'}}
            </x-table.data>

            <x-table.data>
                <x-slot:sort>role</x-slot:sort>
                {{$user->role->toSrLatinString()}}
            </x-table.data>

            <x-table.actions>
                <x-table.actions.button>
                    <x-slot:route>
                        {{route('users.update', $user)}}
                    </x-slot:route>

                    <x-slot:icon>
                        <i class="fa-solid fa-edit"></i>
                    </x-slot:icon>
                </x-table.actions.button>

                <x-table.actions.button>
                    <x-slot:route>
                        {{route('users.destroy', $user)}}
                    </x-slot:route>

                    <x-slot:icon>
                        <i class="fa-solid fa-trash"></i>
                    </x-slot:icon>
                </x-table.actions.button>
            </x-table.actions>
        </x-table.row>
    @endforeach
@endsection

@section('pagination')
    {{$users->links()}}
@endsection

@section('modals')
@endsection


