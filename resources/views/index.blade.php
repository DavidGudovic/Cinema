@extends('templates/app')

@section('content')
<div class="flex flex-col gap-12 items-center w-full h-full overflow-x-hidden">
    <!-- Movie showcase -->
    <div class="relative w-full h-52 md:h-[38rem] overflow-hidden md:min-w-[70rem]" x-data="carousel()"x-init="startCarousel; setMovies({{$movies}})" x-on:unload.window="clearInterval(interval)">

        <template x-for="(movie, index) in movies" :key="index">
            <div x-show="current == index"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="absolute inset-0">

            <!-- Movie poster -->
            <img :src="'{{URL('images/movies')}}' + '/' + movie.banner_url" alt="Movie Poster" class="w-full object-cover">
            <!-- End movie poster -->

            <!-- Movie info -->
            <div class="absolute inset-0 bg-gray-950 bg-opacity-60 flex flex-col items-center justify-center w-full h-full">
                <div class="flex flex-col gap-2 md:gap-4 align-center justify-center text-center text-white w-80 md:w-[30rem] h-48 md:h-96 ">
                    <p class="text-2xl font-extrabold md:text-7xl" x-text="movie.title"></p>
                    <p class="text-sm md:text-xl line-clamp-3 md:line-clamp-none text-center" x-text="movie.description"></p>

                    <div class="flex flex-row justify-center gap-4 md:gap-6 md:mt-4 text-sm md:text-base mx-6">
                        <a :href="'https://youtube.com/'" target="_blank" rel="noopener noreferrer" class="bg-transparent border w-1/2 rounded-2xl border-white text-white hover:bg-gray-950 hover:text-yellow-500 px-2 py-1 md:px-4 md:py-2 backdrop-blur-sm">
                            <i class="fa-brands fa-youtube"></i> <span class="hidden md:inline-flex">Vidi</span> Trailer
                        </a>
                        @clientorguest
                        <a :href="routes['movies.screening.index'].replace('_ID_', movie.id)" class="bg-transparent border w-1/2 rounded-2xl border-white text-white hover:bg-gray-950 hover:text-yellow-500 px-2 py-1 md:px-4 md:py-2 backdrop-blur-sm">
                            <i class="fa-solid fa-ticket"></i>
                            <span class="hidden md:inline-flex">Rezerviši</span> Kart<span class="hidden md:inline-flex">u</span><span class="md:hidden inline-flex">a</span>
                        </a>
                        @endclientorguest

                    </div>
                </div>
            </div>
            <!-- End movie info -->
        </template>

        <!-- Buttons -->
        <button  class="absolute inset-y-0 left-5 md:left-10 px-2  h-full text-white opacity-40 hover:opacity-100 hover:cursor-pointer  z-10" x-on:click="prev(), manualMove()">
            <i class="fa-solid text-lg  md:text-7xl fa-chevron-left"></i>
        </button>
        <button class="absolute inset-y-0 right-5 md:right-10 px-2  h-full text-white opacity-40 hover:opacity-100 hover:cursor-pointer  z-10" x-on:click="next(), manualMove()">
            <i class="fa-solid text-lg  md:text-7xl fa-chevron-right"></i>
        </button>

        <!-- Navigation dots -->
        <div class="absolute bottom-0 w-full p-4 flex gap-4 justify-center space-x-2">
            <template x-for="(movie, index) in movies" :key="index">
                <button class="h-2 md:h-3 w-2 md:w-3 rounded-full bg-white  hover:cursor-pointer hover:bg-opacity-100 z-10 "
                :class="{ 'bg-opacity-100': current == index, 'bg-opacity-30': current != index }"
                @click="current = index, manualMove()"></button>
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

    <h2 class="text-4xl text-white font-bold mb-6" aria-selected="none">Repertoar žanrova</h2>
    <!-- Genre Paralax MD only -->
    <div class="h-96 mb-4 hidden md:flex">
        <div id="image-track" data-mouse-down-at="0" data-prev-percentage="0" class="image-paralax-wrap">
            @foreach ($genres as $genre)
            <img class="image cursor-grab w-[19rem] h-[26rem]" src="{{URL('images/genres/' . $genre->image_url)}}" id="image" draggable="false" />
            @endforeach
        </div>
    </div>
    <!-- CTA -->
    @role('CLIENT')
    <div class="hidden md:flex justify-center items-center">
        <a href="{{route('movies.index')}}" class="bg-transparent border rounded-xl border-white text-white hover:bg-gray-950 hover:text-yellow-500 px-2 py-1 md:px-3 md:py-2 ">
            Pogledajte ceo repertoar
        </a>
    </div>
    @endrole
     @guest
    <div class="hidden md:flex justify-center items-center">
        <a href="{{route('movies.index')}}" class="bg-transparent border rounded-xl border-white text-white hover:bg-gray-950 hover:text-yellow-500 px-2 py-1 md:px-3 md:py-2 ">
            Pogledajte ceo repertoar
        </a>
    </div>
    @endguest
    <!-- End CTA -->
    <!-- End genre paralax -->

    <!-- Genre showcase mobile-->
     <div class="flex flex-col md:hidden gap-6 mx-4">
            @foreach ($genres as $genre)
            <a class="overflow-hidden relative cursor-pointer" href="{{route('movies.index', $genre)}}">
                 <img src="{{URL('images/genres/' . $genre->image_url)}}" class="object-cover"/>
            </a>
            @endforeach
    </div>
    <!--end Genre mobile showcase -->

    <h2 class="text-4xl text-white font-bold md:mb-6">Oglašavanje <span class="hidden md:inline-block">i rentiranje</span></h2>

    <!-- Business showcase -->
    <div class="w-full mb-12">
        <div class="flex p-4 rounded-2xl bg-business-pattern bg-no-repeat bg-cover mx-4 md:mx-40 h-[32rem]">
            <!-- Image left side wrapper-->
            <div class="md:w-1/2 flex flex-col gap-12 md:gap-4 p-2 md:p-4 items-center justify-around">
                <!-- Text wrapper -->
                <div x-data="{ count1: 0, count2: 0, count3: 0, target: 100000, isIntersecting: false }" x-intersect.full="let intervalId = setInterval(() => { if(count1 < target) {count1 += 1000;count2 += 100, count3 += 10 }else clearInterval(intervalId); }, 10.0)" class="flex flex-col gap-11">
                    <p class="text-2xl md:text-3xl font-bold text-white ">Zašto izabrati Cinemaniju?</p>
                    <!-- Counter -->
                    <p class="text-xl md:text-2xl font-bold text-white">
                        <span x-text="count1"class="text-yellow-500"></span><span class="text-yellow-500">+</span>
                        Pregleda reklama
                    </p>
                    <p class="text-xl md:text-2xl font-bold text-white">
                        <span x-text="count2" class="text-yellow-500"></span><span class="text-yellow-500">+</span>
                        Privatnih projekcija
                    </p>
                    <p class="text-xl md:text-2xl font-bold text-white">
                        <span x-text="count3" class="text-yellow-500"></span><span class="text-yellow-500">+</span>
                        Zadovoljnih mušterija
                    </p>
                    <!-- END Counter -->
                    <!-- Call to action -->
                    <a class="border border-white text-center text-white rounded-xl px-3 py-2 font-medium w-full hover:border-red-600 hover:text-red-600" href="{{route('adverts.create')}}">Započni saradnju</a>
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

@section('scripts')
@vite('resources/js/tech_paralax.js')
<script>
    window.routes = {
        'movies.screening.index': "{{ route('movie.screenings.index', ['movie' => '_ID_']) }}"
    };
</script>
@endsection

@section('head-scripts')
@vite('resources/js/carousel.js')
@endsection
