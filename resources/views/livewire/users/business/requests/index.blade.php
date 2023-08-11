<div class="relative w-full flex flex-col items-center p-2 pt-4 bg-gray-950 bg-opacity-80">
    <!-- Loading -->
    <div wire:loading class="absolute w-10 h-10 top-2 md:bottom-2 left-2 md:top-0 ">
        <x-loading-indicator/>
    </div>
    <!-- End loading -->
    <!-- Requests -->
    <div class="flex flex-1 flex-col justify-center w-full">
        @forelse($requests as $request)
        <!-- Request border-->
        <div class="border-b-2 mb-3 md:mb-0 md:border-b-0 border-white relative p-4 pr-3 flex-1 min-w-0 md:min-w-[26rem]">
            <!-- Request info -->
            <div class="flex flex-col justify-between h-full min-w-full px-2 md:px-4">
                <div class="flex flex-col gap-3 ">
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
                        @else
                        <span class="text-red-500 ml-2">Otkazan</span>
                        @endif
                    </p>

                    <!--- Request button -->
                    <div class="absolute top-0 right-2 flex justify-between">
                        @if($request->status == 'PENDING')
                        <button wire:click="cancelRequest({{$request->id}})" class="text-white hover:text-red-700 font-bold py-2 px-4">
                            Otkaži <i class="fa-solid fa-trash"></i>
                        </button>
                        @elseif(!$request->reclamation)
                        <button wire:click="disputeRequest({{$request->id}})" class="text-white hover:text-red-700 font-bold py-2 px-4">
                            Reklamiraj <i class="fa-solid fa-triangle-exclamation"></i>
                        </button>
                        @endif
                    </div>
                    <p class="font-bold text-xl">Detalji:</p>

                    <!-- Request details -->
                    @if($request->requestable instanceof \App\Models\Advert)
                    @include('livewire.users.business.requests.advert')
                    @else
                    @include('livewire.users.business.requests.booking')
                    @endif
                    <!-- End request details -->
                    <!-- Request footer -->
                    <div class="flex flex-col  border-t border-white">
                        <!-- Footer info -->
                        <div class="flex flex-row justify-between">
                            <p class="font-bold">Cena: </p>
                            <p class="font-bold">{{$request->price}} RSD</p>
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
                <p class="text-4xl font-extrabold text-center">Nemate zahteva.</p>
            </div>
            @endforelse
        </div>
        <!-- End Tickets-->

        <!-- Paginator -->
        <div class="flex w-full justify-center">
            <span class="text-center">{{$requests->links()}}</span>
        </div>
        <!-- Modal -->

    </div>
</div>
