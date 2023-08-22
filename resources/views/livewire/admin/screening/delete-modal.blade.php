<div x-data="{ showModal: @entangle('showModal') }" x-show="showModal" x-trap.noscroll="showModal"
     x-on:keydown.escape.window="showModal = false" x-cloak
     class="flex justify-center items-center h-full fixed inset-0 px-4 py-6 md:py-6 z-50">

    <!-- Modal Background -->
    <div x-show="showModal" class="fixed inset-0 transform backdrop-blur-sm" x-on:click="showModal=false">

    </div>

    <!-- Modal body -->
    @if($screening)
        <div class="bg-neutral-900 fixed flex flex-col gap-3 items-center rounded-lg p-6 z-50 text-white border-red-750">

            <x-close-button class="top-6 right-6"/>

            <p class="text-center text-2xl font-extrabold">Brisanje projekcije</p>
            @if(session('success'))
                <p class="text-center text-xl m-4">{{session('success')}}</p>
            @else
                <p class="text-center text-xl">
                    Da li ste sigurni da želite da obrišete projekciju?
                </p>
                <p class="text-center text-red-700 font-bold">
                     Projekcija ima {{$screening['tickets_count']}} rezervacija i {{$screening['adverts_count']}} reklama
                </p>
                <div class="flex justify-around gap-12 mt-4 px-6 w-full">
                    <button wire:click="deleteScreening()"
                            class="bg-transparent border-2 w-1/2 rounded-2xl border-white text-white hover:bg-white hover:text-gray-950 px-2 py-1 md:px-4 md:py-2 backdrop-blur-sm">
                        Da
                    </button>
                    <button x-on:click="showModal = false"
                            class="bg-transparent border-2 w-1/2 rounded-2xl border-white text-white hover:bg-white hover:text-gray-950 px-2 py-1 md:px-4 md:py-2 backdrop-blur-sm">
                        Ne
                    </button>
                </div>
            @endif
        </div>
    @endif
    <!-- End Modal Body -->
</div>
