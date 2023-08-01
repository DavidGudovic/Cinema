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
    @vite('resources/js/app.js')
    @livewireStyles
</head>
<body class="bg-gray-950">
    <div class="flex align-center justify-center w-full h-screen bg-error md:bg-phone-error bg-cover bg-no-repeat">
        <a class="fixed top-4 left-2 z-10 text-white text-xl underline" href="{{route('home')}}"> << Pocetna </a>
        <div class="flex flex-col items-center justify-center w-full h-full bg-black bg-opacity-50">
            <div class="flex flex-col flex-1 items-center justify-center">
                <h1 class="text-4xl font-bold text-red-500">Greška @yield('heading')</h1>
                <h2 class="text-2xl font-bold text-white">@yield('text')</h2>
            </div>
            <div class="h-2/5"></div>
        </div>
    </div>
</body>
</html>
