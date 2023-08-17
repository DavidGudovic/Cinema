<nav x-data="{showNavbar: false}" x-breakpoint="if($isBreakpoint('md+')) showNavbar = true"
     class="sticky w-full top-0 bg-gray-950 bg-opacity-60 hover:bg-opacity-100 hover:border-b hover:border-white text-white z-50 p-4 min-h-[2rem] md:h-auto ">
    <!-- Hamburger -->
    <button class="md:hidden fixed -top-1 right-6 pt-2 z-50" type="button" x-on:click="showNavbar = !showNavbar">
        <i class="fa-solid fa-bars fa-lg" :class="{'rotate-90 inline-block': showNavbar}"></i>
    </button>
    <!-- End Hamburger -->
    <ul x-cloak x-show="showNavbar"
        class="flex flex-col justify-center gap-6 text-lg md:text-base md:gap-0 md:flex-row md:justify-around items-center">

        <div class="flex-1 flex justify-center items-center">
            <li class=""><a class="hover:underline" href="{{route('home')}}">Početna</a></li>
        </div>

        <div class="flex-1 flex justify-center items-center">
            @guest
                <li class=""><a class="hover:text-red-600 cursor-pointer hover:underline"
                                href="{{route('movies.index')}}">Repertoar</a></li>
            @endguest
            @role('CLIENT')
            <li class=""><a class="hover:text-red-600 cursor-pointer hover:underline" href="{{route('movies.index')}}">Repertoar</a>
            </li>
            @elserole('BUSINESS_CLIENT')
            <!-- Business dropdown -->
            <div class="flex-1 flex justify-center items-center">
                <div x-data="{ business_open: false }" x-on:click.outside="business_open = false">
                    <button x-on:click="business_open = !business_open"
                            class="hover:text-red-500 cursor-pointer hover:underline">
                        Biznis <i class="fa-solid fa-caret-down"
                                  :class="{'rotate-180 inline-block': business_open}"></i>
                    </button>
                    <!-- hidden menu -->
                    <ul class="absolute flex flex-col gap-4 rounded-lg bg-gray-950 md:bg-opacity-60 hover:bg-opacity-100 hover:border hover:border-white text-white  p-4 mt-4 "
                        x-cloak x-show="business_open" x-transition.opacity>
                        <li><a class="hover:text-red-600 cursor-pointer hover:underline"
                               href="{{route('halls.index')}}">Rentiranje</a></li>
                        <li><a class="hover:text-red-600 cursor-pointer hover:underline"
                               href="{{route('adverts.create')}}">Oglašavanje</a></li>
                    </ul>
                    <!-- end hidden menu -->
                </div>
            </div>
            <!-- End Business dropdown -->
            @elserole('MANAGER')
                <li class=""><a class="hover:text-red-600 cursor-pointer hover:underline" href="{{route('movies.index')}}">Repertoar</a>
                </li>
            @endrole
        </div>

        <div class="flex-1 hidden md:flex justify-center items-center">
            <li class="flex items-center">
                <svg version="1.0" class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 249 251">
                    <path
                        d="M111.5 8.1C85.9 11 58.4 25 40.1 44.6 17.9 68.4 6.8 98.3 8.3 129.8c1.6 31.8 13.8 58.6 36.3 80.2 9 8.7 15.2 13.3 24.4 18.3 18.8 10.4 35.8 14.7 57.5 14.7 30.8.1 58.7-11.1 81.6-32.7 7.2-6.8 15.8-17.7 20.3-25.4l2.7-4.7-11.3-6.5c-6.2-3.6-20.7-11.9-32.2-18.6-11.6-6.7-21.2-12.1-21.5-12.1-.3.1-2.2 2.6-4.1 5.6-14.5 23-48.6 25.8-67.1 5.6-16-17.5-15.6-42.7 1-59.2 13-12.9 31.9-16.3 48.6-8.6 6.2 2.8 16.2 11.8 19.1 17.1 1 1.9 2.2 3.5 2.6 3.5 1 0 61.9-34.9 63.5-36.4 2.8-2.6-15.5-26.1-28.2-36.2-26.7-21.5-56-30-90-26.3zM143 16c9 1.3 17.5 3.9 16.3 5.1-.5.5-12 .8-27.9.7l-26.9-.3-.3-2.3c-.4-2.8.3-3 11.3-4 9.4-.9 16.5-.7 27.5.8zM96 51.5v32.4l-6.5 6.6-6.5 6.6V60.6c0-27.7.3-36.7 1.2-37.3 1.3-.8 9.8-4.1 11.1-4.2.4-.1.7 14.5.7 32.4zm82.5-23.7 5 2.7v57.9l-5.4 3.2c-3 1.8-5.8 3.1-6.3 2.8-.4-.3-.8-16-.8-35 0-26.9.3-34.4 1.3-34.4.6 0 3.5 1.3 6.2 2.8zM75.1 29.2c0 .9 0 166-.1 192 0 1.5-2 .8-7-2.3l-5-3.1V34.5l5.2-3.3c5.8-3.5 6.8-3.8 6.9-2zm88.4 6.3v6l-29.7.3-29.8.2V29l29.8.2 29.7.3v6zm35.5 6.6 6.1 5-.3 14.6-.3 14.7-5.5 3.3c-3 1.8-5.8 3.3-6.2 3.3-.5 0-.8-10.4-.8-23 0-12.7.2-23 .4-23 .3 0 3.2 2.3 6.6 5.1zM54.8 56.2l-.3 6.3-9.2.3c-5.1.1-9.3-.1-9.3-.5s2-3.4 4.5-6.6c4.4-5.6 4.6-5.7 9.6-5.7h5l-.3 6.2zm108.7.3v6l-29.7.3-29.8.2V50l29.8.2 29.7.3v6zm53.9 6c1.5 2.5 2.7 4.7 2.5 4.9-2.1 1.6-5.5 3.6-6.1 3.6-.5 0-.8-2.9-.8-6.5s.3-6.5.8-6.5c.4 0 2 2 3.6 4.5zM54.8 76.7l.3 6.2-14.2.3c-7.7.2-14.6 0-15.2-.4-.8-.5-.6-1.8.7-4.5 4.1-8.8 3.3-8.4 16.4-8.1l11.7.3.3 6.2zm108.6-5.1c.9 2.3.7 17.4-.2 17.4-.4 0-3.3-1.9-6.4-4.3-13.6-10.1-31-13-46.7-7.6-3 1.1-5.6 1.9-5.8 1.9-.1 0-.3-2-.3-4.5V70h29.4c25.9 0 29.5.2 30 1.6zM54.5 97.5v6l-18.4.3-18.3.2.6-2.7c.4-1.6 1.2-4.5 1.7-6.6l1-3.7 16.7.2 16.7.3v6zm.3 20.7-.3 6.3h-38l-.3-4.9c-.5-8-1.6-7.6 19.8-7.6h19.1l-.3 6.2zM50.6 133H55v5.9c0 4.4-.4 6-1.6 6.5-3.2 1.2-32.9.7-34.6-.7-.9-.6-1.9-3.5-2.3-6.4l-.7-5.2 13.9-.3c7.6-.2 14.4-.2 15.1-.1.8.2 3.4.3 5.8.3zm3.9 26.5v6l-15.3.3-15.3.3-1.5-3.6c-.8-2-1.7-4.9-2.1-6.6l-.6-2.9 17.4.2 17.4.3v6zm35.5.7 6 6.2v32.3c0 20-.4 32.3-1 32.3-.5 0-3.4-.9-6.5-2.1l-5.5-2v-36.5c0-20 .2-36.4.5-36.4.2 0 3.1 2.8 6.5 6.2zm93.5 30.3v28.9l-5.7 3.2c-3.1 1.8-5.9 2.9-6.2 2.6-.8-.7-.8-68.7 0-69.4.3-.3 3.1.8 6.2 2.6l5.7 3.2v28.9zm-19.8-26.1c-.4.9-1.6 1.6-2.7 1.6-2.4 0-2.5-.8-.3-3.2 1.9-2.1 4-.9 3 1.6zm35.2 6.1 6.1 3.6V202.8l-5.7 5.1c-3.1 2.8-6.1 5.1-6.5 5.1-.4 0-.8-10.4-.8-23 0-12.7.2-23 .4-23 .3 0 3.2 1.6 6.5 3.5zm-144.1 9.7-.3 6.3h-20l-3.2-5c-1.8-2.7-3.3-5.5-3.3-6.2 0-1 3.3-1.3 13.5-1.3h13.6l-.3 6.2zm73.2-5c5.8-.2 16.1-.4 23-.5l12.5-.2v12l-29.7.3-29.8.2v-13.3l6.8.9c3.7.5 11.4.7 17.2.6zm91.5 7.8c.6 1-4.4 8.9-5.7 9-.5 0-.8-2.9-.8-6.5v-6.6l2.9 1.6c1.7.8 3.3 1.9 3.6 2.5zM55 201.5c0 3.6-.4 6.5-.8 6.5s-3.7-2.9-7.2-6.5l-6.4-6.5H55v6.5zm108.8-.8-.3 5.8-29.7.3-29.8.2v-12h60.1l-.3 5.7zm-.3 20.8v6l-29.7.3-29.8.2v-13l29.8.2 29.7.3v6z"/>
                </svg>
            </li>
        </div>

        @guest

            <div class="flex-1 flex justify-center items-center">
                <li class=""><a href="{{ route('login.create') }}">Prijava</a></li>
            </div>
            <div class="flex-1 flex justify-center items-center">
                <li class=""><a href="{{ route('register.create') }}">Registracija</a></li>
            </div>

        @else

            <div x-data="{}" class="flex-1 flex justify-center items-center">
                @role('CLIENT')
                <li class=""><a class="hover:underline" x-data="{}" x-on:click="window.livewire.emit('showSideBar')">Rezervacije</a>
                </li>
                @elserole('BUSINESS_CLIENT')
                <li class="relative">
                    @if(Route::currentRouteName() === 'user.requests.index')
                        <a x-data="{}" x-on:click.prevent class="hover:text-white cursor-default opacity-70">Zahtevi</a>
                    @else
                        <a x-data="{}" x-on:click="window.livewire.emit('showSideBar')">Zahtevi</a>
                    @endif
                </li>
                @elserole('MANAGER')
                <div class="flex-1 flex justify-center items-center">
                    <li class=""><a href="{{ route('management.movies.index') }}">Menadžment</a></li>
                </div>
                @endrole
            </div>

            <!-- Profile dropdown -->
            <div class="flex-1 flex justify-center items-center">
                <div x-data="{ open: false }" x-on:click.outside="open = false">
                    <button x-on:click="open = !open" class="hover:text-red-500 cursor-pointer hover:underline">
                        Profil <i class="fa-solid fa-caret-down" :class="{'rotate-180 inline-block': open}"></i>
                    </button>
                    <!-- hidden menu -->
                    <ul class="absolute flex flex-col gap-4 rounded-lg bg-gray-950 md:bg-opacity-60 hover:bg-opacity-100 hover:border hover:border-white text-white  p-4 mt-4 "
                        x-cloak x-show="open" x-transition.opacity>
                        <li><a class="hover:text-red-600 cursor-pointer hover:underline"
                               href="{{route('user.show', auth()->user())}}">Informacije</a></li>
                        @role('CLIENT')
                        <li><a class="hover:text-red-600 cursor-pointer hover:underline"
                               href="{{route('user.tickets.index', auth()->user())}}">Istorija karata</a></li>
                        @elserole('BUSINESS_CLIENT')
                        <li><a class="hover:text-red-600 cursor-pointer hover:underline"
                               href="{{route('user.requests.index', auth()->user())}}">Istorija zahteva</a></li>
                        <li><a class="hover:text-red-600 cursor-pointer hover:underline"
                               href="{{route('user.reclamations.index', auth()->user())}}">Reklamacije</a></li>
                        @endrole
                        <li><a class="hover:text-red-600 cursor-pointer hover:underline"
                               href="{{route('logout', auth()->user())}}">Odjava</a></li>
                    </ul>
                    <!-- end hidden menu -->
                </div>
            </div>
            <!-- End profile dropdown -->
        @endguest
    </ul>

</nav>

