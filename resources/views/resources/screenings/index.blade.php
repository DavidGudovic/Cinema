@extends('templates.app')

@section('content')
<!-- Wrapper for movie show -->
<div class="flex flex-col gap-4 px-2 md:px-40 text-white">
    <a href="{{route('movies.index')}}" class="font-bold underline py-6 mt-4 w-36"><< Vidi sve filmove</a>
    <!-- movie -->
    <div class="flex flex-col md:flex-row border-2 border-white px-4 md:pr-0 py-6">
        <!-- Info -->
        <div class="flex flex-col border-b border-white pb-4 px-6 md:px-0 md:flex-row md:pb-0 md:w-1/2 md:min-w-[500px] md:border-b-0 md:border-r ">
            <img src="{{URL('/images/movies/' . $movie->image_url)}}" alt="Cover image of {{$movie->title}} "
            class="h-full max-h-[600px] max-w-[400px] w-full md:h-[400px] md:w-[250px] mb-3 md:mb-0 md:mr-6">
            <div class="flex flex-col justify-between gap-3 md:gap-6">
                <p class="font-bold text-xl">{{$movie->title}}</p>
                <!--Group Author, Isbn, genre -->
                <div class="flex flex-col gap-1">
                    <p>Režiser: {{$movie->director}}</p>
                    <p>Kategorija: {{$movie->genre->name}}</p>
                </div>
                <!-- End group -->
            </div>
        </div>
        <!-- End info-->
        <!-- details-->
        <div class="flex justify-center items-center p-6 md:w-1/2 md:min-w-[500px] overflow-hidden">
            <p class="animate-apear-from-top md:animate-apear-from-left">{{$movie->description}}</p>
        </div>
        <!-- End details-->
    </div>
    <!-- End movie -->

    <!-- Screenings -->
    <div class="mb-20 border-2 border-white pb-4">
        <h1 class="font-extrabold text-3xl text-center my-12 text-white ">Projekcije</h1>
    </div>
    <!-- End Screenings -->
</div>
<!-- End wrapper -->
@endsection
