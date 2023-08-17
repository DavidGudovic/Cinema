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
<body class="antialiased bg-gray-950 text-white">

<div x-data="{showNav: false}" x-breakpoint="if($isBreakpoint('md+')) showNav = true" class="flex gap-12">
	<aside class="h-screen fixed w-full md:w-auto md:sticky top-0">
		<button x-show="!showNav" x-on:click="showNav = true" class="fixed top-1 left-4 m-4 z-20">
			<i class="fa-solid fa-bars"></i>
		</button>
		@include('includes.side-navbar')
	</aside>

	<main>
		@yield('content')
	</main>
</div>



{{--Scripts--}}
@livewireChartsScripts
@livewireScripts
@yield('scripts')
{{--End scripts--}}
</body>
</html>
