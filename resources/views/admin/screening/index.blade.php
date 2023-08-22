@extends('templates.administration')

@section('content')
    @livewire('admin.screening.index', [
    'movies' => $movies,
    'halls' => $halls,
])
@endsection
