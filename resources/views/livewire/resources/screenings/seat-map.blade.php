<div class="flex flex-col gap-12 justify-center md:w-1/2 h-min">
    <!-- Screen -->
    <div class="flex justify-center md:mx-14">
        <div class=" w-full h-12 border-t-4 border-white rounded-t-2xl">
            <p class="text-center text-white">Platno</p>
        </div>
    </div>
    <!-- End Screen -->

    <!-- Seats -->
    <div x-ref="target" class="flex gap-12 md:gap-24 justify-center">
        <!-- Left seats -->
        <div class="flex flex-row gap-2 md:gap-4">
            @for ($row = 1; $row <= ($screening->hall->rows / 2); $row++)
            <div class="flex flex-col gap-2 md:gap-4">
                @for ($column = 1; $column <= $screening->hall->columns; $column++)
                @if(in_array([$row, $column], $takenSeats))
                <div class="w-6 h-6 text-[0.7rem] pt-[0.3rem] border border-opacity-80 border-red-700 opacity-50 rounded-t-xl align-center justify-center flex">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                @else
                <div  :class="{ 'bg-green-300': {{ $this->isSelected($row, $column) ? 'true' : 'false' }} }" wire:click="toggleSeat({{ $row }}, {{ $column }})" class="w-6 h-6 text-[0.7rem] pt-[0.3rem] border border-opacity-80 border-white rounded-t-xl cursor-pointer hover:bg-white">
                    <span class=" w-full align-center justify-center flex select-none"> {{ chr(64 + $column) }}{{ $row }}</span>
                </div>
                @endif
                @endfor
            </div>
            @endfor
        </div>
        <!-- End left seats -->
        <!-- Right seats -->
        <div class="flex flex-row gap-2 md:gap-4">
            @for ($row = ($screening->hall->rows / 2) + 1; $row <= $screening->hall->rows; $row++)
            <div class="flex flex-col gap-2 md:gap-4">
                @for ($column = 1; $column <= $screening->hall->columns; $column++)
                @if(in_array([$row, $column], $takenSeats))
                <div class="w-6 h-6 text-[0.7rem] pt-[0.3rem] border border-opacity-80 border-red-700 opacity-50 rounded-t-xl align-center justify-center flex">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                @else
                <div  :class="{ 'bg-green-300': {{ $this->isSelected($row, $column) ? 'true' : 'false' }} }" wire:click="toggleSeat({{ $row }}, {{ $column }})" class="w-6 h-6 text-[0.7rem] pt-[0.3rem] border border-opacity-80 border-white rounded-t-xl cursor-pointer hover:bg-white">
                    <span class=" w-full align-center justify-center flex "> {{ chr(64 + $column) }}{{ $row }}</span>
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
