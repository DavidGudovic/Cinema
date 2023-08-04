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
                    Račun:
                </p>
                <!-- Ticket items-->
                <div class="flex flex-col w-full gap-4">

                    <!-- Item -->
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
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
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
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
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
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
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
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
                    <div class="flex flex-row justify-between border-b-[0.0005rem] border-opacity-50 border-white gap-2">
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
            <div class="flex flex-col  gap-6 border-t border-white">
                <!-- Footer info -->
                <div class="flex flex-row justify-between">
                    <p class="font-bold">Ukupno: </p>
                    <p class="font-bold">{{$ticket->total}} RSD</p>
                </div>
                <!-- End footer info-->
                <!-- Action -->
                <a href="#" class="text-center bg-transparent border rounded-xl border-white text-white p-2 w-48">
                    <i class="fa-solid fa-ticket"></i> Rezerviši Kartu
                </a>
                <!-- End action -->
                <!-- Discount -->
                 <p class="text-sm">
                    <span class="font-bold">*Napomena:</span>
                    Ako rezervišete {{config('pricing.seat_discount_threshold')}} ili više sedišta na jednoj ulaznici, dobijate popust od {{config('pricing.seat_discount') * 100}}%. Ova posebna ponuda je naš način da Vam se zahvalimo što dolazite u naš bioskop sa porodicom ili prijateljima. Uživajte u filmu i uštedite kupovinom više karata odjednom!
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
