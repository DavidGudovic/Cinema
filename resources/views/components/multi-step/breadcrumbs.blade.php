<div {{ $attributes->merge(['class' => 'flex flex-col items-center']) }}>
    <template x-for="i in totalSteps" :key="i">
        <!-- Container for Step and Line -->
        <div>
            <!-- Step -->
            <div x-on:click="if (step > i) window.livewire.emit('backtrack', i)"
                 x-bind:class="step == i ? 'border-green-500' : (step > i ? 'cursor-pointer bg-green-500' : 'bg-transparent')"
                 class="flex justify-center items-center w-8 h-8 md:w-10 md:h-10 rounded-full border">
                <p class="text-xs md:text-base" x-html="step > i ? '&#10004;' : i"></p>
            </div>
            <!-- End Step -->

            <!-- Line (except for the last step) -->
            <template x-if="i != totalSteps">
                <div x-bind:class="step > i ? 'bg-green-500' : 'bg-white'" class="m-auto w-[0.05rem] h-28"></div>
            </template>
        </div>
    </template>
</div>
