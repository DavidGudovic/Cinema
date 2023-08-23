@extends('templates.administration')

@section('content')
    <!-- Container -->
    <div x-data="{step: 1}" class="flex justify-center items-center gap-6 w-full h-screen overflow-hidden">

        <!-- Step -->
        <div class="flex flex-col flex-1 h-full">
            <!-- Halls -->
            <x-step>
                <x-slot:step>1</x-slot:step>
                <div class="flex flex-wrap justify-center gap-12">
                    @foreach($halls as $hall)
                        <div class="flex flex-col justify-center items-center gap-2">
                            <img x-on:click="step++" src="{{URL('images/halls/' . $hall->image_url)}}" class="w-80" alt="hall {{$hall->name}}">
                            <p class="text-center">{{$hall->name}}</p>
                        </div>
                    @endforeach
                </div>
            </x-step>
            <!-- End halls-->

            <!-- Tags -->
            <x-step>
                <x-slot:step>2</x-slot:step>
                <p x-on:click="step++" class="font-extrabold text-5xl cursor-pointer">2</p>
                <div class="flex flex-wrap justify-center gap-12">
                    @foreach($tags as $tag)
                        <div class="flex flex-col justify-center items-center gap-2">
                            <img x-on:click="step++" src="{{URL('images/tags/' . $tag->image_url)}}" class="w-80" alt="tag {{$tag->name}}">
                            <p class="text-center">{{$hall->name}}</p>
                        </div>
                    @endforeach
                </div>
            </x-step>
            <!-- End tags-->

            <!-- Date -->
            <x-step>
                <x-slot:step>3</x-slot:step>
                <div>
                    <p x-on:click="step++" class="font-extrabold text-5xl cursor-pointer">3</p>
                    <div class="flex flex-col justify-center items-center gap-2">
                        <p class="text-center">Select date</p>
                        <input type="date" class="w-80">
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
        <x-breadcrumbs/>
        <!-- End breadcrumbs -->

    </div>
    <!-- End container -->
@endsection
