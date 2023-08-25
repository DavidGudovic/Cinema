<form action="{{route('movies.store')}}" enctype="multipart/form-data" method="POST"
      class="flex flex-col gap-4 md:w-[70rem] h-full">
    @csrf
    <!-- Banner -->
    <div x-data="">
        <input type="file" wire:model="banner" name="banner" class="hidden" x-ref="bannerInput">

        <div class="relative w-full flex items-center justify-center cursor-pointer hover:text-red-700"
             x-on:click="$refs.bannerInput.click()">
            @if ($banner)
                <img src="{{$banner->temporaryUrl()}}" alt="new movie banner preview"
                     class="w-full md:h-[30rem] object-cover">
                <div
                    class="absolute w-full h-full flex bg-gray-950 bg-opacity-60 items-center justify-center cursor-pointer">
                </div>
            @else
                <img src="{{URL('images/utility/new_movie_banner.webp')}}" alt="new movie banner image"
                     class="w-full h-[30rem] object-cover">
                    <p class="absolute text-center">Dodaj banner</p>

            @endif
        </div>

        @error('banner')
        <span class="text-red-500 text-sm ">{{$message}}</span>
        @enderror
    </div>
    <!-- End banner -->


    <div class="w-full flex flex-col md:flex-row items-center gap-4">
        <!-- Form -->
        <div class="flex flex-col gap-3 w-full h-full px-2 md:px-0">
            <!-- Group 1 -->
            <div class="flex flex-col gap-1 md:gap-0 md:flex-row md:justify-between">
                <!-- Title -->
                <div class="flex flex-col gap-1 md:w-1/2 relative md:pr-4">
                    <label for="title" class="font-bold">Naslov</label>
                    <input type="text" name="title" id="title"
                           class="p-2 border @error('title') border-red-500 @else border-white @enderror bg-dark-blue border-opacity-70 text-white rounded-xl"
                           placeholder="Unesite naslov filma"
                           value='{{old('title')}}'>
                    @error('title')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                </div>
                <!--End title-->
                <!-- Director -->
                <div class="flex flex-col gap-1 md:w-1/2 relative md:pl-4">
                    <label for="director" class="font-bold">Režiser</label>
                    <input type="text" name="director" id="director"
                           class="p-2 border @error('director') border-red-500 @else border-white @enderror  bg-dark-blue border-opacity-70 text-white rounded-xl"
                           placeholder="Unesite ime režisera"
                           value='{{old('director')}}'>
                    @error('director')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                </div>
                <!-- End director -->
            </div>
            <!-- End group 1 -->

            <!-- Group 2 -->
            <div class="flex flex-col gap-1 md:gap-0 md:flex-row md:justify-between">
                <!-- Genre -->
                <div class="flex flex-col gap-1 md:w-1/2 relative md:pr-4">
                    <label for="genre" class="font-bold">Žanr</label>
                    <select name="genre" id="genre"
                            class="p-2 border @error('genre') border-red-500 @else border-white @enderror bg-dark-blue border-opacity-70 text-white rounded-xl">
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>

                    @error('genre')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                </div>
                <!--End genre-->
                <!-- Duration -->
                <div class="flex flex-col gap-1 md:w-1/2 relative md:pl-4">
                    <label for="duration" class="font-bold">Trajanje</label>
                    <input type="number" min="0" max="500" name="duration" id="duration"
                           placeholder="Trajanje u minutima"
                           class="p-2 border @error('duration') border-red-500 @else border-white @enderror  bg-dark-blue border-opacity-70 text-white rounded-xl"
                           value='{{old('number')}}'>
                    @error('duration')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                </div>
                <!-- End duration -->
            </div>
            <!-- End group 2 -->

            <!-- Group 3 -->
            <div class="flex flex-col gap-1 md:gap-0 md:flex-row md:justify-between">
                <!-- Trailer URL -->
                <div class="flex flex-col gap-1 md:w-1/2 relative md:pr-4">
                    <label for="trailer_url" class="font-bold">URL Trejlera</label>
                    <input type="text" name="trailer_url" id="trailer_url"
                           class="p-2 border @error('trailer_url') border-red-500 @else border-white @enderror bg-dark-blue border-opacity-70 text-white rounded-xl"
                           placeholder="Unesite URL trejlera"
                           value='{{old('trailer_url')}}'>
                    @error('trailer_url')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                </div>
                <!-- End Trailer URL -->

                <!-- Release date -->
                <div class="flex flex-col gap-1 md:w-1/2 relative md:pl-4">
                    <label for="release_date" class="font-bold">Datum Izlaska</label>
                    <input type="date" name="release_date" id="release_date"
                           class="p-2 border @error('release_date') border-red-500 @else border-white @enderror bg-dark-blue border-opacity-70  text-opacity-70 text-white rounded-xl"
                           max="{{now()->format('Y-m-d')}}"
                           value='{{old('release_date')}}'>
                    @error('release_date')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                </div>
                <!-- End Release date -->
            </div>
            <!-- End group 3 -->


            <!-- Description -->
            <div class="flex flex-col relative" x-data="{ count: 0}" x-init="count = $refs.counted.value.length">
                <label for="description" class="font-bold mb-2">Opis filma</label>
                <textarea
                    class="p-2 w-full border bg-dark-blue border-opacity-70 text-white rounded-xl resize-none @error('description') border-red-500 @else border-white @enderror"
                    x-ref="counted" x-on:keyup="count = $refs.counted.value.length"
                    name="description" id="description" maxlength="1000" rows="10"
                    placeholder="Unesite sinopsis filma"></textarea>
                <!-- Char count -->
                <div class="text-gray-500 text-sm text-center">
                    <span x-html="count" :class="count > 900 ? 'text-red-400' : '' "></span>
                    <span :class="count > 900 ? 'text-red-400' : '' ">/</span>
                    <span :class="count > 900 ? 'text-red-400' : '' " x-html="$refs.counted.maxLength"></span>
                </div>
                @error('description')
                <span class="text-red-500 text-sm ">{{$message}}</span>
                @enderror
                <!-- End char count -->
            </div>
            <!-- End description -->
        </div>
        <!-- End form -->

        <!-- Side image -->
        <div x-data="" x-on:click="$refs.posterInput.click()"
             class="relative md:w-1/2 flex flex-col items-center justify-center cursor-pointer hover:text-red-700">
            <input type="file" wire:model="poster" name="poster" class="hidden" x-ref="posterInput">
            @if ($poster)
                <img src="{{$poster->temporaryUrl()}}" alt="new movie poster preview" class="h-full">
                <div
                    class="absolute w-full h-full flex bg-gray-950 bg-opacity-60 items-center justify-center cursor-pointer">
                </div>
            @else
                <img src="{{URL('images/utility/new_movie.webp')}}" alt="new movie image" class="h-full">
                <p class="absolute text-center">Dodaj poster</p>
            @endif
            @error('poster')
            <span class="text-red-500 text-sm ">{{$message}}</span>
            @enderror
        </div>
        <!-- End side image -->
    </div>


    <!-- Buttons -->
    <div class="flex gap-4 justify-center w-full">
        <input type="submit" value="Sačuvaj"
               class="text-center bg-dark-blue border rounded-xl border-white text-white p-2 hover:bg-neutral-200 hover:text-red-700 cursor-pointer w-full"/>
        <a href="{{route('management.movies.index')}}"
           class="text-center bg-dark-blue border rounded-xl border-white text-white p-2 hover:bg-neutral-200 hover:text-red-700 cursor-pointer w-full">
            Odustani
        </a>
    </div>
    <!-- End buttons -->
</form>
