<div>
    <!-- hall List -->
    <div class="flex flex-col divide-y divide-white mx-auto mt-6">
        @forelse($halls_map as $date => $halls)
        <!-- Date -> hall, hall -->
        <div class="flex flex-col md:flex-row items-center md:items-start p-4 gap-6">
            <!-- Date -->
            <div class="flex flex-col items-center md:items-start w-20 md:min-w-[9rem] md:max-w-[9rem]">
                <p class="text-lg md:text-2xl font-bold">{{Str::ucfirst(strftime('%A', strtotime($date)))}}</p>
                <p class="md:text-lg">{{Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
            </div>
            <!-- End date-->
            <!-- hall -->
            <div class="flex flex-wrap justify-center md:gap-8">
                @forelse($halls as $hall)
                <a href="{{route('halls.booking.create', ['hall' => $hall, 'date' => encrypt($date), 'start_time' => encrypt($start_time),'end_time' => encrypt($end_time)])}}" class="relative flex flex-col gap-2 w-40 justify-center">
                    <img src="{{URL('images/halls/' . $hall->image_url)}}" alt="hall tag" class="object-center">
                    <p class="font-bold">{{$hall->name}}</p>
                </a>
                <!-- End hall-->
                @empty
                <p class="text-2xl font-extrabold text-center w-full my-4 opacity-60">Nema slobodnih sala za naznačeni termin</p>
                @endforelse
            </div>
        </div>
        @empty
        @if(session()->has('success'))
        <p class="text-3xl font-extrabold text-center text-green-500 w-full mt-8 mb-16">{{session('success')}}</p>
        @else
        <p class="text-3xl font-extrabold text-center w-full mt-8 mb-16">Unesite detalje vašeg zahteva</p>
        @endif
        @endforelse
        <!-- End Date -> hall, hall -->
    </div>
    <!-- End hall List -->
</div>
