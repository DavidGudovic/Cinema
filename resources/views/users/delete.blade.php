@extends('templates.user-profile')

@section('background-pattern') bg-user-profile bg-cover bg-no-repeat bg-center @endsection

@section('window')
<div class="h-full w-full border border-white text-white bg-gray-950 bg-opacity-75">
    <div class="flex flex-col p-5 md:p-28 gap-4 ">
        <p class="font-bold text-2xl">Deaktivacija naloga</p>
        <p>Ova akcija će ukloniti vaš Cinemanija nalog. Nećete moći da povratite informacije, kao ni sadržaj koji se u njemu nalazio.  Ako ste sigurni da želite da nastavite, unesite Vašu lozinku.</p>
        <form class="flex flex-col gap-5" action="{{route('user.destroy', auth()->user())}}" method="post">
            @method('DELETE')
            @csrf
            <div class="flex flex-col gap-1">
                <input type="password" name="password" placeholder="Unesite vašu lozinku" class="form-control p-2 @error('password') border-red-600 @enderror">
                @error('password') <p class="text-red-600">{{$message}}</p> @enderror
            </div>

            <input type="submit" name="" value="Deaktiviraj nalog" class="bg-red-700 text-white rounded-xl p-2 md:w-56 hover:text-red-500 hover:bg-gray-300 cursor-pointer">
        </form>
    </div>
</div>
@endsection
