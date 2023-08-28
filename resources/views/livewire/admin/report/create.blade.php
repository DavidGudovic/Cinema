<div class="flex flex-col-reverse md:flex-row gap-6 justify-center items-center md:w-[72rem] h-full">
    <!-- Left side -->
    <div class="flex flex-col gap-6 w-full h-full">
        <div class="flex justify-between w-full h-max bg-dark-blue rounded-2xl p-4">
            <!-- Tickets chart -->
            <div class="h-full w-full border border-white">
                @livewire('admin.charts.reservations-chart', ['period' => $selected_period, 'hall_id' => $selected_hall ])
            </div>
            <!-- End Tickets chart -->
        </div>

        <!-- Form -->
        <div class="flex flex-col gap-6 w-full h-full">
            <!-- Options -->
            <div class="flex items-center justify-around w-full h-28 bg-dark-blue rounded-2xl p-4">
                <!-- Duration -->
                <div class="flex gap-4 justify-center items-center w-full">
                    <i class="fa-solid fa-hourglass opacity-50"></i>
                    <div class="flex flex-col gap-1">
                        <label for="type" class="opacity-50">Tip izveštaja</label>
                        <select wire:model="selected_period" wire:change="syncState"
                                class="rounded-xl p-3 w-full bg-gray-950 bg-opacity-10 border border-white cursor-pointer"
                                name="a" id="type">
                            @foreach($periods as $period)
                                <option value="{{$period}}">{{$period->toSrLatinString()}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- End Duration -->
                <!-- Hall -->
                <div class="flex gap-4 justify-center items-center w-full mr-2">
                    <i class="fa-solid fa-people-roof opacity-50"></i>
                    <div class="flex flex-col gap-1">
                        <label for="hall" class="opacity-50">Sala</label>
                        <select wire:model="selected_hall" wire:change="syncState"
                                class="rounded-xl p-3 w-full bg-gray-950 bg-opacity-10 border border-white cursor-pointer"
                                name="a" id="hall">
                            @foreach($halls as $hall)
                                <option value="{{$hall->id}}">{{$hall->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- End Hall -->
            </div>
            <!-- End options -->
            <!-- Inputs -->
            <form wire:submit.prevent="submit"
                  class="relative flex flex-col justify-center gap-4 w-full h-full bg-dark-blue rounded-2xl p-4">
                <!-- Loading -->
                <div wire:loading class="absolute top-5 right-5 ">
                    <i class="fa-solid fa-gear animate-spin"></i>
                </div>
                <!-- End loading-->

                <h2 class="font-extrabold text-xl text-center w-full">Izveštaj</h2>
                <!-- Text -->
                @if($already_exists)
                    <div class="flex flex-col gap-4 justify-center items-center w-full">
                        <div class="flex flex-col gap-1">
                            @if(session()->has('success'))
                                <label for="type" class="opacity-50 text-green-500">Izveštaj uspešno kreiran</label>
                            @else
                                <label for="type" class="opacity-50">Izveštaj za izabrani period postoji</label>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="flex flex-col relative" x-data="{ count: 0}"
                         x-init="count = $refs.counted.value.length">
                        <label for="text" class="font-bold mb-2">Tekst izveštaja</label>
                        <textarea wire:model="text"
                                  class="p-2 w-full border  bg-gray-950 bg-opacity-80 border-opacity-70 text-white rounded-xl resize-none @error('text') border-red-500 @else border-white @enderror"
                                  x-ref="counted" x-on:keyup="count = $refs.counted.value.length"
                                  name="text" maxlength="1000" rows="12"
                                  placeholder="Unesite detalje izveštaja"></textarea>
                        <!-- Char count -->
                        <div class="text-white text-sm text-center bg-transparent absolute -bottom-6 inset-x-0"
                             :class="count > 900 ? 'text-red-400' : '' ">
                            <span x-html="count"></span> <span>/</span> <span x-html="$refs.counted.maxLength"></span>
                        </div>
                        @error('text')
                        <span class="absolute top-0 right-4 text-red-500 text-sm ">{{$message}}</span>
                        @enderror
                        <!-- End char count -->
                    </div>
                    <!-- End text -->
                    <!-- Submit -->
                    <button type="submit" wire:loading.attr="disabled" wire:loading.class="bg-opacity-30 hover:text-white hover:border-white cursor-wait"
                            class="text-center w-full bg-gray-950 opacity-80 border rounded-2xl border-white text-white p-2 mt-4 hover:text-red-700 hover:border-red-700">
                        Generiši
                        izveštaj
                    </button>
                @endif
            </form>
            <!-- End inputs -->
        </div>
        <!-- End form-->
    </div>
    <!-- End left side -->

    <!-- Request charts -->
    <div wire:ignore class="flex flex-col gap-6 w-full h-full bg-dark-blue rounded-2xl p-4">
        <div class="w-full h-full border border-white">
            @livewire('admin.charts.requests-chart', ['period' => $selected_period, 'hall_id' => $selected_hall ])
        </div>
        <div class="w-full h-full border border-white">
            @livewire('admin.charts.bookings-chart', ['period' => $selected_period, 'hall_id' => $selected_hall ])
        </div>
        <div class="w-full h-full border border-white">
            @livewire('admin.charts.adverts-chart', ['period' => $selected_period, 'hall_id' => $selected_hall ])
        </div>
    </div>
    <!-- End request charts -->
</div>
