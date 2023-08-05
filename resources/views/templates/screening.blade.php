@extends('templates.app')


@section('content')
<div class="flex flex-col w-full h-full mb-24">

    <!-- Header -->
    <div class="relative w-full h-full  overflow-hidden md:min-w-[70rem] md:h-[38rem]">
        <img src="{{URL('images/movies/' . $movie->banner_url)}}" alt="{{$movie->title}} banner image" class="w-full hidden md:block relative bottom-20">
        <img src="{{URL('images/movies/' . $movie->image_url)}}" alt="{{$movie->title}} banner image" class="w-full md:hidden relative">
        <!-- overlays -->
        <div class="absolute w-full bottom-0 h-full bg-gradient-to-t from-gray-950 to-20% via-neutral-900"></div>
        <div class="absolute inset-0 bg-gray-950 bg-opacity-60"></div>
        <!-- End overlays -->

        <!-- Back link -->
        @if (preg_match('#^' . url('movie/\d+/screenings/\d+') . '$#', url()->previous()))
        <a href="{{route('home')}}" class="absolute top-4 left-5 md:left-20 text-white text-2xl font-bold">
            <i class="fas fa-arrow-left"></i>
        </a>
        @else

        <a href="{{url()->previous()}}" class="absolute top-4 left-5 md:left-20 text-white text-2xl font-bold">
            <i class="fas fa-arrow-left"></i>
        </a>
        @endif
        <!-- End back link -->

        <!-- Movie info -->
        <div class="flex flex-col gap-4 w-80 md:w-[25rem] absolute bottom-32 left-5 md:left-20 text-white">
            <h1 class="font-extrabold text-7xl">{{$movie->title}}</h1>

            <div class="flex flex-col md:flex-row justify-between pr-4">
                <p class="font-bold">{{$movie->director}}</p>
                <div class="flex gap-2">
                    <p class=" ">{{$movie->duration}} min</p>
                    <span>&middot;</span>
                    <p class=" ">{{$movie->genre->name}}</p>
                    <span>&middot;</span>
                    <p class="">{{$movie->release_year}}</p>
                </div>
            </div>
            <p>{{$movie->description}}</p>
        </div>
        <!-- End movie info -->
    </div>
    <!-- End header -->
    <div class="flex flex-col w-full align-center justify-center md:-mt-12 z-20">
        @yield('screening-content')
    </div>
</div>
@endsection
