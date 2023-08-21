@extends('templates.administration')

@section('content')
    @livewire('admin.booking.index' , ['halls' => $halls])
@endsection

