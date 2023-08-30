<div x-transition:enter="transition ease-out-in duration-700 transform"
     x-transition:enter-start="translate-y-full"
     x-transition:enter-end="-translate-y-0"
     x-cloak x-show="step == {{ $step }}"
		{{ $attributes->class(['flex justify-center items-center w-full h-full']) }}>
        {{ $slot }}
</div>
