@extends('templates.administration')

@section('content')
    <div class="flex flex-col md:w-max h-full items-center ">
        <!-- Form -->
        @livewire('admin.movie.edit', ['movie' => $movie, 'genres' => $genres])
        <!-- End form-->
    </div>
@endsection
