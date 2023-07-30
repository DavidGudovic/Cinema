@extends('templates/app')

@section('content')
<div class="flex flex-col gap-12 items-center w-full h-full">
    <!-- Movie showcase -->
    <div class="relative w-full h-52 md:h-[38rem] overflow-hidden"
    x-data="carousel()"
    x-init="startCarousel; setMovies({{$movies}})"
    x-on:unload.window="clearInterval(interval)">

    <template x-for="(movie, index) in movies" :key="index">
        <div x-show="current == index"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="absolute inset-0">
        <img :src="'{{URL('images/movies')}}' + '/' + movie.banner_url" alt="Movie Poster" class="w-full object-center">

        <!-- Movie info -->
        <div class="absolute inset-0 bg-gray-950 bg-opacity-50 flex flex-col items-center justify-center w-full h-full p-6">
            <div class="flex flex-col gap-2 md:gap-12 align-center justify-center text-center text-white w-full px-12 md:w-1/3">
                <p class="text-base md:text-4xl font-extrabold" x-text="movie.title"></p>
                <p class="text-sm md:text-xl line-clamp-3 md:line-clamp-none" x-text="movie.description"></p>

                <div class="flex flex-row justify-around gap-4 md:mt-4 text-sm md:text-base">
                    <a href="#" class="bg-transparent border-2 rounded-2xl border-white text-white hover:bg-gray-950 hover:text-yellow-500 px-2 py-1 md:px-4 md:py-2">
                        <i class="fa-solid fa-ticket"></i> Karta
                    </a>
                    <a :href="'https://youtube.com/'" target="_blank" rel="noopener noreferrer" class="bg-transparent border-2 rounded-2xl border-white text-white hover:bg-gray-950 hover:text-yellow-500 px-2 py-1 md:px-4 md:py-2">
                        <i class="fa-brands fa-youtube"></i> Trailer
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Buttons -->
<button  class="absolute inset-y-0 left-5 md:left-10 px-2  h-full text-white opacity-40 hover:text-yellow-500 hover:opacity-100 hover:cursor-pointer  z-10"
x-on:click="prev(), manualMove()">
<i class="fa-solid text-lg  md:text-7xl fa-chevron-left"></i>
</button>
<button class="absolute inset-y-0 right-5 md:right-10 px-2  h-full text-white opacity-40 hover:text-yellow-500 hover:opacity-100 hover:cursor-pointer  z-10"
x-on:click="next(), manualMove()">
<i class="fa-solid text-lg  md:text-7xl fa-chevron-right"></i>
</button>

<!-- Navigation dots -->
<div class="absolute bottom-0 w-full p-4 flex gap-4 justify-center space-x-2">
    <template x-for="(movie, index) in movies" :key="index">
        <button class="h-2 md:h-3 w-2 md:w-3 ring-2 rounded-full bg-transparent hover:bg-white hover:cursor-pointer z-10  ring-gray-950"
        :class="{ 'bg-white': current == index }"
        @click="current = index, manualMove()">
    </button>
</template>
</div>
<!-- END Navigation dots -->
</div>

<!-- END Movie showcase -->

<!-- Tech showcase -->
<div class="flex justify-around w-full md:px-12">
    @foreach($tags as $tag)
    <img class="h-16 md:h-24" src="{{URL('images/tags/' . $tag->image_url)}}" alt="{{$tag->name}}">
    @endforeach
</div>
<!-- END Tech showcase -->

<h2 class="text-4xl text-white font-bold mb-6">Projekcije</h2>

<!-- Genre showcase -->
<div class="flex flex-col justify-center mx-10 md:mx-20 md:flex-row ">
    <!-- Fiction -->
    <div class="flex flex-col-reverse mx-2 md:flex-col ">
        <!-- Fiction imgs-->
        <div class="flex flex-row flex-wrap gap-16 justify-center">
            @foreach($fictionGenres as $genre)
            <!-- Image -->
            <a href="#" class="overflow-hidden">
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

<h2 class="text-4xl text-white font-bold mb-6">Oglašavanje <span class="hidden md:inline-block">i rentiranje</span></h2>

<!-- Business showcase -->
<div class="w-full mb-12">
    <div class="flex p-4 rounded-2xl bg-business-pattern bg-no-repeat bg-cover mx-4 md:mx-40 h-[32rem]">
        <!-- Image left side wrapper-->
        <div class="md:w-1/2 flex flex-col gap-4 p-2 md:p-4 items-center justify-around">
            <!-- Text wrapper -->
            <div x-data="{ count1: 0, count2: 0, count3: 0, target: 100000, isIntersecting: false }"
            x-intersect.full="let intervalId = setInterval(() => { if(count1 < target) {count1 += 1000;count2 += 100, count3 += 10 }else clearInterval(intervalId); }, 10.0)"
            class="flex flex-col gap-11">
            <p class="text-2xl md:text-3xl font-bold text-white ">Zašto izabrati Cinemaniju?</p>
            <!-- Counter -->
            <p class="text-xl md:text-2xl font-bold text-white">
                <span
                x-text="count1"class="text-yellow-500"></span><span class="text-yellow-500">+</span>
                Pregleda reklama
            </p>
            <p class="text-xl md:text-2xl font-bold text-white">
                <span
                x-text="count2" class="text-yellow-500"></span><span class="text-yellow-500">+</span>
                Privatnih projekcija
            </p>
            <p class="text-xl md:text-2xl font-bold text-white">
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
    <div class="md:w-1/2"><!-- Empty for graphic --></div>
</div>
<!-- END Image left side wrapper-->
</div>
<!-- END Business showcase -->
</div>
@endsection

