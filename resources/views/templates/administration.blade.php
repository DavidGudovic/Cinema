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
	@vite('resources/js/app.js')
	@livewireStyles
</head>
<body class="antialiased text-white bg-gray-950">

<div x-data="{showNav: false}" x-breakpoint="if($isBreakpoint('md+')) showNav = true" class="flex">
	<button x-transition:enter="transition ease-in duration-500"
	        x-transition:enter-start="opacity-0"
	        x-transition:enter-end="opacity-100"
	        x-transition:leave="transition ease-in duration-60000"
	        x-transition:leave-start="opacity-100"
	        x-transition:leave-end="opacity-0"
	        x-show="!showNav"
	        x-on:click="showNav = true" class="fixed top-1 left-2 m-4 z-20">
		<i class="fa-solid fa-bars"></i>
	</button>
	<aside x-show="showNav" class="h-screen fixed w-screen md:w-auto md:sticky top-0 z-50">
		@include('includes.side-navbar')
	</aside>

	<main class="flex flex-col flex-1 items-center w-full bg-gray-950 gap-12 md:px-8 py-6">
		@yield('content')
	</main>
</div>

{{--Scripts--}}
@livewireScripts
@yield('scripts')
{{--End scripts--}}
</body>
</html>
