<div class="flex flex-col gap-12 justify-center md:w-1/2">
    <!-- Screen -->
    <div class="flex justify-center md:mx-14">
        <div class="w-full h-12 border-t-4 border-white rounded-t-2xl">
            <p class="text-center text-white">Platno</p>
        </div>
    </div>
    <!-- End Screen -->

    <!-- Seats -->
    <div x-data="{ selectedSeats: @entangle('selectedSeats') }" class="flex gap-12 md:gap-24 justify-center">
        <!-- Left seats -->
        <div class="flex flex-col gap-2 md:gap-4">
            @for ($i = 0; $i < $screening->hall->columns; $i++)
            <div class="flex flex-row gap-2 md:gap-4">
                @for ($j = 1; $j <= ($screening->hall->rows)/2; $j++)
                @if(in_array([$i, $j], $takenSeats))
                <div class="w-6 h-6 text-[0.7rem] pt-[0.3rem] border-2 border-white opacity-50 rounded-t-xl align-center justify-center flex">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                @else
                <div  :class="{ 'bg-green-300': {{ $this->isSelected($i, $j) ? 'true' : 'false' }} }" wire:click="toggleSeat({{ $i }}, {{ $j }})" class="w-6 h-6 text-[0.7rem] pt-[0.3rem] border-2 border-white rounded-t-xl cursor-pointer hover:bg-white">
                    <span class=" w-full align-center justify-center flex "> {{ chr(65 + $i) }}{{ $j }}</span>
                </div>
                @endif
                @endfor
            </div>
            @endfor
        </div>
        <!-- End left seats -->
        <!-- Right seats -->
        <div class="flex flex-col gap-2 md:gap-4">
            @for ($i = 0; $i < $screening->hall->columns; $i++)
            <div  class="flex flex-row gap-2 md:gap-4">
                @for ($j = ($screening->hall->rows)/2 + 1; $j <= $screening->hall->rows; $j++)
                @if(in_array([$i, $j], $takenSeats))
                <div class="w-6 h-6 text-[0.7rem] pt-[0.3rem] border-2 border-white opacity-50 rounded-t-xl align-center justify-center flex">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                @else
                <div :class="{ 'bg-green-300': {{ $this->isSelected($i, $j) ? 'true' : 'false' }} }" wire:click="toggleSeat({{ $i }}, {{ $j }})" class="w-6 h-6 text-[0.7rem] pt-[0.3rem] border-2 border-white rounded-t-xl cursor-pointer hover:bg-white">
                    <span class=" w-full align-center justify-center flex "> {{ chr(65 + $i) }}{{ $j }}</span>
                </div>
                @endif
                @endfor
            </div>
            @endfor
        </div>
        <!-- End Right seats-->
    </div>
    <!-- End seats -->
</div>
