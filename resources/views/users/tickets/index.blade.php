@extends('templates.user-profile')

@section('background-pattern') bg-user-profile bg-cover bg-no-repeat bg-center  @endsection

@section('window')
<div class="flex h-full w-full flex-row border border-white text-white">
    @livewire('users.tickets.index')
</div>
@endsection

@section('filters')
<div class="flex flex-col border border-white text-white px-8 md:w-72 bg-gray-950 bg-opacity-80">
    <form  x-data='{ movieFilter: 0, statusFilter: 0}' class="flex flex-col gap-1 py-4 "action="#" method="post">
        <p class="font-bold text-center">Filteri</p>
        <p>Film</p>
        <select  x-model="movieFilter" class="text-black" name="">
            <!-- movie filters -->
            <option value="0">Sve</option>
            @foreach($movies as $movie)
            <option value="{{$movie->id}}">{{$movie->title}}</option>
            @endforeach

        </select>
        <p>Status</p>
        <select  x-model:="statusFilter" class="text-black" name="">
            <!-- Status filters -->
            <option value="all">Sve</option>
            <option value="active">Aktivna</option>
            <option value="cancelled">Otkazana</option>
            <option value="inactive">Prosla</option>
        </select>
        <div class="flex flex-row gap-6 mt-4">
            <button x-on:click.prevent="window.livewire.emit('setOrderFilters', statusFilter, monthFilter)" type="submit" class="form-btn py-1">Primeni</button>
            <button x-on:click="movieFilter = 0; statusFilter = 0; window.livewire.emit('setMovieFilters', movieFilter, statusFilter)" type="reset" class="form-btn bg-gray-500 py-1">Resetuj</button>
        </div>
    </form>
</div>
@endsection
