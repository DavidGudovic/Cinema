<div x-data="{step: @entangle('step'), totalSteps: 3}" class="relative flex justify-center items-center gap-6 w-full h-screen overflow-hidden">
    <!-- Heading -->
    <div class="absolute top-6 md:top-20 flex flex-col justify-center items-center">
        <p x-transition:enter="transition ease-out-in duration-700 transform"
           x-transition:enter-start="-translate-y-[150%]"
           x-transition:enter-end="translate-y-0" x-cloak x-show="step == 1" class="h-full text-2xl font-bold">
            Izaberite salu</p>
        <p x-transition:enter="transition ease-out-in duration-700 transform"
           x-transition:enter-start="-translate-y-[150%]"
           x-transition:enter-end="translate-y-0" x-cloak x-show="step == 2" class="h-full text-2xl font-bold">
            Izaberite tehnologiju</p>
        <p x-transition:enter="transition ease-out-in duration-700 transform"
           x-transition:enter-start="-translate-y-[150%]"
           x-transition:enter-end="translate-y-0" x-cloak x-show="step == 3" class="h-full text-2xl font-bold">
            Izaberite vreme</p>
    </div>

    <!-- Steps -->
    <div class="flex flex-col flex-1 h-full">
        <!-- Halls -->
        <x-step>
            <x-slot:step>1</x-slot:step>
            <div class="grid grid-cols-1 md:grid-cols-2 justify-center mt-44 md:mt-12 gap-6">
                @foreach($halls as $hall)
                    <div wire:click="setHall({{$hall}})" class="relative flex flex-col justify-center items-center gap-2 cursor-pointer hover:text-red-700">
                        <img src="{{URL('images/halls/' . $hall->image_url)}}"
                             class=" w-40 md:w-96" alt="hall {{$hall->name}}">
                        <div class="absolute inset-0 w-full h-full bg-gray-950 opacity-60"></div>
                        <p class="absolute m-auto text-xl font-bold text-center">{{$hall->name}}</p>
                    </div>
                @endforeach
            </div>
        </x-step>
        <!-- End halls-->

        <!-- Tags -->
        <x-step>
            <x-slot:step>2</x-slot:step>
            <div class="flex justify-center gap-12">
                <div class="flex flex-col md:flex-row justify-center items-center gap-6">
                    <img src="{{URL('images/tags/dolby.png')}}" alt="tag dolby atmos" class="w-24 md:w-32">
                    <p class="font-bold text-xl mx-8"> + </p>
                    @foreach($tags as $tag)
                        @if($tag->name !== 'Dolby Atmos')
                            <img wire:click="setTag({{$tag}})" src="{{URL('images/tags/' . $tag->image_url)}}"
                                 class="filter hover:invert cursor-pointer w-24 md:w-32" alt="tag {{$tag->name}}">
                        @endif
                    @endforeach
                </div>
            </div>
        </x-step>
        <!-- End tags-->

        <!-- Date -->
        <x-step>
            <x-slot:step>3</x-slot:step>
            <div>
                <div class="flex flex-col justify-center items-center gap-2">
                    <p x-on:click="step++" class="cursor pointer text-center">Select date</p>
                </div>
            </div>
        </x-step>
        <!-- End date-->


        <!-- Success message -->
        <x-step>
            <x-slot:step>4</x-slot:step>
            <a href="{{route('screenings.create', ['movie' => $movie])}}"
               class="text-center font-extrabold text-5xl cursor-pointer">Finish</a>
        </x-step>
        <!-- End success message-->
    </div>
    <!-- End steps -->

    <!-- Breadcrumbs -->
    <x-breadcrumbs class="absolute right-6 md:right-12"/>
    <!-- End breadcrumbs -->

</div>
