@extends('templates.screening')

@section('screening-content')
<!-- Screenings -->
    <div class="flex justify-center align-center w-full">
        <img src="{{URL('images/utility/popcorn.png')}}" alt="popcorn" class="h-12 w-12 text-center">
    </div>

    <h2 class="text-3xl font-bold text-center">Projekcije</h2>
    <!-- Screening List -->
    <div class="flex flex-col divide-y divide-white mx-auto mt-6">
        @forelse($screenings_map as $date => $screenings)
        <!-- Date -> Screening, Screening -->
        <div class="flex p-4 gap-6">
            <!-- Date -->
            <div class="flex flex-col w-20 md:min-w-[9rem] md:max-w-[9rem]">
                <p class="text-lg md:text-2xl font-bold">{{Str::ucfirst(strftime('%A', strtotime($date)))}}</p>
                <p class="md:text-lg">{{Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
            </div>
            <!-- End date-->
            <!-- Screening -->
            <div class="flex flex-wrap md:gap-4">
                @foreach($screenings as $screening)
                <a href="{{route('movie.screenings.show', ['movie' => $movie, 'screening' => $screening])}}" class="relative flex flex-col  w-20 p-4 pt-6 justify-center">
                    <img src="{{URL('images/tags/' . $screening->tags[0]->image_url)}}" alt="screening tag" class="absolute bottom-12 w-12">
                    <p class="font-bold">{{Carbon\Carbon::parse($screening->start_time)->format('H:i')}}</p>
                    <p class="">Sala {{$screening->hall_id}}</p>
                </a>
                <!-- End Screening-->
                @endforeach
            </div>
        </div>
        @empty
        <p class="text-3xl font-extrabold text-center w-full mt-8 mb-16">Uskoro!</p>
        @endforelse
        <!-- End Date -> Screening, Screening -->
    </div>
    <!-- End Screening List -->
@endsection
