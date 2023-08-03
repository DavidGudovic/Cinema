@extends('templates.app')

@section('content')
<div class="flex flex-col w-full h-full mb-12">


    <!-- Header -->
    <h1 class="text-center my-8 font-extrabold text-3xl">Rezervacija</h1>
    <!-- End Header -->

    <!-- Content -->
    <div class="flex flex-col md:flex-row items-center text-white">
        <!-- SEAT MAP -->
        <div class="flex flex-col gap-12 justify-center md:w-1/2">
            <!-- Screen -->
            <div class="flex justify-center md:mx-14">
                <div class="w-full h-12 border-t-4 border-white rounded-t-2xl">
                    <p class="text-center text-white">Platno</p>
                </div>
            </div>
            <!-- End Screen -->
            <!-- Seats -->
            <div class="flex gap-12 md:gap-24 justify-center">
                <!-- Left seats -->
                <div class="flex flex-col gap-2 md:gap-4">
                    @for ($i = 0; $i < $screening->hall->columns; $i++)
                    <div class="flex flex-row gap-2 md:gap-4">
                        @for ($j = 1; $j <= ($screening->hall->rows)/2 + 1 ; $j++)
                        <div class="w-6 h-6 border-2 border-white rounded-t-xl cursor-pointer hover:bg-white">
                            <span class="text-[0.7rem] pt-[0.3rem] w-full align-center justify-center flex"> {{ chr(65 + $i) }}{{ $j }}</span>
                        </div>
                        @endfor
                    </div>
                    @endfor
                </div>
                <!-- Right seats -->
                <div class="flex flex-col gap-2 md:gap-4">
                    @for ($i = 0; $i < $screening->hall->columns; $i++)
                    <div class="flex flex-row gap-2 md:gap-4">
                        @for ($j = ($screening->hall->rows)/2 + 2; $j <= $screening->hall->rows + 2; $j++)
                        <div class="w-6 h-6 border-2 border-white rounded-t-xl cursor-pointer hover:bg-white">
                            <span class="text-[0.7rem] pt-[0.3rem] w-full align-center justify-center flex"> {{ chr(65 + $i) }}{{ $j }}</span>
                        </div>
                        @endfor
                    </div>
                    @endfor
                </div>
            </div>
            <!-- End seats -->

        </div>
        <!-- End SEAT MAP -->

        <!-- Booking form -->
        <div class="md:w-1/2">

        </div>
        <!-- End booking form -->
    </div>
    <!-- End content -->
</div>





@endsection
