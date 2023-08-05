<div class="relative w-full flex flex-col items-center p-2 pt-4 bg-gray-950 bg-opacity-80">
    <!-- Loading -->
    <div wire:loading class="absolute w-10 h-10 top-2 md:bottom-2 left-2 md:top-0 ">
        <x-loading-indicator/>
    </div>
    <!-- End loading -->
    <!-- Tickets -->
    <div class="flex flex-1 flex-col md:flex-row justify-center w-full">
        @forelse($tickets as $ticket)
        <!-- Ticket border-->
        <div class="@if(!$loop->last)border-b-2 mb-3 md:mb-0 md:border-b-0 md:border-r-2 border-white @endif relative p-4 pr-3 flex-1 min-w-0 md:min-w-[26rem]">
            <!-- delete button -->
            @if($ticket->screening->start_time->subHours(config('restrictions.hours_before_reservation_is_locked'))->isAfter(now()) && !$ticket->deleted_at)
            <button  x-data='{}' x-on:click.prevent="window.livewire.emitTo('users.tickets.delete-modal', 'showModal' , {{$ticket->id}})" class="absolute top-3 right-3 hover:text-red-700 text-white">
                <i class="fa-solid fa-trash"></i>
            </button>
            <!-- end delete button -->
            @endif
            <!-- Ticket info-->
            <div class="flex flex-col justify-between h-full min-w-full px-2 md:px-4">
                <div class="flex flex-col gap-3 ">
                    <p class="font-bold text-xl">Film: {{$ticket->screening->movie->title}}</p>
                    <p class="">Vreme: {{$ticket->screening->start_time->format('d/m H:i')}}</p>
                    <div class="flex justify-between border-b-2 border-white">
                        <p class="w-24">Sala: {{$ticket->screening->hall_id}}</p>
                        <p>Sedišta:
                            @foreach($ticket->seats->sortBy(['column','row']) as $seat)
                            {{chr(64 + $seat->column) }}{{ $seat->row }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    </div>
                    <p class="font-bold text-xl">Račun:</p>

                    @if($ticket->seat_count > 0)
                    <!-- Ticket items-->
                    <div class="flex flex-col w-full gap-4 overflow-y-auto">

                        <!-- Item -->
                        <div class="flex flex-row justify-between border-b border-white gap-2">
                            <!-- Left info-->
                            <div class="flex flex-col gap-3">
                                <span>Biskopska karta:</span>
                            </div>
                            <!-- Right info-->
                            <div class="flex flex-row justify-between md:w-16">
                                <span class="text-sm">{{config('pricing.base_price')}}</span>
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
                                <span class="text-sm">{{$ticket->long_movie_addon}}</span>
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
                                <span class="text-sm">{{$ticket->technology_price_addon}}</span>
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
                                <span class="text-sm">{{$ticket->discount}}</span>
                                <span class="text-sm">RSD</span>
                            </div>
                            <!-- End info-->
                        </div>
                        <!-- End item -->
                        <!-- Item -->
                        <div class="flex flex-row justify-between border-b border-white gap-2">
                            <!-- Left info-->
                            <div class="flex flex-col gap-3">
                                <span>Broj sedišta:</span>
                            </div>
                            <!-- Right info-->
                            <div class="flex flex-row justify-between md:w-16">
                                <span class="text-sm"> x </span>
                                <span class="text-sm">{{$ticket->seats->count() ?? 0}}</span>
                            </div>
                            <!-- End info-->
                        </div>
                        <!-- End item -->

                    </div>
                    <!-- End Ticket items -->
                    @else
                    <!-- Canceled -->
                    <div class="flex flex-col items-center justify-center">
                        <p class="text-center text-2xl font-bold">Otkazana rezervacija</p>
                    </div>
                    <!-- End Cancelled -->
                    @endif
                </div>
                <!-- Ticket footer -->
                <div class="flex flex-col  border-t border-white">
                    <!-- Footer info -->
                    <div class="flex flex-row justify-between">
                        <p class="font-bold">Ukupno: </p>
                        <p class="font-bold">{{$ticket->seat_count > 0 ? $ticket->total : 0}} RSD</p>
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
    <!-- Modal -->
    <livewire:users.tickets.delete-modal/>
</div>
