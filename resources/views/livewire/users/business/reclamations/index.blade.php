<div class="relative w-full flex flex-col items-center p-2 pt-4 bg-gray-950 bg-opacity-80">
    <!-- Loading -->
    <div wire:loading class="absolute w-10 h-10 top-2 md:bottom-2 left-2 md:top-0 ">
        <x-loading-indicator/>
    </div>
    <!-- End loading -->
    <!-- Reclamations -->
    @if($reclamations)
    <div class="flex flex-1 flex-col justify-center w-full h-full">
        @forelse($reclamations as $reclamation)
        <!-- Reclamation border-->
        <div class="border-b-2 mb-3 md:mb-0 md:border-b-0 border-white relative p-4 pr-3 flex-1 min-w-0 md:min-w-[26rem]">
            <!-- Reclamation info -->
            <div class="flex flex-col justify-between h-full min-w-full px-2 md:px-4">
                <div class="flex flex-col gap-3 ">
                    <p class="font-bold text-xl">
                        Reklamacija Zahteva:
                        @if($reclamation->businessRequest->requestable instanceof \App\Models\Advert)
                        Oglašavanja {{ $reclamation->businessRequest->requestable->title }}
                        @else
                        Rentiranje sale {{ $reclamation->businessRequest->requestable->hall_id }}
                        @endif
                        <p class="">Zahtev kreiran: {{Carbon\Carbon::parse($reclamation->created_at)->format('H:i m/d/Y')}} </p>
                        <p class="flex border-b-2 border-white">Status:
                            @if($reclamation->status == 'PENDING')
                            <span class="text-yellow-500 ml-2">Na čekanju</span>
                            @elseif($reclamation->status == 'ACCEPTED')
                            <span class="text-green-500 ml-2">Odobren</span>
                            @elseif($reclamation->status == 'REJECTED')
                            <span class="text-red-500 ml-2">Odbijen</span>
                            @endif
                        </p>
                            <!-- Reclamation details -->
                            <div class="flex flex-col md:flex-row w-full h-full flex-1 gap-4">
                                <div class="flex flex-col h-full w-full border-b md:border-b-0 md:border-r border-white border-opacity-60">
                                    <p class="font-bold">Razlog reklamacije:</p>
                                    <p class="text-sm">{{$reclamation->text}}</p>
                                </div>
                                <div class="flex flex-col h-full w-full">
                                    <p class="font-bold">Odgovor:</p>
                                    <p class="text-sm">{{$reclamation->comment ?? 'Ovde odgovor'}}</p>
                                </div>
                            </div>
                            <!-- End reclamation details -->
                    </div>
                    <!-- End reclamation info-->
                </div>
                <!-- End reclamation border-->
                @empty
                <div class="flex flex-col w-full h-full justify-center">
                    <p class="text-4xl font-extrabold text-center">Nemate reklamacija.</p>
                </div>
                @endforelse
            </div>

            <!-- End Reclamations-->

            <!-- Paginator -->
            <div class="flex w-full justify-center">
                <span class="text-center">{{$reclamations->links()}}</span>
            </div>
        </div>
        @endif
    </div>
