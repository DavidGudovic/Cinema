@extends('templates.app')

@section('content')
<!-- background -->
<img class="fixed inset-0 " src="{{URL('/images/utility/advert_background.png')}}"/>
<!-- overlays -->
<div class="fixed inset-0 bg-gray-950 bg-opacity-80"></div>
<!-- End overlays -->
<!-- End background -->

<!-- Advert-->
<div class="flex flex-col justify-center w-full h-full z-20">

    <!-- Header -->
    <div class="flex flex-col justify-center text-center gap-6 mx-12 md:mx-44 my-12 md:my-32 z-10">
        <h1 class="font-extrabold text-3xl md:text-5xl text-center">Zakup reklame</h1>
        <p class="text-sm md:text-base font-bold">Reklamiranje u bioskopu je jedinstvena prilika da vaša poruka stigne do široke publike. Naš bioskop nudi idealno okruženje za promociju vašeg proizvoda ili usluge, gde će vaša reklama biti prikazana na velikom platnu uz vrhunski kvalitet slike i zvuka. Investirajte u svoj uspeh danas – izaberite naš bioskop za svoju sledeću reklamnu kampanju i uverite se u moć oglašavanja na pravom mestu.</p>
        <p class="text-sm"><strong>*Napomena: </strong>Zbog ograničenog prostora za reklamiranje, ne možemo garantovati dostupnost u svakom trenutku. Nakon vašeg upita, naši menadžeri će vas kontaktirati u najkraćem mogućem roku kako bi razgovarali o dostupnim opcijama i pronašli najbolje rešenje za vaše potrebe.</p>
    </div>
    <!-- End header -->

    <!-- Form -->
    <div class="flex flex-col justify-center items-center flex-1 z-20 mb-28">
        <form action="{{route('adverts.store')}}" method="post" class="md:w-[36rem] w-full px-2 flex flex-col gap-2">
            @csrf
            <h2 class="font-extrabold text-xl md:text-3xl text-white text-center mb-6">Molimo ispunite formu</h2>
            <!-- Date -->
            <div class="flex flex-col gap-1 md:gap-0 md:flex-row md:justify-between">
                <!-- Start time -->
                <div class="flex flex-col gap-1 md:w-1/2 relative md:pr-4">
                    <label for="title" class="font-bold">Naslov reklame</label>
                    <input type="text" name="title" id="title" class="p-2 border border-white  @error('title') border-red-500 @else border-white @enderror bg-neutral-950 bg-opacity-80 border-opacity-70 text-white rounded-xl" value="">
                    @error('title')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                </div>
                <!-- End time -->
                <div class="flex flex-col gap-1 md:w-1/2 relative md:pl-4">
                    <label for="company" class="font-bold">Naziv delatnosti</label>
                    <input type="text" name="company" id="company" class="p-2 border border-white  @error('company') border-red-500 @else border-white @enderror  bg-neutral-950 bg-opacity-80 border-opacity-70 text-white rounded-xl" value="">
                    @error('company')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                </div>

                <!-- End time -->
            </div>
            <!-- End date -->
            <!-- Price -->
            <div class="flex">
                <!-- Per hour -->
                <div class="flex flex-col gap-1 w-full">
                    <label for="advert_url" class="font-bold">URL vaše reklame</label>
                    <input type="text" name="advert_url" id="advert_url" class="p-2 w-full border border-white @error('advert_url') border-red-500 @else border-white @enderror bg-neutral-950 bg-opacity-80 border-opacity-70 text-white rounded-xl" placeholder="https://dropbox.com/reklama ili slično">
                    @error('advert_url')
                    <span class="text-red-500 text-sm ">{{$message}}</span>
                    @enderror
                </div>
                <!-- Total -->
            </div>
            <!-- End price -->

            <!-- Details -->
            <div class="flex flex-col relative" x-data="{ count: 0, showDetails: false}" x-init="count = $refs.counted.value.length">
                <label for="text" class="font-bold mb-2">Tekst zahteva <i x-on:mouseenter="showDetails = true" x-on:mouseleave="showDetails = false" class="fa-regular fa-circle-question"></i></label>
                <!-- Details tooltip -->
                <div x-show="showDetails" class="absolute top-6 left-30 border border-white bg-neutral-950 bg-opacity-80 border-opacity-70 text-white p-2 rounded-xl shadow-lg text-justify">
                    <p class="text-sm">Unesite detalje vaše narudžbine za dvominutni reklamni oglas za bioskopsku projekciju. Molimo Vas da navedete specifične informacije o Vašem oglasu, kao što su sadržaj, format, i ciljna publika. Ovi detalji su ključni za precizno kreiranje i postavljanje Vašeg oglasa. Hvala Vam na saradnji!</p>
                </div>
                <!-- End details tooltip -->
                <textarea class="p-2 w-full border  bg-neutral-950 bg-opacity-80 border-opacity-70 text-white rounded-xl resize-none @error('text') border-red-500 @else border-white @enderror" x-ref="counted" x-on:keyup="count = $refs.counted.value.length"
                name="text" maxlength="1000" rows="10" placeholder="Unesite detalje oglašavanja"></textarea>
                <!-- Char count -->
                <div class="text-white text-sm text-center bg-transparent absolute -bottom-6 inset-x-0" :class="count > 900 ? 'text-red-400' : '' ">
                    <span x-html="count" ></span> <span>/</span> <span x-html="$refs.counted.maxLength" ></span>
                </div>
                @error('text')
                <span class="text-red-500 text-sm ">{{$message}}</span>
                @enderror
                <!-- End char count -->
            </div>
            <!-- End text -->
            <!-- Quanity -->
            <div x-data="{showDetailsSlots: false, quantity: 1}" class="flex flex-col gap-1 relative px-12 mb-6 mt-2 md:mt-0">
                <label for="text" class="font-bold">Broj slotova <i x-on:mouseenter="showDetailsSlots = true" x-on:mouseleave="showDetailsSlots = false" class="fa-regular fa-circle-question"></i></label>
                <!-- Details tooltip -->
                <div x-show="showDetailsSlots" class="absolute top-6 left-30 border border-white bg-neutral-950 bg-opacity-80 border-opacity-70 text-white p-2 rounded-xl shadow-lg text-justify">
                    <p class="text-sm">Reklame u našem bioskopu prikazuju se u formatu od {{config('advertising.duration')}} minuta, po {{config('advertising.per_screening')}} pred svako prikazivanje filma.Hvala Vam na saradnji!</p>
                </div>
                <!-- End details tooltip -->
                <input type="text" name="quantity" x-model="quantity" readonly id="advert_url" class="text-center p-2 w-full border border-white bg-neutral-950 bg-opacity-80 border-opacity-70 text-white rounded-xl">
                <i x-on:click="quantity == 1 ? false : quantity--" class="absolute bottom-7 left-1 fa-solid fa-2xl h-5 cursor-pointer text-white opacity-70 hover:text-red-700 fa-chevron-left"></i>
                <i x-on:click="quantity++" class="absolute bottom-7 right-1 fa-solid fa-2xl h-5 cursor-pointer text-white opacity-70 hover:text-red-700 fa-chevron-right"></i>
                <!-- price -->
                <p class="text-center font-bold text-sm md:text-base">Ukupno minuta: <span x-text="quantity * {{config('advertising.duration')}}"></span> Cena: <span x-text="quantity * {{config('advertising.price')}}"></span> RSD</p>
                <!-- End price -->
            </div>
            <!-- End quanity -->

            <!-- Submit -->
            <input type="submit" class="text-center bg-neutral-950 bg-opacity-80 border-opacity-70 border rounded-xl border-white text-white p-2 hover:bg-neutral-200 hover:text-red-700 cursor-pointer" value="Rezerviši">
            <!-- End submit -->
        </form>
    </div>
    <!-- End form -->

</div>
<!-- End advert -->
@endsection
