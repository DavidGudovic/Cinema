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
        <div class="flex flex-col gap-4 w-80 md:w-[25rem] absolute bottom-32 left-5 md:left-20 text-white">
            <h1 class="font-extrabold text-7xl">{{$hall->name}}</h1>

            <div class="flex flex-col md:flex-row justify-between pr-4">
                <p class="font-bold">Kapacitet: {{$hall->rows * $hall->columns}}</p>
                <div class="flex gap-2">
                    <p class=" ">{{$hall->price_per_hour}} RSD po satu</p>
                    <span>&middot;</span>
                    <p class=" ">Broj sale: {{$hall->id}}</p>
                </div>
            </div>
            <p>{{$hall->description}}</p>
        </div>
        <!-- End hall info -->
    </div>
    <!-- End header -->
    <div class="flex flex-col w-full items-center justify-center md:-mt-12 z-20">
        <h1 class="text-center my-4 font-extrabold text-3xl">Detalji rentiranja</h1>
        <!-- Bill -->
           <div class="flex flex-col justify-between h-full min-w-full px-2 md:px-4">
                <div class="flex flex-col gap-3 ">
                    <p class="font-bold text-xl">Film: </p>
                    <p class="">Vreme: </p>
                    <div class="flex justify-between border-b-2 border-white">
                        <p class="w-24">Sala: </p>
                        <p>Sedišta:

                        </p>
                    </div>
                    <p class="font-bold text-xl">Račun:</p>

                    <!-- Booking items-->
                    <div class="flex flex-col w-full gap-4 overflow-y-auto">

                        <!-- Item -->
                        <div class="flex flex-row justify-between border-b border-white gap-2">
                            <!-- Left info-->
                            <div class="flex flex-col gap-3">
                                <span>Cena po satu:</span>
                            </div>
                            <!-- Right info-->
                            <div class="flex flex-row justify-between md:w-16">
                                <span class="text-sm">{{$hall->price_per_hour}}</span>
                                <span class="text-sm">RSD</span>
                            </div>
                            <!-- End info-->
                        </div>
                        <!-- End item -->

                        <!-- Item -->
                        <div class="flex flex-row justify-between border-b border-white gap-2">
                            <!-- Left info-->
                            <div class="flex flex-col gap-3">
                                <span>Naknada dužine filma:</span>
                            </div>
                            <!-- Right info-->
                            <div class="flex flex-row justify-between md:w-16">
                                <span class="text-sm">{{$hall->title}}</span>
                                <span class="text-sm">RSD</span>
                            </div>
                            <!-- End info-->
                        </div>
                        <!-- End item -->

                        <!-- Item -->
                        <div class="flex flex-row justify-between border-b border-white gap-2">
                            <!-- Left info-->
                            <div class="flex flex-col gap-3">
                                <span>Naknada tehnologije:</span>
                            </div>
                            <!-- Right info-->
                            <div class="flex flex-row justify-between md:w-16">
                                <span class="text-sm">1200</span>
                                <span class="text-sm">RSD</span>
                            </div>
                            <!-- End info-->
                        </div>
                        <!-- End item -->

                        <!-- Item -->
                        <div class="flex flex-row justify-between border-b border-white gap-2">
                            <!-- Left info-->
                            <div class="flex flex-col gap-3">
                                <span>Popust:</span>
                            </div>
                            <!-- Right info-->
                            <div class="flex flex-row justify-between md:w-16">
                                <span class="text-sm">13000</span>
                                <span class="text-sm">RSD</span>
                            </div>
                            <!-- End info-->
                        </div>
                        <!-- End item -->
                        <!-- Item -->
                        <div class="flex flex-row justify-between border-b border-white gap-2">
                            <!-- Left info-->
                            <div class="flex flex-col gap-3">
                                <span>Broj sedišta:</span>
                            </div>
                            <!-- Right info-->
                            <div class="flex flex-row justify-between md:w-16">
                                <span class="text-sm"> x </span>
                                <span class="text-sm">25000</span>
                            </div>
                            <!-- End info-->
                        </div>
                        <!-- End item -->
                    </div>
                    <!-- End Booking items -->
                </div>
                <!-- Booking footer -->
                <div class="flex flex-col  border-t border-white">
                    <!-- Footer info -->
                    <div class="flex flex-row justify-between">
                        <p class="font-bold">Ukupno: </p>
                        <p class="font-bold">32000</p>
                    </div>
                    <!-- End footer info-->
                </div>
                <!-- End Booking footer -->
            </div>
            <!-- End Booking info-->
        </div>
        <!-- End bill-->
        <form action="user.halls.booking.store" method="POST" class="flex flex-col gap-2 ">
            @csrf
        </form>
    </div>
</div>
@endsection
