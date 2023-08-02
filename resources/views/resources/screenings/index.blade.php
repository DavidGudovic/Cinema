@extends('templates.app')

@section('content')
    <div class="flex flex-col gap-6 w-full h-full">

        <!-- Header -->
        <div class="relative w-full h-full  overflow-hidden md:min-w-[70rem] md:h-[38rem]">
            <img src="{{URL('images/movies/' . $movie->banner_url)}}" alt="{{$movie->title}} banner image" class="w-full hidden md:block relative bottom-20">
             <img src="{{URL('images/movies/' . $movie->image_url)}}" alt="{{$movie->title}} banner image" class="w-full md:hidden relative">
            <!-- overlays -->
            <div class="absolute w-full bottom-0 h-full bg-gradient-to-t from-gray-950 to-20% via-gray-950"></div>
            <div class="absolute w-full bottom-0  h-full bg-gradient-to-r from-gray-950 to-20% via-gray-950 to-60% opacity-60"></div>
            <div class="absolute inset-0 bg-gray-950 bg-opacity-40"></div>
            <!-- End overlays -->

            <!-- Back link -->
            <a href="{{route('movies.index')}}" class="absolute top-4 left-4 text-white text-2xl font-bold">
                <i class="fas fa-arrow-left"></i>
            </a>
            <!-- End back link -->

            <!-- Movie info -->
            <div class="flex flex-col gap-4 w-[25rem] absolute bottom-32 left-20 text-white">
                <h1 class="font-extrabold text-7xl">{{$movie->title}}</h1>

                <div class="flex justify-between pr-4">
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
        <!-- Screenings -->
        <div class="flex flex-col gap-12 w-full align-center justify-center md:-mt-12 z-20">
            <div class="flex justify-center align-center w-full">
               <img src="{{URL('images/utility/popcorn.png')}}" alt="popcorn" class="h-12 w-12 text-center">
            </div>

            <h2 class="text-3xl font-bold text-center">Projekcije</h2>
            <!-- Screening List -->
            <div class="md:min-w-[50rem]">

            </div>
            <!-- End Screening List -->
        </div>
        <!-- End screenings -->
    </div>
@endsection
