<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="author" content="David Gudović">
    <meta name="description" content="Online bioskop">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>Biskop Cinemanija</title>
    <link rel="icon" href="{{URL('images/logo_cut-min.svg')}}">
    @yield('head-scripts')
    @vite('resources/js/app.js')
    @livewireStyles
</head>
<body class="flex flex-col antialiased min-h-screen bg-gray-950 text-white">
    <!--HEADER OPTIONAL-->
    @yield('header')
    <!--END HEADER-->
    <!--NAVBAR-->
    @include('includes.navbar')
    <!--END NAVBAR -->

    <!-- CONTENT - Injectable background-->
    <div class="flex flex-row flex-1 justify-center @yield('background-pattern')">
        <!-- MAIN CONTENT -->
        <main class="w-screen ">
            @yield('content')
        </main>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END CONTENT -->

    <!--FOOTER-->
    @include('includes.footer')
    <!--END FOOTER-->

    @auth
    <!-- MODALS -->

    <!-- Sidebars-->

    @role('CLIENT')
    <!-- User active tickets -->
    @livewire('users.tickets.index-side-bar')
    <!-- End user active tickets -->
    @endrole

    @role('BUSINESS_CLIENT')
    <!-- Business client active tickets -->
    @livewire('users.business.requests.index-side-bar')
    <!-- End business client active tickets -->
    @endrole

    <!-- End Sidebars -->

    <!-- Modal -->
    @yield('modal')
    <!-- End Modal -->

    <!-- END MODALS -->
    @endauth
    @role('BUSINESS_CLIENT')
    @if(Route::currentRouteName() != 'business.requests.index') <!-- Prevents loading charts on index page due to N+1 and the same info is displayed -->
    @livewireChartsScripts
    @endif
    @endrole
    @livewireScripts
    @yield('scripts')
</body>
</html>
