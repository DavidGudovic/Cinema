
@extends('templates.app')

@section('content')
<!--Wrapper of profil-->
<div class=" min-h-screen">

    <h1 class="font-extrabold text-3xl text-center my-12 text-white" >Profil Korisnika</h1>

    <!-- Profile -->
    <div class="flex flex-col md:flex-row gap-6 justify-center w-full h-full px-10 md:px-36 mb-20">
        <!-- Side menus -->
        <div class="flex flex-col gap-6">
            <!-- Profile links -->
            <div class="mb-6 md:mb-0">
                <div class="flex flex-col border border-white text-white bg-gray-950 bg-opacity-75 px-8 md:w-72">
                    <a href="{{route('user.show', auth()->user())}}" class="py-7 border-b border-white font-bold text-xl">
                        <i class="{{ Route::currentRouteName() === 'user.show' ? 'fa-solid fa-play fa-2xs' : '' }}"></i>
                        Informacije
                    </a>
                    @role('CLIENT')
                    <a href="{{route('user.tickets.index', auth()->user())}}" class="py-7 border-b border-white font-bold text-xl">
                        <i class="{{ Route::currentRouteName() === 'user.tickets.index' ? 'fa-solid fa-play fa-2xs' : '' }}"></i>
                        Istorija karata
                    </a>
                    @elserole('BUSINESS_CLIENT')
                    <a href="{{route('user.requests.index', auth()->user())}}" class="py-7 border-b border-white font-bold text-xl">
                        <i class="{{ Route::currentRouteName() === 'user.requests.index' ? 'fa-solid fa-play fa-2xs' : '' }}"></i>
                        Istorija zahteva
                    </a>

                    <a href="{{route('user.reclamations.index', auth()->user())}}" class="py-7 border-b border-white font-bold text-xl">
                        <i class="{{ Route::currentRouteName() === 'user.reclamations.index' ? 'fa-solid fa-play fa-2xs' : '' }}"></i>
                        Reklamacije
                    </a>
                    @endrole
                    <a href="{{route('user.delete', auth()->user())}}" class="py-7 font-bold text-xl">
                        <i class="{{ Route::currentRouteName() === 'user.delete' ? 'fa-solid fa-play fa-2xs' : '' }}"></i>
                        Deaktivacija naloga
                    </a>
                </div>
            </div>
            <!-- End Links -->
            <!--Filters optional -->
            <div class="mb-6 md:mb-0">
                @yield('filters')
            </div>
            <!--End filters optional -->
        </div>
        <!-- End side menus -->

        <!-- Action window display -->
        <div class="flex-1">
            @yield('window')
        </div>
        <!-- End window -->
    </div>
    <!-- End profile -->
</div>
<!--End wrapper -->

@endsection
