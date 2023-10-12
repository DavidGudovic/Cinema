<div class="md:w-1/2 h-full">
    <!-- Ticket border-->
    <div class=" border-white  relative mx-6 flex-1 min-w-0 md:min-w-[26rem]">
        <!-- Ticket info-->
        <div class="flex flex-col justify-between h-full min-w-full px-2 md:px-4">

            @if ($ticket->seats->isNotEmpty())

            <div class="relative flex flex-col gap-3 ">
                <!-- Loading indicator-->
                <div wire:loading class="absolute top-0 left-16 w-9 h-9">
                    <x-loading-indicator />
                </div>
                <!-- End loading indicator-->
                <!-- Ticket header -->
                <p class="font-bold text-xl w-34">
                    Bill:
                </p>
                <!-- Ticket items-->
                <div class="flex flex-col w-full gap-4">

                    <!-- Item -->
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
                        <!-- Left info-->
                        <div class="flex flex-col gap-3">
                            <span>Cinema ticket:</span>
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
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
                        <!-- Left info-->
                        <div class="flex flex-col gap-3">
                            <span>Movie duration add-on:</span>
                        </div>
                        <!-- Right info-->
                        <div class="flex flex-row justify-between md:w-16">
                            <span class="text-sm">{{$ticket->calc_long_movie_addon}}</span>
                            <span class="text-sm">RSD</span>
                        </div>
                        <!-- End info-->
                    </div>
                    <!-- End item -->

                    <!-- Item -->
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
                        <!-- Left info-->
                        <div class="flex flex-col gap-3">
                            <span>Technology add-on:</span>
                        </div>
                        <!-- Right info-->
                        <div class="flex flex-row justify-between md:w-16">
                            <span class="text-sm">{{$ticket->calc_technology_price_addon}}</span>
                            <span class="text-sm">RSD</span>
                        </div>
                        <!-- End info-->
                    </div>
                    <!-- End item -->

                    <!-- Item -->
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
                        <!-- Left info-->
                        <div class="flex flex-col gap-3">
                            <span>Seat quantity:</span>
                        </div>
                        <!-- Right info-->
                        <div class="flex flex-row justify-between md:w-16">
                            <span class="text-sm"> x </span>
                            <span class="text-sm">{{$ticket->seats->count() ?? 0}}</span>
                        </div>
                        <!-- End info-->
                    </div>
                    <!-- End item -->

                    <!-- Item -->
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
                        <!-- Left info-->
                        <div class="flex flex-col gap-3">
                            <span>Discount:</span>
                        </div>
                        <!-- Right info-->
                        <div class="flex flex-row justify-between md:w-16">
                            <span class="text-sm">{{$ticket->calc_discount}}</span>
                            <span class="text-sm">RSD</span>
                        </div>
                        <!-- End info-->
                    </div>
                    <!-- End item -->

                </div>
                <!-- End Ticket items -->
            </div>
            <!-- Ticket footer -->
            <div class="flex flex-col  gap-6 border-t border-white">
                <!-- Footer info -->
                <div class="flex flex-row justify-between">
                    <p class="font-bold">Total: </p>
                    <p class="font-bold">{{$ticket->calc_total}} RSD</p>
                </div>
                <!-- End footer info-->
                <!-- Action -->
                <div class="flex justify-between gap-2">
                    <a wire:click.prevent="store()" class="text-center bg-transparent border rounded-xl border-white text-white p-2 md:w-48">
                        <i class="fa-solid fa-ticket"></i> Reserve ticket
                    </a>
                    <a wire:click.prevent="resetSelectedSeats()" class="text-center bg-transparent border rounded-xl border-white text-white p-2 md:w-48">
                        <i class="fa-solid fa-x"></i> Cancel reservation
                    </a>
                </div>

                <!-- End action -->
                <!-- Discount -->
                <p class="text-sm">
                    <span class="font-bold">*Napomena:</span>
                    If you reserve {{config('settings.pricing.seat_discount_threshold')}} or more seats on a single ticket, you receive a discount of {{config('settings.pricing.seat_discount') * 100}}%. This special offer is our way of thanking you for coming to our cinema with family or friends. Enjoy the movie and save by purchasing multiple tickets at once!
                </p>
                <!--End Discount-->
            </div>
            <!-- End Ticket footer -->
            @else
            <div class="flex flex-col h-full gap-8">
                <p class="text-center text-2xl font-extrabold">Izaberite sedište</p>
                <p class="text-sm">
                    <span class="font-bold">*Napomena:</span>
                    Imajte na umu da raspored stvarne sale u našem bioskopu može da se razlikuje od one prikazane na ekranu. Trudimo se da pružimo najtačnije informacije, ali zbog različitih okolnosti, promene su moguće. Molimo vas da proverite tačne detalje pre početka projekcije.
                </p>
            </div>
            @endif
        </div>
        <!-- End Ticket info-->
    </div>
    <!-- Booking -->

</div>
