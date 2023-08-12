@extends('templates.user-profile')

@section('background-pattern') bg-user-profile bg-cover bg-no-repeat bg-center  @endsection

@section('window')
<div class="flex h-full w-full flex-row border border-white text-white">
    @livewire('users.business.reclamations.index')
</div>
@endsection

@section('filters')
<div class="flex flex-col border border-white text-white px-8 md:w-72 bg-gray-950 bg-opacity-80">
    <form  x-data='{ typeFilter: 0, statusFilter: 0}' class="flex flex-col gap-1 py-4 "action="#" method="post">
        <p class="font-bold text-center">Filteri</p>
        <p>Tip zahteva</p>
        <select  x-model="typeFilter" class="text-black" name="">
            <!-- type filters -->
            <option value="0">Svi</option>
            <option value="advert">Reklama</option>
            <option value="booking">Renta</option>

        </select>
        <p>Status</p>
        <select  x-model:="statusFilter" class="text-black" name="">
            <!-- Status filters -->
            <option value="all">Sve</option>
            <option value="pending">Na čekanju</option>
            <option value="accepted">Prihvaćena</option>
            <option value="rejected">Odbijena</option>
        </select>
        <div class="flex flex-row gap-6 mt-4">
            <button x-on:click.prevent="window.livewire.emit('setReclamationFilters', statusFilter, typeFilter)" type="submit" class="form-btn py-1">Primeni</button>
            <button x-on:click="typeFilter = 0; statusFilter = 0; window.livewire.emit('setReclamationFilters', typeFilter, statusFilter)" type="reset" class="form-btn bg-gray-500 py-1">Resetuj</button>
        </div>
    </form>
</div>
@endsection
