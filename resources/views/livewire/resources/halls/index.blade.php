<div>
     <!-- hall List -->
    <div class="flex flex-col divide-y divide-white mx-auto mt-6">
        @forelse($halls_map as $date => $halls)
        <!-- Date -> hall, hall -->
        <div class="flex p-4 gap-6">
            <!-- Date -->
            <div class="flex flex-col w-20 md:min-w-[9rem] md:max-w-[9rem]">
                <p class="text-lg md:text-2xl font-bold">{{Str::ucfirst(strftime('%A', strtotime($date)))}}</p>
                <p class="md:text-lg">{{Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
            </div>
            <!-- End date-->
            <!-- hall -->
            <div class="flex flex-wrap md:gap-4">
                @foreach($halls as $hall)
                <a href="#" class="relative flex flex-col gap-2 w-40 justify-center">
                    <img src="{{URL('images/halls/' . $hall->image_url)}}" alt="hall tag" class="object-center">
                    <p class="font-bold">{{$hall->name}}</p>
                </a>
                <!-- End hall-->
                @endforeach
            </div>
        </div>
        @empty
        <p class="text-3xl font-extrabold text-center w-full mt-8 mb-16">Unesite detalje vašeg zahteva</p>
        @endforelse
        <!-- End Date -> hall, hall -->
    </div>
    <!-- End hall List -->
</div>
