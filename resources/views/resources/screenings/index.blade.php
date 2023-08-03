@extends('templates.app')

@section('content')
<div class="flex flex-col w-full h-full">

    <!-- Header -->
    <div class="relative w-full h-full  overflow-hidden md:min-w-[70rem] md:h-[38rem]">
        <img src="{{URL('images/movies/' . $movie->banner_url)}}" alt="{{$movie->title}} banner image" class="w-full hidden md:block relative bottom-20">
        <img src="{{URL('images/movies/' . $movie->image_url)}}" alt="{{$movie->title}} banner image" class="w-full md:hidden relative">
        <!-- overlays -->
        <div class="absolute w-full bottom-0 h-full bg-gradient-to-t from-gray-950 to-20% via-gray-950"></div>
        <div class="absolute inset-0 bg-gray-950 bg-opacity-40"></div>
        <!-- End overlays -->

        <!-- Back link -->
        <a href="{{route('movies.index')}}" class="absolute top-4 left-4 text-white text-2xl font-bold">
            <i class="fas fa-arrow-left"></i>
        </a>
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

    <!-- Screenings -->
    <div class="flex flex-col w-full align-center justify-center md:-mt-12 z-20">
        <div class="flex justify-center align-center w-full">
            <img src="{{URL('images/utility/popcorn.png')}}" alt="popcorn" class="h-12 w-12 text-center">
        </div>

        <h2 class="text-3xl font-bold text-center">Projekcije</h2>
        <!-- Screening List -->
        <div class="flex flex-col divide-y divide-white mx-auto mt-6">
            @foreach($screenings_map as $date => $screenings)
            <!-- Date -> Screening, Screening -->
            <div class="flex p-4 gap-6">
                <!-- Date -->
                <div class="flex flex-col w-20 md:w-36">
                    <p class="text-lg md:text-2xl font-bold">{{Str::ucfirst(strftime('%A', strtotime($date)))}}</p>
                    <p class="md:text-lg">{{Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                </div>
                <!-- End date-->
                <!-- Screening -->
                <div class="flex flex-wrap md:gap-4">
                    @foreach($screenings as $screening)
                    <a href="#" class="relative flex flex-col  w-20 p-4 pt-6 justify-center">
                        <img src="{{URL('images/tags/' . $screening->tags[0]->image_url)}}" alt="screening tag" class="absolute bottom-12 w-12">
                        <p class="font-bold">{{Carbon\Carbon::parse($screening->start_time)->format('H:i')}}</p>
                        <p class="">Sala {{$screening->hall_id}}</p>
                    </a>
                    <a href="#" class="relative flex flex-col  w-20 p-4 pt-6 justify-center">
                        <img src="{{URL('images/tags/' . $screening->tags[0]->image_url)}}" alt="screening tag" class="absolute bottom-12 w-12">
                        <p class="font-bold">{{Carbon\Carbon::parse($screening->start_time)->format('H:i')}}</p>
                        <p class="">Sala {{$screening->hall_id}}</p>
                    </a>
                    <a href="#" class="relative flex flex-col  w-20 p-4 pt-6 justify-center">
                        <img src="{{URL('images/tags/' . $screening->tags[0]->image_url)}}" alt="screening tag" class="absolute bottom-12 w-12">
                        <p class="font-bold">{{Carbon\Carbon::parse($screening->start_time)->format('H:i')}}</p>
                        <p class="">Sala {{$screening->hall_id}}</p>
                    </a>
                    <!-- End Screening-->
                    @endforeach
                </div>
            </div>
            @endforeach
            <!-- End Date -> Screening, Screening -->
        </div>
        <!-- End Screening List -->
    </div>
    <!-- End Screenings-->
</div>
<!-- End screenings -->
</div>
@endsection
