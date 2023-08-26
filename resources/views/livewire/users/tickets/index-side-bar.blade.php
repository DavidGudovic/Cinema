<div class="fixed inset-0 h-full w-full z-50" x-data="{ showSideBar: @entangle('showSideBar') }" x-trap.noscroll="showSideBar" x-show="showSideBar" x-on:keydown.escape.window="showSideBar = false" x-cloak>
    <!-- The backdrop -->
    <div x-cloak x-show="showSideBar" x-transition:enter="transition ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 backdrop-blur-sm z-10" @click="showSideBar = false"></div>
    <!-- The sidebar -->
    <div x-cloak  x-transition:enter="transition ease-in-out duration-500 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-1000 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"  x-show="showSideBar"class="rounded-l-xl fixed right-0 w-full md:w-1/2  bg-neutral-900 h-full z-50 px-6" @click.away="showSideBar = false" >

        <!-- Close button -->
        <x-close-button class="top-10 left-10"/>
        <!-- End Close button -->

        <!-- Detailed history button-->
        <a class="absolute top-8 right-12 flex flex-row gap-2 items-center text-white hover:text-red-700" href="{{route("user.tickets.index", ["user" => $user])}}">
            <span>Detaljna istorija</span>
            <i class="fa-solid fa-clock-rotate-left"></i>
        </a>
        <!-- End Detailed history button-->

        <!-- Sidebar content -->
        <div class="flex flex-col gap-6 md:gap-12 justify-center mt-24">
            <!-- Heading -->
            <p class="font-extrabold text-2xl text-center">Trenutne rezervacije</p>
            <!-- End Heading -->

            @forelse($tickets as $ticket)
            <!-- Ticket border-->
            <div class="border-b-2 mb-3 md:mb-0 md:border-b-0 border-white relative p-4 pr-3 flex-1 min-w-0 md:min-w-[26rem]">

                <!-- PRINT -->
                <a href="{{route('user.tickets.print', [$user,$ticket])}}" class="absolute top-7 right-6 hover:text-red-700 text-white">
                    <span class="hidden md:inline-block">Štampaj</span>  <i class="fa-regular fa-file-pdf"></i>
                </a>
                <!--End Print-->

                <!-- Ticket info-->
                <div class="flex flex-col justify-between h-full min-w-full px-2 md:px-4">
                    <div class="flex flex-col gap-3 ">
                        <p class="font-bold text-xl">Film: {{$ticket->screening->movie->title}}</p>
                        <p class="">Vreme: {{$ticket->screening->start_time->format('d/m H:i')}}</p>
                        <div class="flex justify-between border-b-2 border-white">
                            <p class="w-24">Sala: {{$ticket->screening->hall_id}}</p>
                            <p>Sedišta:
                                @foreach($ticket->seats->sortBy(['column','row']) as $seat)
                                {{$seat->human_seat}}@if(!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>
                        <p class="font-bold text-xl">Račun:</p>
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
                                    <span class="text-sm">{{config('settings.pricing.base_price')}}</span>
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

            <!-- Paginator -->
            <div class="flex justify-center">{{$tickets->links()}}</div>
            <!-- End Paginator -->

            @empty
            <div class="flex flex-col w-full h-full justify-center">
                <p class="text-4xl font-extrabold text-center">Nemate rezervisanih karata.</p>
            </div>
            @endforelse


        </div>
        <!-- End Sidebar content -->
    </div>
</div>
