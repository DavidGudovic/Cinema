@extends('templates.app')


@section('content')
<div class="flex flex-col items-center gap-10 w-full h-full overflow-x-hidden my-12">

    <h1 class="font-extrabold text-4xl text-center">Rentiranje sala</h1>

        <!-- Filter -->
        <div x-data='{duration: 1, hour: 8, date: "{{ \Carbon\Carbon::now()->format('Y-m-d') }}" }' class="flex flex-col md:flex-row gap-6 rounded-xl bg-neutral-200 p-2 px-4">
            <!-- Responsive wrap group 1-->
            <div class="flex gap-6">
                <!-- Datum -->
                <div class="flex flex-col gap-1">
                    <p class="font-bold text-neutral-700 opacity-50">Pretraži od datuma</p>
                    <input type="date"  x-model="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->addMonths(1)->format('Y-m-d') }}"  x-on:keydown="false;" class="rounded-md border text-neutral-700 border-neutral-700 p-1">
                </div>
                <!-- end datum -->
                <!-- StartTime -->
                <div class="flex flex-col gap-1">
                    <p class="font-bold text-neutral-700 opacity-50">Početak</p>
                    <div class="relative flex gap-2 items-center rounded-md border text-neutral-700 border-neutral-700 bg-white p-[0.3rem] mr-4">
                        <span class="text-center text-neutral-700" readonly x-text="hour + ':00'"></span><i class="fa-regular fa-clock text-center text-neutral-700 opacity-50"></i>
                        <div class="absolute -right-6 bottom-0 flex flex-col justify-center items-center">
                            <i x-on:click="hour == {{config('restrictions.closing_time') - 1}} ? false : hour++" class="fa-solid text-lg cursor-pointer text-neutral-700 opacity-70 hover:text-red-700 fa-chevron-up"></i>
                            <i x-on:click="hour == {{config('restrictions.opening_time')}} ? false : hour--" class="fa-solid text-lg cursor-pointer text-neutral-700 opacity-70 hover:text-red-700 fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
                <!-- End StartTime -->
            </div>
            <!-- End responsive wrap group 1 -->
            <!-- Responsive wrap group 2 -->
            <div class="flex gap-6">
                <!-- Duration -->
                <div class="flex flex-col gap-1">
                    <p class="font-bold text-neutral-700 opacity-50">Trajanje</p>
                    <div  class=" relative flex items-center gap-2 rounded-md border text-neutral-700 border-neutral-700 bg-white p-[0.3rem] mr-4 cursor-pointer">
                        <span class="text-center text-neutral-700" readonly x-text="duration"></span><i class="ml-2 fa-solid fa-hourglass-start opacity-50 text-neutral-700"></i>
                        <div class="absolute -right-6 bottom-0 flex flex-col justify-center items-center">
                            <i x-on:click="duration == {{config('restrictions.max_booking')}} ? false : duration++" class="fa-solid text-lg hover:text-red-700 text-neutral-700 opacity-70 fa-chevron-up"></i>
                            <i x-on:click="duration == {{config('restrictions.min_booking')}} ? false : duration--" class="fa-solid text-lg hover:text-red-700 text-neutral-700 opacity-70 fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
                <!-- End Duration -->
                <!-- Submit -->
                <div class="flex justify-center w-full">
                    <button x-on:click="window.livewire.emit('submit', date, hour, duration)" class="bg-red-700 w-full text-white hover:bg-white hover:text-red-700 hover:border hover:border-gray-950 rounded-md p-2 px-4 text-lg ">
                        Pretraži
                    </button>
                </div>
                <!-- End submit -->
            </div>
            <!-- End responsive wrap group 2 -->
        </div>
        <!-- End filter -->

        <!-- Halls -->
        @livewire('resources.halls.index')
        <!-- End halls -->

</div>
@endsection
