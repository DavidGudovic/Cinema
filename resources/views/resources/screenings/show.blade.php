@extends('templates.screening')

@section('screening-content')
    <!-- Header -->
    <h1 class="text-center my-8 mb-12 font-extrabold text-2xl">Sala {{$screening->hall->name }} {{$screening->human_date}} u {{$screening->human_time}}</h1>
    <!-- End Header -->

    <!-- Content -->
    <div  class="flex flex-col md:flex-row items-center text-white">

        <!-- SEAT MAP -->
        @livewire('resources.screenings.seat-map', ['screening' => $screening])
        <!-- End SEAT MAP -->

        <!-- Booking form -->
        <div class="md:w-1/2">

        </div>
        <!-- End booking form -->
    </div>
    <!-- End content -->
@endsection
