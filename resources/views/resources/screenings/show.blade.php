@extends('templates.screening')

@section('screening-content')
<!-- Header -->
<h1 class="text-center -mt-6 md:my-14 mb-14 font-extrabold text-2xl">Sala {{$screening->hall->name }} {{$screening->human_date}} u {{$screening->human_time}}h</h1>
<!-- End Header -->

<!-- Content -->
<div  class="flex flex-col md:flex-row gap-12 mb-12 items-center text-white">

    <!-- SEAT MAP -->
    @livewire('resources.screenings.seat-map', ['screening' => $screening])
    <!-- End SEAT MAP -->

    <!-- Booking form -->
    @livewire('resources.screenings.ticket.create', ['screening' => $screening])
    <!-- End booking form -->
</div>
<!-- End content -->
@endsection
