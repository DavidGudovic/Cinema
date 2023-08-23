@extends('templates.administration')

@section('content')
    <!-- Multistep form -->
    @livewire('admin.screening.create', [
	 'movie' => $movie,
	 'halls' => $halls,
	 'tags' => $tags,
 ])
    <!-- End multistep from -->
@endsection
