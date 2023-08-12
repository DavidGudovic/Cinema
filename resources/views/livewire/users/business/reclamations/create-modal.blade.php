<div x-data="{ showModalSecond: @entangle('showModalSecond') }" x-show="showModalSecond" x-trap.noscroll="showModalSecond" x-on:keydown.escape.window="showModalSecond = false" x-cloak class="flex justify-center items-center h-full fixed inset-0 px-4 py-6 md:py-6 z-50">

    <!-- Modal Background -->
    <div x-show="showModalSecond" class="fixed inset-0 transform backdrop-blur-sm" x-on:click="showModalSecond=false"> </div>
    @if($request)
    <!-- Modal body -->
    <div x-show="showModalSecond" x-cloak class="relative flex flex-col bg-neutral-900 z-20 p-4 rounded-xl">
        <x-close-button class="top-6 right-6"/>
        <!-- Title -->
        @if(session()->has('message'))
        <div class="flex flex-col gap-2 mb-4 mx-4">
            <h2 class="text-2xl font-semibold text-center text-white">Reklamacija</h2>
            <p class="text-center text-white">{{ session('message') }}</p>
        </div>
        @else

        <div class="flex flex-col gap-2 mb-4">
            <h2 class="text-2xl font-semibold text-center text-white">Reklamacija</h2>
            <p class="text-sm text-center text-white">Molimo Vas da popunite formu za reklamaciju</p>
        </div>
        <!-- End title -->

        <!-- Text -->
        <div class="flex flex-col py-2 gap-2 border-t text-white border-white md:w-[35rem]">
            <div class="flex flex-col gap-1" x-data="{ count: 0 }" x-init="count = $refs.counted.value.length">
                <textarea wire:model.defer="text" class="p-2 border border-white bg-neutral-800 rounded resize-none text-white" x-ref="counted" x-on:keyup="count = $refs.counted.value.length" name="text" rows="10" maxlength="1000" placeholder="Unesite tekst vaše reklamacije" wire:model.defer="text"></textarea>
                <!-- Char count -->
                <div class="text-gray-500 text-sm text-center">
                    <span x-html="count":class="count > 900 ? 'text-red-400' : '' " ></span> <span :class="count > 900 ? 'text-red-400' : '' ">/</span> <span :class="count > 900 ? 'text-red-400' : '' " x-html="$refs.counted.maxLength" ></span>
                </div>
                <!-- End char count -->
            </div>
        </div>
        <!-- End text -->

        <!-- Actions -->
        <div class="flex gap-4 justify-center w-full">
            <button wire:click="store" class="text-center bg-neutral-800 bg-opacity-80 border-opacity-70 border rounded-xl border-white text-white p-2 hover:bg-neutral-200 hover:text-red-700 cursor-pointer w-full">Pošalji</button>
            <button x-on:click="showModalSecond = false" class="text-center bg-neutral-800 bg-opacity-80 border-opacity-70 border rounded-xl border-white text-white p-2 hover:bg-neutral-200 hover:text-red-700 cursor-pointer w-full">Odustani</button>
        </div>
        <!-- End actions -->
        @endif
    </div>
    @endif

    <!-- End Modal Body -->
</div>







