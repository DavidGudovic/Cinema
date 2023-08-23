<div class="flex flex-col md:flex-row gap-2 justify-center items-center w-full h-full mr-4 md:mr-0">
    <!-- Calendar -->
    <div class="flex flex-col w-[18rem] md:w-[25rem] h-[18rem] md:h-[23rem] rounded-xl bg-gray-950 bg-opacity-70 mt-32 md:mt-0">
        <div class="flex justify-between items-center border-b border-white px-6 py-4">
            <i wire:click="displayMonth('current')"
               class="{{$displayed_date->month == $current_date->format('m') ? 'opacity-30' : 'cursor-pointer hover:text-red-700'}} fa-solid fa-xl fa-angle-left"></i>
            <p class="text-xl">{{ ucfirst($displayed_date->locale('sr_Latn')->isoFormat('MMMM')) }}</p>
            <i wire:click="displayMonth('next')"
               class="{{$displayed_date->month == $current_date->copy()->addMonth()->format('m') ? 'opacity-30' : 'cursor-pointer hover:text-red-700'}} fa-solid fa-xl fa-angle-right"></i>
        </div>
        <table class="table-fixed mt-2 px-2">
            <thead class="h-10">
            <tr>
                <th class="text-center">Pon</th>
                <th class="text-center">Uto</th>
                <th class="text-center">Sre</th>
                <th class="text-center">Čet</th>
                <th class="text-center">Pet</th>
                <th class="text-center">Sub</th>
                <th class="text-center">Ned</th>
            </tr>
            </thead>
            <tbody>
            @foreach(array_chunk($dates, 7) as $week)
                <tr>
                    @foreach($week as $date)
                        <td class="text-center">
                            <div wire:click="{{$date['isInvalid'] ? '' : 'toggleDate(\''.$date['day'].'\')' }}"
                                 class="w-8 h-8 md:w-12 md:h-12 rounded-full inline-flex justify-center items-center {{ $date['isInvalid'] ? 'text-gray-400 opacity-40' : 'cursor-pointer hover:bg-gray-600' }} {{ $this->isSelected($date['fullDate']) ? 'bg-red-500' : '' }}">
                                {{ $date['day'] }}
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- End Calendar -->
    <!-- Time pick -->
    <div class="flex-1">

    </div>
    <!-- End time pick -->
</div>
