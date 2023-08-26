@extends('templates.app')

@section('content')
<!-- Wrapper -->
<div class="flex flex-col h-full w-full justify-center items-center md:p-14 p-4 gap-6">
    <!-- Heading -->
    <h1 class="text-3xl font-bold text-center mb-6">Vaša karta</h1>

    <!-- Ticket border-->
    <div class="md:mx-6 p-5 rounded-sm w-full md:w-[50rem] h-full border-white border">
        <div class="flex flex-col justify-between h-full px-2 md:px-4">
            <div class="flex flex-col gap-3 ">
                <!-- Ticket header -->
                <p class="font-bold text-xl">Film: {{$ticket->screening->movie->title}}</p>
                <p class="">Vreme: {{$ticket->screening->start_time->format('d/m H:i')}}</p>
                <div class="flex flex-wrap justify-between border-b-2 border-white">
                    <p class="w-24">Sala: {{$ticket->screening->hall_id}}</p>
                    <p>Sedišta:
                        @foreach($ticket->seats->sortBy(['column','row']) as $seat)
                        {{chr(64 + $seat->column) }}{{ $seat->row }}@if(!$loop->last), @endif
                        @endforeach
                    </p>
                </div>
                <!-- End ticket header-->

                <!-- Ticket billable -->
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
            </div>
            <!-- End Ticket footer -->
        </div>
        <!-- End Ticket info-->
    </div>
    <!-- End Ticket border-->

    <!-- Ticket Actions -->
    <div class="flex flex-col md:flex-row justify-between gap-4 md:w-[50rem]">

        <!-- Action -->
            <a href="{{route('user.tickets.print', [$user,$ticket])}}" class="text-center bg-transparent border rounded-xl border-white text-white p-2 h-10">
                <i class="fa-regular fa-file-pdf"></i> Preuzmite PDF
            </a>

        <!-- End action -->
        <!-- Discount -->
        <p class="text-sm flex-1">
            <span class="font-bold">*Napomena:</span>
            Poslali smo vam PDF ulaznicu na vašu e-mail adresu <span class="underline">{{auth()->user()->email}}</span>. Molimo vas da proverite svoj inbox. Ukoliko ne nađete ulaznicu u primljenim porukama, proverite folder za neželjenu poštu.
        </p>
        <!--End Discount-->
    </div>

</div>
<!-- End Wrapper -->
@endsection
