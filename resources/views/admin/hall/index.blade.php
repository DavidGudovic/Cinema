@extends('templates.administration')

@section('content')
    <div class="flex flex-col justify-center items-center w-full h-full">
        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-6 md:w-[70rem]">
            <!-- Success message -->
            @if(@session()->has('success'))
                <div class="absolute inset-x-0 -top-5 md:-top-8 text-green-500 text-center">
                    Uspešno sačuvan menadžer sale!
                </div>
            @endif
            <!-- End success message -->
            @foreach($halls as $hall)
                <form action="{{route('halls.update', $hall)}}" method="POST"
                      class="relative flex flex-col justify-center border border-opacity-50 overflow-hidden border-white rounded-2xl">
                    @csrf
                    @method('PUT')
                    <img src="{{URL('images/halls/' . $hall->image_url)}}" alt="{{$hall->name}} slika">
                    <div
                        class="absolute inset-0 flex flex-col justify-center items-center gap-3 w-full h-full bg-gray-950 bg-opacity-60">
                        <h2 class="font-extrabold text-2xl">{{$hall->name}}</h2>
                        <label>
                            <!-- Pick a manager -->
                            <select type="submit"
                                class="p-2 bg-dark-blue text-white border border-white rounded-2xl cursor-pointer hover:text-red-700 text-center"
                                name="manager">
                                <option value="">Bez menadžera</option>
                                @foreach($managers as $manager)
                                    <option value="{{$manager->id}}" {{$manager->id == $hall->user_id ? 'selected' : ''}}>{{$manager->name}}</option>
                                @endforeach
                            </select>
                            <!-- End pick a manager -->
                        </label>
                        <!-- Submit -->
                        <button type="submit"
                                class="absolute inset-x-0 bottom-0 p-2 w-full bg-blend-darken text-white cursor-pointer hover:text-red-700 text-center">
                            Sačuvaj
                        </button>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
@endsection
