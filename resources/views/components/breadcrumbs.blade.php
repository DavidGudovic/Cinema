<div {{ $attributes->merge(['class' => 'flex flex-col items-center']) }}>
	<!-- Step 1 -->
	<div x-on:click="step = 1" x-bind:class="step == 1 ? 'border-green-500' : (step > 1 ? 'cursor-pointer bg-green-500' : 'bg-transparent')"
	     class="flex justify-center items-center w-8 h-8 md:w-10 md:h-10 rounded-full border">
		<p class="text-xs md:text-base" x-html="step > 1 ? '&#10004;' : '1'"></p>
	</div>
	<!-- End step 1 -->

	<div x-bind:class="step > 1 ? 'bg-green-500' : 'bg-white' " class="w-[0.05rem] h-28"></div> <!-- Line -->

	<!-- Step 2-->
	<div x-on:click="step = step > 2 ? 2 : step" x-bind:class="step == 2 ? 'border-green-500' : (step > 2 ? 'cursor-pointer bg-green-500' : 'bg-transparent' ) "
	     class="flex justify-center items-center w-8 h-8 md:w-10 md:h-10 rounded-full border">
		<p class="text-xs md:text-base" x-html="step > 2 ? '&#10004;' : '2'"></p>
	</div>
	<!-- End step-2 -->

	<div x-bind:class="step > 2 ? 'bg-green-500' : 'bg-white' " class="w-[0.05rem] h-28"></div> <!-- Line -->

	<!-- Step 3 -->
	<div x-bind:class="step == 3 ? 'border-green-500' : (step > 3 ? 'bg-green-500' : 'bg-transparent') "
	     class="flex justify-center items-center w-8 h-8 md:w-10 md:h-10 rounded-full border">
		<p class="text-xs md:text-base" x-html="step > 3 ? '&#10004;' : '3'"></p>
	</div>
	<!-- End step 3 -->
</div>
