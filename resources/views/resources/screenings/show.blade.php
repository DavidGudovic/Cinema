@extends('templates.app')

@section('content')
<div class="flex flex-col w-full h-full mb-12">


    <!-- Header -->
    <h1 class="text-center my-8 font-extrabold text-3xl">Rezervacija</h1>
    <!-- End Header -->

    <!-- Content -->
    <div class="flex flex-col md:flex-row items-center text-white">

        <!-- SEAT MAP -->
        @livewire('resources.screenings.seat-map', ['screening' => $screening])
        <!-- End SEAT MAP -->

        <!-- Booking form -->
        <div class="md:w-1/2">

        </div>
        <!-- End booking form -->
    </div>
    <!-- End content -->
</div>
@endsection
