<div class="flex flex-col">
    <!-- Fixed -->
    <!-- Search loading indicator -->
    <div wire:loading class="fixed m-auto right-0 left-0 top-32 h-16 w-16">
        <img src="{{URL('/images/utility/loading.gif')}}" alt="">
    </div>
    <!-- End loading indicator -->
    <!-- End fixed-->
    <!-- List of Movies -->
    <div class="flex flex-row flex-wrap justify-center gap-10 ">
        @forelse($movie_list as $movie)

        <!-- movie -->
        <div x-data="{showDetails: false}" @mouseenter="showDetails = true"  @mouseleave="showDetails = false" class="relative h-[28rem] md:h-[24rem]  w-[19rem] md:w-[16rem]">


            <img src="{{URL('/images/movies/'. $movie->image_url)}}" class=" w-full h-full">

            <div
            x-show="showDetails"
            x-transition:enter="transition duration-600 ease-in-out"
            x-transition:enter-start="transform translate-y-full opacity-0"
            x-transition:enter-end="transform translate-y-0 opacity-100"
            x-transition:leave="transition duration-1000 ease-in-out"
            x-transition:leave-start="transform translate-y-0 opacity-100"
            x-transition:leave-end="transform translate-y-2 opacity-0"
            x-cloak class="absolute bottom-0 w-full h-full bg-black bg-opacity-70 flex flex-col justify-center items-center">
            <!-- Tech-->
             <div  class="flex gap-2 justify-around absolute inset-x-0 text-center top-5">
                <img class="h-10" src="{{URL('images/tags/4dx.png')}}" alt="">
                <img class="h-10" src="{{URL('images/tags/dolby.png')}}" alt="">
                <img class="h-10" src="{{URL('images/tags/imax.png')}}" alt="">
                <img class="h-10" src="{{URL('images/tags/reald3d.png')}}" alt="">
            </div>
            <!-- End tech-->

            <!-- Details -->
            <h2 class="text-white font-extrabold text-xl text-center">{{ $movie->title }} ({{ $movie->release_year}})</h2>
            <p class="text-white  ">Režiser: {{$movie->director}}</p>
            <p class="text-white  ">Trajanje: {{$movie->duration}} min</p>
            <p class="text-white  ">Žanr: {{$movie->genre->name}}</p>
            <!-- End details -->

            <!-- CTA -->
            <div  class="flex flex-col gap-2 justify-center absolute inset-x-0 text-center bottom-10 text-white ">
                <a href="#" class="underline">Rezervišite kartu <i class="fa-solid fa-ticket underline"></i></a>
                <p class="text-white  ">Početak prikazivanja: 27.08</p>
            </div>
            <!-- End CTA -->
        </div>
    </div>
    <!--End movie -->

    @empty
    <img src="{{URL('images/utility/no_result.png')}}" alt="Nema rezultata pretrage" class="h-[30rem] hidden md:block">
    <p class="text-center text-white font-bold text-2xl md:hidden">Nema rezultata pretrage</p>
    @endforelse
</div>
<!-- End of list-->
</div>
