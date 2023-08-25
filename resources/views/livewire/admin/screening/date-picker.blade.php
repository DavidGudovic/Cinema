<div class="flex flex-col gap-12 w-full h-full mr-4 md:mr-0 justify-center items-center">
    <!-- Datetime pick -->
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Calendar -->
        <div
            class="flex flex-col w-[18rem] md:w-[25rem] h-[18rem] md:h-[23rem] rounded-xl bg-dark-blue mt-32 md:mt-0 @error('selected_dates') border border-red-700 @enderror">
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
                                <div wire:click="{{$date['isInvalid'] ? '' : 'toggleDate(\''.$date['fullDate'].'\')' }}"
                                     class="w-8 h-8 md:w-12 md:h-12 rounded-full inline-flex justify-center items-center {{ $date['isInvalid'] ? 'text-gray-400 opacity-40' : 'cursor-pointer hover:bg-gray-600' }} {{ $this->isSelected($date['fullDate']) ? 'bg-blue-950' : '' }}">
                                    {{ $date['day'] }}
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
            @error('selected_dates')
            <p class="text-red-700 text-sm text-center mt-4">{{$message}}</p>
            @enderror
        </div>
        <!-- End Calendar -->
        <!-- Time pick -->
        <div class="h-full flex flex-col justify-center items-center">
            <div class="flex flex-col h-full justify-center rounded-2xl @error('selected_times') border border-red-700 @enderror">
                <p class="font-bold text-lg text-center">
                    Slobodni termini
                </p>
                <p class="text-center mb-4">Trajanje: {{intdiv($movie_duration, 60)}}h {{$movie_duration % 60}}min</p>
                <div
                    class="flex flex-row md:flex-col w-72 md:w-40 md:h-[18.7rem] gap-2 px-6 pb-6 md:pb-0 overflow-x-auto md:overflow-x-hidden  md:overflow-y-auto">
                    @foreach($times as $time)
                        <p wire:click="toggleTime('{{$time}}')"
                           class="border border-white rounded-2xl py-2 px-8 cursor-pointer {{ $this->isSelected($time) ? 'bg-blue-950' : 'hover:bg-gray-600 cursor-pointer' }}">{{$time}}</p>
                    @endforeach
                </div>
            </div>
            @error('selected_times')
            <p class="text-red-700 text-sm text-center mt-1">{{$message}}</p>
            @enderror
        </div>
        <!-- End time pick -->
    </div>
    <!-- End datetime pick -->
    <!-- Submit -->
    <div class="relative w-full flex justify-center">
        <div wire:click="pickDates" wire:loading.attr="disabled" wire:loading.class="text-gray-500 border-gray-500" class="text-center p-2 border border-white w-96 rounded-2xl hover:text-red-700 cursor-pointer">
            Napravi projekcije
        </div>

        <div wire:loading>
            <div class="absolute inset-0 -bottom-40 flex justify-center items-center">
                <div class="fa-solid fa-xl fa-gear animate-spin"></div>
            </div>
        </div>
    </div>
    <!-- End submit -->
</div>
