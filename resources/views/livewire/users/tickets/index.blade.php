<div class="w-full flex flex-col items-center p-2 pt-4 bg-gray-950 bg-opacity-80">
    <!-- Tickets -->
    <div class="flex flex-1 flex-col md:flex-row justify-center w-full">
        @forelse($tickets as $ticket)
        <!-- Ticket border-->
        <div class="@if(!$loop->last)border-b-2 mb-3 md:mb-0 md:border-b-0 md:border-r-2 border-white @endif relative p-4 pr-3 flex-1 min-w-0 md:min-w-[26rem]">
            <!-- cancel button -->
            <button wire:click="cancelTicket({{$ticket->id}})" class="absolute top-3 right-3 hover:text-red-700 text-white">
                 <i class="fa-solid fa-x"></i>
            </button>
            <!-- Ticket info-->
            <div class="flex flex-col justify-between h-full min-w-full px-2 md:px-4">
                <div class="flex flex-col gap-3 ">
                    <p class="font-bold text-xl">Film: {{$ticket->screening->movie->title}}</p>
                    <p class="">Vreme: {{$ticket->screening->start_time->format('d/m H:i')}}</p>
                    <div class="flex justify-between border-b-2 border-white">
                        <p>Sala: {{$ticket->screening->hall_id}}</p>
                        <p>Sedišta:
                            @for($i = 0; $i < $ticket->seat_number; $i++)
                            {{ chr(65 + $ticket->first_seat_row - 1) }}{{ $ticket->first_seat_column + $i }}@if($i != $ticket->seat_number - 1), @endif
                            @endfor
                        </p>
                    </div>
                    <p class="font-bold text-xl">Račun:</p>
                    <!-- Ticket items-->
                    <div class="flex flex-col w-full gap-4 overflow-y-auto md: ">

                        <!-- Item -->
                        <div class="flex flex-row justify-between border-b border-white gap-2">
                            <!-- Left info-->
                            <div class="flex flex-col gap-3">
                                <span>Biskopska karta:</span>
                            </div>
                            <!-- Right info-->
                            <div class="flex flex-row justify-between md:w-16">
                                <span class="text-sm">500</span>
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
                                <span class="text-sm">@if($ticket->screening->movie->duration > 120) 200 @else 0 @endif</span>
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
                                <span class="text-sm">500</span>
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
                                <span class="text-sm">0</span>
                                <span class="text-sm">RSD</span>
                            </div>
                            <!-- End info-->
                        </div>
                        <!-- End item -->

                    </div>
                    <!-- End Ticket items -->
                </div>
                <!-- Ticket footer -->
                <div class="flex flex-col  border-t border-white">
                    <!-- Footer info -->
                    <div class="flex flex-row justify-between">
                        <p class="font-bold">Ukupno: </p>
                        <p class="font-bold">{{$ticket->price}} RSD</p>
                    </div>
                    <!-- End footer info-->
                </div>
                <!-- End Ticket footer -->
            </div>
            <!-- End Ticket info-->
        </div>
        <!-- End Ticket border-->
        @empty
        <div class="flex flex-col w-full h-full justify-center">
           <p class="text-4xl font-extrabold text-center">Nemate rezervisanih karata.</p>
        </div>
        @endforelse
    </div>
    <!-- End Tickets-->

    <!-- Paginator -->
    <span class="text-center w-max">{{$tickets->links()}}</span>
</div>
