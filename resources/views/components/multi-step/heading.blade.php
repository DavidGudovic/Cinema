<p x-transition:enter="transition ease-out-in duration-700 transform"
   x-transition:enter-start="-translate-y-[150%]"
   x-transition:enter-end="translate-y-0" x-cloak
   x-show="step == {{$step}}" {{ $attributes->class(['h-full text-2xl font-bold']) }}>
	{{$slot}}
</p>
