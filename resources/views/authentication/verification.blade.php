@extends('templates.app')

@section('background-pattern') bg-authentication bg-cover bg-no-repeat bg-center brightness-75 @endsection

@section('content')
<!-- Login -->
<div class="flex items-center justify-center my-36 text-white">

    <div class="flex flex-col gap-6 min-w-[400px]  p-6  rounded-lg bg-gray-950 bg-opacity-80">

        <h1 class="text-2xl font-bold text-center">Email verifikacija</h1>

        <!--Status message display-->
        @if(session()->has('status'))
        <p class='text-center font-bold mb-5 @if(session('status') == 'error') text-red-600 @else text-green-400 @endif'>{{session('status_msg')}}</p>
        @endif
        <!-- End status message -->
        <p class="md:text-xl">Potvrdite svoju email adresu. Poslali smo vam email sa linkom za potvrdu na "{{$email}}". Proverite svoj inbox i spam folder.</p>
        <p class="text-xs md:text-base text-center">Nije Vam stigao email? <a class="text-red-500 hover:text-yellow-500 underline" href="{{route('verify.show', [$id, $email])}}">Pošalji ponovo</a></p>
    </div>
</div>


<!--End login -->
@endsection
