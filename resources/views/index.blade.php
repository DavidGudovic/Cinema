@extends('templates/app')

@section('content')
<div class="flex flex-col items-center w-full h-full">
    <!-- Movie showcase -->
    <div class=" relative bg-orange-900 p-4 w-full h-86 overflow-hidden ">
        <img src="{{URL('images/oppenheimer.jpg')}}" alt="Movie Poster" class="w-full h-auto">
        <div class="absolute inset-0 bg-orange-200 w-full h-full bg-opacity-30 flex flex-col items-center justify-center">
            <!-- Movie details and button-->
            <h1 class="text-4xl text-white font-bold">Movie Showcase section</h1>
        </div>
    </div>
    <!-- END Movie showcase -->
    <div class="flex justify-around my-5 px-5 w-full bg-slate-600">
        <img src="https://via.placeholder.com/100" alt="Placeholder Image">
        <img src="https://via.placeholder.com/100" alt="Placeholder Image">
        <img src="https://via.placeholder.com/100" alt="Placeholder Image">
        <img src="https://via.placeholder.com/100" alt="Placeholder Image">
    </div>
    <h1 class="text-4xl text-white font-bold mt-2 mb-6">Žanrovi</h1>
    <!-- Genre Showcase -->
    <div class="flex flex-row justify-around w-full">
        <div class="flex flex-col items-center w-1/3">
            <img src="https://via.placeholder.com/100" alt="Placeholder Image">
            <h1 class="text-2xl text-white font-bold">Akcija</h1>
        </div>
        <div class="flex flex-col items-center w-1/3">
            <img src="https://via.placeholder.com/100" alt="Placeholder Image">
            <h1 class="text-2xl text-white font-bold">Akcija</h1>
        </div>
        <div class="flex flex-col items-center w-1/3">
            <img src="https://via.placeholder.com/100" alt="Placeholder Image">
            <h1 class="text-2xl text-white font-bold">Akcija</h1>
        </div>
    </div>
    <div class="flex flex-row justify-around w-full">
        <div class="flex flex-col items-center w-1/3">
            <img src="https://via.placeholder.com/100" alt="Placeholder Image">
            <h1 class="text-2xl text-white font-bold">Akcija</h1>
        </div>
        <div class="flex flex-col items-center w-1/3">
            <img src="https://via.placeholder.com/100" alt="Placeholder Image">
            <h1 class="text-2xl text-white font-bold">Akcija</h1>
        </div>
        <div class="flex flex-col items-center w-1/3">
            <img src="https://via.placeholder.com/100" alt="Placeholder Image">
            <h1 class="text-2xl text-white font-bold">Akcija</h1>
        </div>
    </div>
    <div class="flex flex-row justify-around w-full">
        <div class="flex flex-col items-center w-1/3">
            <img src="https://via.placeholder.com/100" alt="Placeholder Image">
            <h1 class="text-2xl text-white font-bold">Akcija</h1>
        </div>
        <div class="flex flex-col items-center w-1/3">
            <img src="https://via.placeholder.com/100" alt="Placeholder Image">
            <h1 class="text-2xl text-white font-bold">Akcija</h1>
        </div>
        <div class="flex flex-col items-center w-1/3">
            <img src="https://via.placeholder.com/100" alt="Placeholder Image">
            <h1 class="text-2xl text-white font-bold">Akcija</h1>
        </div>
    </div>
    <!-- END Genre Showcase -->
    <h1 class="text-4xl text-white font-bold mt-4 mb-6">Biznis</h1>
    <!-- Business showcase -->
    <div class="flex flex-col p-4 gap-4 w-full">
        <!-- Business counter -->
        <div class="bg-slate-500 flex gap-6 justify-around p-2">
            <h1 class="text-3xl">10000+ Pregleda reklama</h1>
            <h1 class="text-3xl">1000+ Privatnih projekcija</h1>
            <h1 class="text-3xl">100+ Zadovoljnih musterija</h1>
        </div>
        <!--End business counter -->
        <!-- Call to action -->
        <div class="bg-slate-500 flex flex-col items-center justify-center">
            <h1 class="text-4xl text-white font-bold">Želite da se reklamirate?</h1>
            <h1 class="text-2xl text-white font-bold">Kontaktirajte nas</h1>
            <button class="bg-orange-900 text-white font-bold py-2 px-4 rounded-full">Kontakt</button>
        </div>

    </div>
    <!-- END Business showcase -->

</div>
@endsection
