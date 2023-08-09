@extends('templates.app')


@section('content')
<div class="flex flex-col w-full h-full mb-24">

    <!-- Header -->
    <div class="relative w-full h-full  overflow-hidden md:min-w-[70rem] md:h-[38rem]">
        <img src="{{URL('images/halls/' . $hall->image_url)}}" alt="{{$hall->name}} banner image" class="w-full hidden md:block relative bottom-20">
        <img src="{{URL('images/halls/' . $hall->image_url)}}" alt="{{$hall->name}} banner image" class="w-full md:hidden relative">
        <!-- overlays -->
        <div class="absolute w-full bottom-0 h-full bg-gradient-to-t from-gray-950 to-20% via-neutral-900"></div>
        <div class="absolute inset-0 bg-gray-950 bg-opacity-60"></div>
        <!-- End overlays -->

        <!-- Back link -->
        <a href="{{url()->previous()}}" class="absolute top-4 left-5 md:left-20 text-white text-2xl font-bold">
            <i class="fas fa-arrow-left"></i>
        </a>
        <!-- End back link -->

        <!-- hall info -->
        <div class="flex flex-col gap-4 w-80 md:w-[25rem] absolute bottom-5 md:bottom-32 left-5 md:left-20 text-white">
            <h1 class="font-extrabold text-4xl md:text-7xl">{{$hall->name}}</h1>
            <div class="flex flex-row justify-between md:pr-4">
                <p class="font-bold text-sm md:text-base">Kapacitet: {{$hall->rows * $hall->columns}}</p>
                <span>&middot;</span>
                <p class="text-sm md:text-base ">{{$hall->price_per_hour}} RSD po satu</p>
                <span>&middot;</span>
                <p class="text-sm md:text-base ">Broj sale: {{$hall->id}}</p>
            </div>
            <p class="text-justify text-sm md:text-base">{{$hall->description}}</p>
        </div>
        <!-- End hall info -->
    </div>
    <!-- End header -->
    <div class="flex flex-col w-full items-center justify-center mb-12 md:md-0 md:-mt-12 z-20">
        <h1 class="text-center my-4 font-extrabold text-3xl">Detalji rentiranja</h1>
        <!-- Form -->
        <form action="{{route('user.halls.booking.store', [auth()->user(), $hall])}}" method="POST" class="flex flex-col gap-2 w-full px-4 md:px-0 md:w-[30rem]">
            <input type="hidden" name="date" value="{{$date}}">
            @csrf
            <!-- Date -->
            <div class="flex flex-col gap-2 md:gap-0 md:flex-row md:justify-between">
                <!-- Start time -->
                <div class="flex flex-col gap-2 md:w-1/2 relative md:pr-4">
                    <label for="start_time" class="font-bold">Početak</label>
                    <input type="text" name="start_time" id="start_time" class="p-2 border border-white bg-neutral-900 text-white rounded-xl" value="{{Carbon\Carbon::parse($start_time)->format('H:i')}}" readonly>
                    <span class="absolute right-3 md:right-7 top-[2.6rem] text-white opacity-80"> {{Carbon\Carbon::parse($date)->format('m/d/Y')}} </span>
                </div>
                <!-- End time -->
                <div class="flex flex-col gap-2 md:w-1/2 relative md:pl-4">
                    <label for="end_time" class="font-bold">Kraj</label>
                    <input type="text" name="end_time" id="end_time" class="p-2 border border-white bg-neutral-900 text-white rounded-xl" value="{{Carbon\Carbon::parse($end_time)->format('H:i')}}" readonly>
                    <span class="absolute right-3 top-[2.6rem] text-white opacity-80"> {{Carbon\Carbon::parse($date)->format('m/d/Y')}} </span>
                </div>
                <!-- End time -->
            </div>
            <!-- End date -->
            <!-- Price -->
            <div class="flex flex-col gap-2 md:gap-0 md:flex-row md:justify-between">
                <!-- Per hour -->
                <div class="flex flex-col gap-2 md:w-1/2 md:pr-4">
                    <label for="price_per_hour" class="font-bold">Cena po satu</label>
                    <div class="relative">
                        <input type="text" name="price_per_hour" id="price_per_hour" class="p-2 w-full border border-white bg-neutral-900 text-white rounded-xl" value="{{$hall->price_per_hour}}" readonly>
                        <span class="absolute right-3 top-[0.6rem] text-white opacity-80"> RSD </span>
                    </div>
                </div>
                <!-- Total -->
                <div class="flex flex-col gap-2 md:w-1/2 md:pl-4">
                    <label for="price" class="font-bold">Ukupno</label>
                    <div class="relative">
                        <input type="text" name="price" id="price" class="p-2 w-full border border-white bg-neutral-900 text-white rounded-xl" value="{{$hall->price_per_hour * $duration}}" readonly>
                        <span class="absolute right-3 top-[0.6rem] text-white opacity-80"> RSD </span>
                    </div>
                </div>
                <!-- End total -->
            </div>
            <!-- End price -->

            <!-- Details -->
            <div class="flex flex-col relative" x-data="{ count: 0, showDetails: false}" x-init="count = $refs.counted.value.length">
                <label for="text" class="font-bold mb-2">Tekst zahteva <i x-on:mouseenter="showDetails = true" x-on:mouseleave="showDetails = false" class="fa-regular fa-circle-question"></i></label>
                <!-- Details tooltip -->
                <div x-show="showDetails" class="absolute top-6 left-30 border border-white bg-neutral-900 text-white p-2 rounded-xl shadow-lg text-justify">
                    <p class="text-sm">Unesite detalje vašeg zahteva, koliko gostiju očekujete, da li Vam je potreban film iz našeg repertoara ili donosite svoj medij, kako planirate da koristite salu i ostale podatke. Ovi detalji pomažu u brzini obrade Vašeg zahteva od strane naših zaposlenih, Hvala Vam!</p>
                </div>
                <!-- End details tooltip -->
                <textarea class="p-2 w-full border  bg-neutral-900 text-white rounded-xl resize-none @error('text') border-red-500 @else border-white @enderror" x-ref="counted" x-on:keyup="count = $refs.counted.value.length"
                name="text" maxlength="1000" rows="10" placeholder="Unesite detalje rentiranja"></textarea>
                <!-- Char count -->
                <div class="text-white text-sm text-center" :class="count > 900 ? 'text-red-400' : '' ">
                    <span x-html="count" ></span> <span>/</span> <span x-html="$refs.counted.maxLength" ></span>
                </div>
                @error('text')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                @enderror
                <!-- End char count -->
            </div>
            <!-- End text -->
            <!-- Submit -->
            <input type="submit" class="text-center bg-neutral-900 border rounded-xl border-white text-white p-2 hover:bg-neutral-200 hover:text-red-700 cursor-pointer" value="Rezerviši">
            <!-- End submit -->
        </form>
    </div>
</div>
@endsection
