@extends('templates.app')

@section('background-pattern') bg-authentication bg-cover bg-no-repeat bg-center brightness-75 @endsection

@section('content')
<!-- Register -->
<div class="flex justify-center align-middle my-10">
    <div class="flex flex-col gap-6 min-w-[400px]  p-6  rounded-lg bg-gray-950 bg-opacity-80">

        <h1 class="text-2xl font-bold text-center text-white">Registracija korisnika</h1>

        <!--Status message display-->
        @if(session()->has('status'))
        <p class='text-center font-bold mb-5
        @if(session('status') == 'error') text-red-600 @else text-green-400 @endif'>{{session('status_msg')}}</p>
        @endif
        <!-- End status message -->

        <!-- Register form -->
        <form class="" action="{{route('register.store')}}" method="post">
            <!-- Fields -->
            <!-- Cross site request forgery -->
            @csrf
            <!-- Username -->
            <div class="mb-4">
                <label for='username' class='sr-only'>Korisničko ime</label>
                <input type="text" name="username" id='username' placeholder="Unesite korisničko ime"
                class='bg-gray-700 border-2 text-white border-gray-600 w-full p-3 @error('username') border-red-500 @enderror' value='{{old('username')}}'>
                @error('username')
                <div class="text-red-500 mt-2 text-sm w-full">
                    {{$message}}
                </div>
                @enderror
            </div>
            <!-- Email -->
            <div class="mb-4">
                <label for='email' class='sr-only'>Email</label>
                <input type="text" name="email" id='email' placeholder="Unesite email"
                class='bg-gray-700 border-2 text-white border-gray-600 w-full p-3 @error('email') border-red-500 @enderror' value='{{old('email')}}'>
                @error('email')
                <div class="text-red-500 mt-2 text-sm w-full">
                    {{$message}}
                </div>
                @enderror
            </div>
            <!-- Name -->
            <div class="mb-4">
                <label for='name' class='sr-only'>Ime</label>
                <input type="text" name="name" id='name' placeholder="Unesite ime i prezime"
                class='bg-gray-700 border-2 text-white border-gray-600 w-full p-3 @error('name') border-red-500 @enderror' value='{{old('name')}}'>
                @error('name')
                <div class="text-red-500 mt-2 text-sm w-full">
                    {{$message}}
                </div>
                @enderror
            </div>
            <!-- pass -->
            <div class="mb-4">
                <label for= 'password' class='sr-only'>Lozinka</label>
                <input type= 'password' name='password' id='password' placeholder="Unesite lozinku"
                class='bg-gray-700 border-2 text-white border-gray-600 w-full p-3 @error('password') border-red-500 @enderror' >
                @error('password')
                <div class="text-red-500 mt-2 text-sm w-full">
                    {{$message}}
                </div>
                @enderror
            </div>
            <!--Confirm pass -->
            <div class="">
                <label for='password_confirmation' class='sr-only'>Potvrda lozinke</label>
                <input type='password' name='password_confirmation' id='password_confirmation' placeholder="Ponovite lozinku"
                class='bg-gray-700 border-2 text-white border-gray-600 w-full p-3 @error('password') border-red-500 @enderror' >
            </div>
            <!-- Account type -->
            <div class="flex flex-col gap-2 w-full justify-center @error('role') mt-4 @enderror">
                <div class="flex gap-4 w-full text-white justify-around p-3 @error('role') border-2 border-red-500 @enderror">
                    <div class="border-1 bg-transparent border-white">
                        <input type="radio" name="role" id="client" value="CLIENT">
                        <label class="hover:text-red-700 cursor-pointer" for="client" checked>Privatni profil</label>
                    </div>
                    <div class="border-1 bg-transparent border-white">
                        <input type="radio" name="role" id="business" value="BUSINESS_CLIENT">
                        <label class="hover:text-red-700 cursor-pointer" for="business">Biznis profil</label>
                    </div>
                </div>
                @error('role')
                <div class="text-red-500 mt-2 text-sm w-full pb-4">
                    {{$message}}
                </div>
                @enderror
            </div>

            <!-- End fields -->
            <!-- Buttons -->
            <div class="flex justify-evenly gap-4">
                <button type="submit" class="bg-red-700 text-white px-4 py-3 font-medium w-full">Registruj se</button>
                <button type="reset" class=" text-white px-4 py-3 font-medium w-full bg-gray-500">Resetuj</button>
            </div>
            <!-- End buttons -->
        </form>
        <!-- End register form -->
    </div>

</div>

<!-- End register -->
@endsection
