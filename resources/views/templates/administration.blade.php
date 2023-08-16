<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="author" content="David Gudović">
    <meta name="description" content="Admin panel bioskopa">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>Administracija Cinemanija</title>
    <link rel="icon" href="{{URL('images/logo_cut-min.svg')}}">
    @yield('head-scripts')
    @vite('resources/js/app.js')
    @livewireStyles
</head>
<body x-data="{showNav: true}" class="flex antialiased h-screen bg-gray-950 text-white">

<!-- Open button -->
<button x-show="!showNav" x-on:click="showNav = true" class="fixed top-1 left-4 m-4 z-20">
    <i class="fa-solid fa-bars"></i>
</button>
<!-- End open button -->


<!--Side navbar-->
@include('includes.side-navbar')
<!--End side navbar-->

<!--Main content-->
<main class="flex flex-1">
    @yield('content')
</main>
<!--End main content-->

{{--Scripts--}}
@livewireChartsScripts
@livewireScripts
@yield('scripts')
{{--End scripts--}}
</body>
</html>
