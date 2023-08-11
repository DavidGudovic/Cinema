<div class="fixed inset-0 h-full w-full z-50" x-data="{ showSideBar: @entangle('showSideBar') }" x-trap.noscroll="showSideBar" x-show="showSideBar" x-on:keydown.escape.window="showSideBar = false" x-cloak>
    <!-- The backdrop -->
    <div x-cloak x-show="showSideBar" x-transition:enter="transition ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 backdrop-blur-sm z-10" @click="showSideBar = false"></div>
    <!-- The sidebar -->
    <div x-cloak  x-transition:enter="transition ease-in-out duration-500 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-1000 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"  x-show="showSideBar"class="rounded-l-xl fixed right-0 w-full md:w-1/2  bg-neutral-900 h-full z-50 px-6" @click.away="showSideBar = false" >

        <!-- Close button -->
        <x-close-button class="top-10 left-10"/>
        <!-- End Close button -->

        <!-- Detailed history button-->
        <a class="absolute top-8 right-12 flex flex-row gap-2 items-center text-white hover:text-red-700" href="{{route("user.requests.index", ["user" => $user])}}">
            <span>Detaljna istorija</span>
            <i class="fa-solid fa-clock-rotate-left"></i>
        </a>
        <!-- End Detailed history button-->

        <!-- Sidebar content -->
        <div class="flex flex-col gap-6 md:gap-12 justify-center mt-24">
            @forelse($requestables as $request)
            <!-- Heading -->
            <p class="font-extrabold text-2xl text-center">Obrađeni zahtevi</p>
            <!-- End Heading -->

            <!-- Request -->
            <div class="flex flex-col gap-3">
                <p class="font-bold text-xl">
                    Zahtev:
                    @if($request->requestable instanceof \App\Models\Advert)
                    Oglašavanje
                    @else
                    Rentiranje sale
                    @endif
                </p>
                <p class="">Zahtev kreiran: {{Carbon\Carbon::parse($request->created_at)->format('H:i m/d/Y')}} </p>
                <p class="flex border-b-2 border-white">Status:
                    @if($request->status == 'PENDING')
                    <span class="text-yellow-500 ml-2">Na čekanju</span>
                    @elseif($request->status == 'ACCEPTED')
                    <span class="text-green-500 ml-2">Odobren</span>
                    @elseif($request->status == 'REJECTED')
                    <span class="text-red-500 ml-2">Odbijen</span>
                    @elseif($request->status == 'CANCELLED')
                    <span class="text-red-500 ml-2">Otkazan</span>
                    @endif
                </p>

                <p class="font-bold text-xl">Detalji:</p>
                <div>
                    <!-- Request details -->
                    @if($request->requestable instanceof \App\Models\Advert)
                    <div class="flex flex-col w-full flex-1 gap-4">

                        <!-- Details -->
                        <div class="flex flex-col md:flex-row md:justify-between border-b border-white ">
                            <!-- Item -->
                            <div class="flex flex-row gap-2 ">
                                <span>Naslov reklame:</span>
                                <span class="">{{$request->requestable->title}}</span>
                            </div>
                            <!-- End item -->
                            <!-- Item -->
                            <div class="flex flex-row gap-2">
                                <span>Delatnost:</span>
                                <span class="">{{$request->requestable->company}}</span>
                            </div>
                            <!-- End info-->
                            <!-- End item -->
                            <!-- Item -->
                            <div class="flex flex-row gap-2">
                                <span>Ukupno reklama:</span>
                                <span class="">{{$request->requestable->quantity}}</span>
                            </div>
                        </div>
                        <!-- End Details -->
                        <!-- CHARTS -->
                        @livewire('charts.advert', ['advert' => $request->requestable, 'request' => $request], $key = $request->requestable->id)
                        <!-- END CHARTS -->
                    </div>
                    @else
                    @include('livewire.users.business.requests.booking')
                    @endif
                    <!-- End request details -->
                </div>

                <!-- Request footer -->
                <div class="flex flex-col  border-t border-white">
                    <!-- Footer info -->
                    <div class="flex flex-row justify-between">
                        <p class="font-bold">Cena: </p>
                        <p class="font-bold">{{$request->price}} RSD</p>
                    </div>
                    <!-- End footer info-->
                </div>
                <!-- End Request footer -->
            </div>
            <!-- End Request info-->
        </div>
        <!-- End Request border-->



        <!-- Paginator -->
        <div class="flex justify-center">{{$requestables->links()}}</div>
        <!-- End Paginator -->
        @empty
        <div class="flex flex-col w-full h-full justify-center">
            <p class="text-4xl font-extrabold text-center">Nemate obrađenih zahteva.</p>
        </div>

        @endif

    </div>
    <!-- End Sidebar content -->
</div>

