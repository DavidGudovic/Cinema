@extends('templates.administration')

@section('content')
    <div class="flex flex-col justify-center items-center w-full h-full">
        <div class="grid md:grid-cols-2 grid-cols-1 gap-6 md:w-[70rem]">
            @foreach($halls as $hall)
                <form action="{{route('halls.update', $hall)}}" method="POST"
                      class="relative flex flex-col justify-center">
                    @csrf
                    @method('PUT')
                    <img src="{{URL('images/halls/' . $hall->image_url)}}" alt="{{$hall->name}} slika">
                    <div
                        class="absolute inset-0 flex flex-col justify-center items-center gap-3 w-full h-full bg-gray-950 bg-opacity-60">
                        <h2 class="font-extrabold text-2xl">{{$hall->name}}</h2>
                        <label>
                            <select type="submit"
                                class="p-2 bg-gray-950 text-white border border-white rounded-2xl cursor-pointer hover:text-red-700 text-center"
                                name="manager" value="{{$hall->user_id}}">
                                @foreach($managers as $manager)
                                    <option value="{{$manager->id}}">{{$manager->name}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
@endsection
