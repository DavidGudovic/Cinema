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
        <div class="relative border-b-2 mb-3 md:mb-0 md:border-b-0 border-white p-4 pr-3 flex-1 min-w-0 md:min-w-[26rem]">
            <!-- Reclamation info -->
            <div class="flex flex-col justify-between h-full min-w-full px-2 md:px-4">
                <div class="flex flex-col gap-3 ">
                    <!-- Actions -->
                     @if($reclamation->status == 'PENDING')
                        <button wire:click="cancelReclamation({{$reclamation->id}})" class="absolute top-0 right-0 text-white hover:text-red-700 font-bold py-2 px-4">
                            <span class="hidden md:inline-flex">Otkaži </span> <i class="fa-solid fa-trash"></i>
                        </button>
                    @endif
                    <!-- End actions -->

                    <!-- Reclamation header -->
                    <p class="font-bold text-xl">
                        Reklamacija Zahteva:
                        @if($reclamation->businessRequest->requestable instanceof \App\Models\Advert)
                        Oglašavanja {{ $reclamation->businessRequest->requestable->title }}
                        @else
                        Rentiranje sale {{ $reclamation->businessRequest->requestable->hall_id }}
                        @endif
                    </p>
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
                    <!-- End reclamation header -->

                    <!-- Reclamation details -->
                    <div class="flex flex-col md:flex-row w-full h-full flex-1 gap-4">
                        <div class="flex flex-col h-full w-full">
                            <p class="font-bold text-center text-lg">Razlog reklamacije:</p>
                            <textarea class="p-2 w-full border  bg-neutral-950 bg-opacity-80 border-opacity-70 text-white rounded-xl resize-none @error('text') border-red-500 @else border-white @enderror" x-ref="counted" x-on:keyup="count = $refs.counted.value.length" name="text" maxlength="1000" rows="15" readonly>{{$reclamation->text}}</textarea>
                        </div>
                        <div class="flex flex-col h-full w-full">
                            <p class="font-bold text-center text-lg">Odgovor:</p>
                            <textarea class="p-2 w-full border  bg-neutral-950 bg-opacity-80 border-opacity-70 text-white rounded-xl resize-none @error('text') border-red-500 @else border-white @enderror @if($reclamation->comment == null ? true : false) text-opacity-50 @endif" x-ref="counted" x-on:keyup="count = $refs.counted.value.length" name="text" maxlength="1000" rows="15" readonly>{{$reclamation->comment ?? 'Vaša reklamacija se još uvek obrađuje, odgovor naših menadžera moći ćete pročitati ovde u najkraćem mogućem roku'}}</textarea>
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
    {{-- Modals --}}
        @livewire('users.business.reclamations.delete-modal')
    @endif
</div>
