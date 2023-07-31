@extends('templates.app')

@section('background-pattern') bg-authentication bg-cover bg-no-repeat bg-center brightness-75 @endsection

@section('content')
<!-- Login -->
<div class="flex items-center justify-center my-36 text-white">

    <div class="flex flex-col gap-6 min-w-[400px]  p-6  rounded-lg bg-gray-950 bg-opacity-80">

        <h1 class="text-2xl font-bold text-center">Prijava korisnika</h1>

        <!--Status message display-->
        @if(session()->has('status'))
        <p class='text-center font-bold
        @if(session('status') == 'error') text-red-600 @else text-green-400 @endif'>{{session('status_msg')}}
        @if(session()->has('verification_error')) <a class="text-red-500 hover:text-yellow-500 underline" href="{{route('verify.show', [session('id'), session('email')])}}">Pošalji ponovo</a> @endif </p>
        @endif
        <!-- End status message -->

        <!--Login form-->
        <form class="" action="{{route('login.store')}}" method="post">
            <!--fields-->
            <!-- Cross site request forgery -->
            @csrf

            <!--Username -->
            <div class="mb-4">
                <label for='username' class='sr-only'>Korisničko ime</label>
                <input type="text" name="username" id='username' placeholder="Unesite korisničko ime"
                class='bg-gray-700 border-2 text-white border-gray-600 w-full p-4 @error('username') border-red-500 @enderror' value='{{old('email')}}'>
                @error('username')
                <div class="text-red-500 mt-2 text-sm">
                    {{$message}}
                </div>
                @enderror
            </div>
            <!-- Password -->
            <div class="mb-4">
                <label for= 'password' class='sr-only'>Lozinka</label>
                <input type= 'password' name= 'password' id= 'password' placeholder="Unesite lozinku"
                class='bg-gray-700 border-2 text-white border-gray-600 w-full p-4 @error('password') border-red-500 @enderror' >
                @error('password')
                <div class="text-red-500 mt-2 text-sm">
                    {{$message}}
                </div>
                @enderror
            </div>
            <!-- remember me -->
            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2 cursor-pointer" id='remember'>
                    <label for='remember'>Zapamti me</label>
                </div>
            </div>
            <!-- end fields-->
            <!-- Buttons -->
            <div>
                <button type="submit" class="bg-red-700 text-white px-4 py-3 font-medium w-full">Prijavi se</button>
            </div>
            <!-- End buttons -->
            <div>
                <p class="text-white text-sm mt-1">Nemate profil? <a class="cursor-pointer font-bold text-white underline hover:text-red-600" href="{{route("register.create")}}">Registrujte se</a></p>
            </div>
        </form>
        <!-- End login form -->
    </div>
</div>


<!--End login -->
@endsection
