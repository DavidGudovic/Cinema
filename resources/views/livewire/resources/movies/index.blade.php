<div class="flex flex-col">
    <!-- Fixed -->
    <!-- Search loading indicator -->
    <div wire:loading class="fixed m-auto right-0 left-0 top-32 h-16 w-16">
        <x-loading-indicator/>
    </div>
    <!-- End loading indicator -->
    <!-- End fixed-->
    <!-- List of Movies -->
    <div class="flex flex-row flex-wrap justify-center gap-10 ">
        @forelse($movie_list as $key => $movie)

        <!-- Movie -->
        <a href="{{route('movie.screenings.index', $movie->id)}}" x-data="{showDetails: false}" x-on:mouseenter="showDetails = true"  x-on:mouseleave="showDetails = false" class="relative h-[28rem] md:h-[26rem]  w-[19rem] md:w-[18rem]">


            <img src="{{URL('/images/movies/'. $movie->image_url)}}" class="brightness-[0.8] w-full h-full">

            <div
                x-show="showDetails"
                x-transition:enter="transition duration-600 ease-in-out"
                x-transition:enter-start="transform translate-y-full opacity-0"
                x-transition:enter-end="transform translate-y-0 opacity-100"
                x-transition:leave="transition duration-1000 ease-in-out"
                x-transition:leave-start="transform translate-y-0 opacity-100"
                x-transition:leave-end="transform translate-y-2 opacity-0"
                x-cloak class="absolute bottom-0 w-full h-full bg-black bg-opacity-60 flex flex-col justify-center items-center">
                <!-- Tech-->
                <div  class="flex justify-center gap-5 absolute inset-x-0 text-center top-5">
                    @foreach ($movie_tags[$movie->id] as $tag)
                    <img class="h-10" src="{{URL('images/tags/' . $tag)}}" alt="{{$tag}}">
                    @endforeach
                </div>
                <!-- End tech-->

                <!-- Details -->
                <h2 class="text-white font-extrabold text-xl text-center">{{ $movie->title }} ({{ $movie->release_year}})</h2>
                <p class="text-white  ">Režiser: {{$movie->director}}</p>
                <p class="text-white  ">Trajanje: {{$movie->duration}} min</p>
                <p class="text-white  ">Žanr: {{$movie->genre->name}}</p>
                <!-- End details -->

                <!-- CTA -->
                <div  class="flex flex-col gap-2 justify-center absolute inset-x-0 text-center bottom-8 text-white ">
                    <p class="hover:text-red-500 underline">Rezervišite kartu <i class="fa-solid fa-ticket underline"></i></p>
                    <p class="text-white text-sm ">Sledeće prikazivanje: {{$movies_next_screening[$movie->id]}}</p>
                </div>
                <!-- End CTA -->
            </div>
        </a>
        <!--End movie -->

        @empty
        <img src="{{URL('images/utility/no_result.png')}}" alt="Nema rezultata pretrage" class="h-[30rem] hidden md:block">
        <p class="text-center text-white font-bold text-2xl md:hidden">Nema rezultata pretrage</p>
        @endforelse
    </div>
    <!-- End of list-->
</div>
