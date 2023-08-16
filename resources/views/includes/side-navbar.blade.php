<div x-show="showNav"
     class="absolute md:relative flex flex-col h-full justify-around bg-slate-900 w-full md:w-72 items-center z-50"
     x-transition:enter="transition ease-in-out duration-500 transform"
     x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in-out duration-1000 transform" x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full">

    <!-- Close button -->
    <a x-on:click="showNav = false" class=" md:hidden absolute top-6 right-4 ">
    <i class="fa-solid fa-xmark fa-lg"></i>
    </a>
    <!-- End close button -->

    <!-- Logo -->
    <div class="flex items-center justify-center h-28">
        <a href="#">
            <img src="{{URL('images/logo-white.svg')}}" alt="Cinemanija logo" class="h-28">
        </a>
    </div>
    <!-- End logo -->
    <!-- Navigation -->
    <ul class="flex flex-col gap-8 text-white text-lg font-bold">
        @role('ADMIN')

        @elserole('MANAGER')
        <li>
            <a href="{{route('management.movies.index')}}" class="flex items-center gap-4">
                <i class="{{ Route::currentRouteName() === 'management.movies.index' ? 'fa-solid fa-play fa-2xs' : 'fa-solid fa-film' }}"></i>
                <p>Filmovi</p>
            </a>
        </li>

        <li>
            <a href="{{route('screenings.index')}}" class="flex items-center gap-4">
                <i class="{{ Route::currentRouteName() === 'screenings.index' ? 'fa-solid fa-play fa-2xs' : 'fa-solid fa-clapperboard' }}"></i>
                <p>Projekcije</p>
            </a>
        </li>

        <li>
            <a href="{{route('requests.index')}}" class="flex items-center gap-4">
                <i class="{{ Route::currentRouteName() === 'requests.index' ? 'fa-solid fa-play fa-2xs' : 'fa-solid fa-briefcase' }}"></i>
                <p>Zahtevi</p>
            </a>
        </li>

        <li>
            <a href="{{route('reports.create')}}" class="flex items-center gap-4">
                <i class="{{ Route::currentRouteName() === 'reports.index' ? 'fa-solid fa-play fa-2xs' : 'fa-solid fa-chart-pie' }}"></i>
                <p>Izveštaji</p>
            </a>
        </li>
        @endrole
    </ul>
    <!-- End Navigation -->

    <!-- Back button -->
    <a href="{{route('home')}}" class="flex gap-4 items-center justify-center">
        <i class="fa-solid fa-angles-left"></i>
        <p>Nazad na sajt</p>
    </a>
    <!-- End back button -->
</div>
