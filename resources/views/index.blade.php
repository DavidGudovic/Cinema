@extends('templates/app')

@section('content')
<div class="flex flex-col gap-12 items-center w-full h-full">
    <!-- Movie showcase -->
    <div class=" relative w-full h-52 md:h-[32rem] overflow-hidden">
        <img src="{{URL('images/movies/klovn.png')}}" alt="Movie Poster" class="w-full h-auto">

        <!-- Buttons -->
        <button  class="absolute inset-y-0 left-10 px-2  h-full text-gray-950 opacity-60 hover:text-white hover:opacity-100 hover:cursor-pointer  z-10">
            <i class="fa-solid fa-7x fa-chevron-left"></i>
        </button>
        <button class="absolute inset-y-0 right-10 px-2  h-full text-gray-950 opacity-60 hover:text-white hover:opacity-100 hover:cursor-pointer  z-10">
            <i class="fa-solid fa-7x fa-chevron-right"></i>
        </button>
        <div class="absolute bottom-0 w-full p-4 flex gap-4 justify-center ">
            <button class="h-3 w-3 rounded-full bg-white hover:cursor-pointer z-10 ring-2 ring-gray-950"></button>
            <button class="h-3 w-3 rounded-full bg-transparent hover:bg-white hover:cursor-pointer z-10 ring-2 ring-gray-950"></button>
            <button class="h-3 w-3 rounded-full bg-transparent hover:bg-white hover:cursor-pointer z-10 ring-2 ring-gray-950"></button>
            <button class="h-3 w-3 rounded-full bg-transparent hover:bg-white hover:cursor-pointer z-10 ring-2 ring-gray-950"></button>
            <button class="h-3 w-3 rounded-full bg-transparent hover:bg-white hover:cursor-pointer z-10 ring-2 ring-gray-950"></button>
            <button class="h-3 w-3 rounded-full bg-transparent hover:bg-white hover:cursor-pointer z-10 ring-2 ring-gray-950"></button>
        </div>
        <!-- END Buttons -->

        <div class="absolute inset-0 bg-gray-950 bg-opacity-40 md:bg-opacity-60 flex flex-col items-center justify-center w-full h-full p-6">
            <!-- Movie details -->
            <h1 class="text-4xl text-white font-bold">Movie Showcase section</h1>
        </div>
    </div>
    <!-- END Movie showcase -->

    <!-- Tech showcase -->
    <div class="flex justify-around w-full md:px-12">
        @foreach($tags as $tag)
        <img class="h-16 md:h-24" src="{{URL('images/tags/' . $tag->image_url)}}" alt="{{$tag->name}}">
        @endforeach
    </div>
    <!-- END Tech showcase -->

    <h1 class="text-4xl text-white font-bold mb-6">Projekcije</h1>

    <!-- Genre showcase -->
    <div class="flex flex-col justify-center mx-10 md:mx-20 md:flex-row ">
        <!-- Fiction -->
        <div class="flex flex-col-reverse mx-2 md:flex-col ">
            <!-- Fiction imgs-->
            <div class="flex flex-row flex-wrap gap-16 justify-center">
                @foreach($fictionGenres as $genre)
                <!-- Image -->
                <a href="#" class="over ">
                    <img class="w-56 md:w-48 hover:scale-110" width="200px" src="{{URL('images/genres/' . $genre->image_url)}}" alt="">
                    <p class="relative bottom-10 left-6 font-extrabold text-white text-xl md:text-base h-0 z-10"  style="text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">{{$genre->name}}</p>
                </a>
                <!-- End Image -->
                @endforeach
            </div>
            <!--End fiction imgs-->
            <h2 class="text-3xl text-center mb-4 mt-2 md:mt-6 text-white">Fikcija</h2>
        </div>
        <!--End Fiction-->

        <!-- nonFiction -->
        <div class="flex flex-col-reverse mx-2 md:flex-col ">
            <!-- nonFiction images-->
            <div class="flex flex-row flex-wrap gap-16 justify-center">
                @foreach($nonFictionGenres as $genre)
                <!-- Image -->
                <a href="#" class="overflow-hidden">
                    <img class="w-56 md:w-48 hover:scale-110" src="{{URL('images/genres/' . $genre->image_url)}}" alt="">
                    <p class="relative bottom-10 left-6 font-extrabold text-white text-xl md:text-base h-0 z-10" style="text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;" >{{$genre->name}}</p>
                </a>
                <!-- End Image -->
                @endforeach
            </div>
            <!--End nonFiction images-->
            <h2 class="text-3xl text-center mb-4 mt-2 md:mt-6 text-white">Dokumentarci</h2>
        </div>
        <!--End nonFiction-->
    </div>
    <!-- END Genre Showcase -->

    <h1 class="text-4xl text-white font-bold mb-6">Oglašavanje i rentiranje</h1>

    <!-- Business showcase -->
    <div class="w-full mb-12">
        <div class="flex p-4 rounded-2xl bg-business-pattern bg-no-repeat bg-cover mx-4 md:mx-40 h-[32rem]">
            <!-- Image left side wrapper-->
            <div class="w-1/2 flex flex-col gap-4 p-4 items-center justify-around">
                <!-- Text wrapper -->
                <div x-data="{ count1: 0, count2: 0, count3: 0, target: 100000, isIntersecting: false }"
                x-intersect.full="let intervalId = setInterval(() => { if(count1 < target) {count1 += 1000;count2 += 100, count3 += 10 }else clearInterval(intervalId); }, 10.0)"
                class="flex flex-col gap-11">
                <p class="text-3xl font-bold text-white ">Zašto izabrati Cinemaniju?</p>
                <!-- Counter -->
                <p class="text-2xl font-bold text-white">
                    <span
                    x-text="count1"class="text-yellow-500"></span><span class="text-yellow-500">+</span>
                    Pregleda reklama
                </p>
                <p class="text-2xl font-bold text-white">
                    <span
                    x-text="count2" class="text-yellow-500"></span><span class="text-yellow-500">+</span>
                    Privatnih projekcija
                </p>
                <p class="text-2xl font-bold text-white">
                    <span
                    x-text="count3" class="text-yellow-500"></span><span class="text-yellow-500">+</span>
                    Zadovoljnih mušterija
                </p>
                <!-- END Counter -->
                <!-- Call to action -->
                <a class="border-2 border-white text-center text-white rounded-xl px-3 py-2 font-medium w-full hover:border-red-600 hover:text-red-600" href="#">Započni saradnju</a>
                <!-- END Call to action -->
            </div>
            <!-- END Text wrapper -->
        </div>
        <div class="w-1/2"><!-- Empty for graphic --></div>
    </div>
    <!-- END Image left side wrapper-->
</div>
<!-- END Business showcase -->
</div>
@endsection
