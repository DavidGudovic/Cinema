@extends('templates.administration')

@section('content')
    <!-- Background -->
    <img class="fixed inset-0 " src="{{URL('/images/utility/advert_background.webp')}}" alt="advert background image"/>
    <!-- Overlays -->
    <div class="fixed inset-0 bg-gray-950 bg-opacity-80"></div>
    <!-- End overlays -->
    <!-- End background -->

    <!-- Advert-->
    <div class="flex flex-col justify-center items-center gap-12 w-full h-full z-20">
        <!-- Header -->
        <div class="flex flex-col justify-center text-center gap-6 mt-12">
            <h1 class="font-extrabold text-3xl md:text-3xl text-center">{{$action == 'ACCEPT' ? 'Prihvatanje' : 'Odbijanje'}}
                reklame</h1>
        </div>
        <!-- End header -->

        <!-- Request border-->
        <div
            class="border-b-2 mb-3 md:mb-0 md:border-b-0 border-white relative p-4 pr-3 md:w-[40rem]">
            <!-- Request link -->
            <a target="_blank" class="absolute top-5 right-5" href="{{ $advert->advert_url }}">
                link <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i>
            </a>
            <!-- End request link -->
            <!-- Request info -->
            <div class="flex flex-col justify-between h-full min-w-full px-2 md:px-4">
                <div class="flex flex-col gap-3 ">
                    <p class="font-bold text-xl">
                        Zahtev: Rentiranje sale
                    </p>
                    <p class="">Zahtev
                        kreiran: {{Carbon\Carbon::parse($advert->businessRequest->created_at)->format('H:i m/d/Y')}} </p>
                    <p class="flex border-b-2 border-white">Status:
                        <span class="text-yellow-500 ml-2">Na čekanju</span>
                    </p>

                    <p class="font-bold text-xl">Detalji:</p>
                    <div>
                        <!-- Request details -->
                        <div class="flex flex-col w-full flex-1 gap-4">

                            <!-- Details -->
                            <div class="flex flex-col md:flex-row md:justify-between border-b border-white ">
                                <!-- Item -->
                                <div class="flex flex-row gap-2 ">
                                    <span>Naslov reklame:</span>
                                    <span class="">{{$advert->title}}</span>
                                </div>
                                <!-- End item -->
                                <!-- Item -->
                                <div class="flex flex-row gap-2">
                                    <span>Delatnost:</span>
                                    <span class="">{{$advert->company}}</span>
                                </div>
                                <!-- End info-->
                                <!-- End item -->
                                <!-- Item -->
                                <div class="flex flex-row gap-2">
                                    <span>Ukupno reklama:</span>
                                    <span class="">{{$advert->quantity}}</span>
                                </div>
                            </div>
                            <!-- End Details -->
                            <!-- Text -->
                            <div class="flex flex-col md:flex-row md:justify-between">
                                    <span class="">{{$advert->businessRequest->text}}</span>
                            </div>
                            <!-- End text -->
                        </div>
                        <!-- End request details -->
                    </div>

                    <!-- Request footer -->
                    <div class="flex flex-col  border-t border-white">
                        <!-- Footer info -->
                        <div class="flex flex-row justify-between">
                            <p class="font-bold">Cena: </p>
                            <p class="font-bold">{{$advert->businessRequest->price}} RSD</p>
                        </div>
                        <!-- End footer info-->
                    </div>
                    <!-- End Request footer -->
                </div>
                <!-- End Request info-->
            </div>
            <!-- End request border-->
        </div>

        <!-- Form -->
        <div class="flex flex-col justify-center items-center w-full flex-1 z-20 mb-28">
            <form action="{{route('adverts.update', $advert)}}" method="post"
                  class="md:w-[36rem] w-full px-2 flex flex-col gap-2">
                @csrf
                @method('PATCH')
                <input type="hidden" name="action" value="{{$action}}">
                <h2 class="font-extrabold text-xl md:text-3xl text-white text-center mb-6">Molimo ispunite
                    formu</h2>
                <!-- Response -->
                <div class="flex flex-col relative" x-data="{ count: 0}"
                     x-init="count = $refs.counted.value.length">
                    <label for="text" class="font-bold mb-2">Odgovor na zahtev</label>

                    <textarea
                        class="p-2 w-full border  bg-neutral-950 bg-opacity-80 border-opacity-70 text-white rounded-xl resize-none @error('response') border-red-500 @else border-white @enderror"
                        x-ref="counted" x-on:keyup="count = $refs.counted.value.length"
                        name="response" maxlength="1000" rows="10"
                        placeholder="Unesite odgovor na zahtev oglašavanja"></textarea>
                    <!-- Char count -->
                    <div class="text-white text-sm text-center bg-transparent absolute -bottom-6 inset-x-0"
                         :class="count > 900 ? 'text-red-400' : '' ">
                        <span x-html="count"></span> <span>/</span> <span
                            x-html="$refs.counted.maxLength"></span>
                    </div>
                    @error('response')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                    <!-- End char count -->
                </div>
                <!-- End Response -->
                <!-- Submit -->
                <div class="flex flex-row gap-4 justify-between mt-6">
                    <button type="submit" class="p-2 bg-neutral-950 text-center w-full rounded-xl border border-white hover:text-red-700 cursor-pointer">
                        {{$action == 'ACCEPT' ? 'Prihvati' : 'Odbij'}}
                    </button>
                    <a href="{{route('adverts.index')}}" class="p-2 bg-neutral-950 text-center w-full rounded-xl border border-white">
                        Odustani
                    </a>
                </div>
            </form>
        </div>
        <!-- End form -->
    </div>
    <!-- End advert -->
@endsection
