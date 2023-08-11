 <div class="flex flex-col w-full flex-1 gap-4 overflow-y-auto">

    <!-- Details -->
    <div class="flex flex-col md:flex-row md:justify-between border-b border-white ">
        <!-- Item -->
        <div class="flex flex-row gap-2 ">
            <span>Naslov reklame:</span>
            <span class="">{{$request->requestable->title}}</span>
        </div>

        <!-- End item -->

        <!-- Item -->
        <div class="flex flex-row gap-2">
            <span>Delatnost:</span>
            <span class="">{{$request->requestable->company}}</span>
        </div>
        <!-- End info-->

        <!-- End item -->

        <!-- Item -->
        <div class="flex flex-row gap-2">
            <span>Ukupno reklama:</span>
            <span class="">{{$request->requestable->quantity}}</span>
        </div>
    </div>
    <!-- End Details -->
    <!-- CHARTS -->
    <div class="w-full h-full md:h-72 flex-grow flex flex-col md:flex-row justify-around items-center">
        @if($request->status == 'accepted')
        <div class="h-64">
            <livewire:livewire-pie-chart :pie-chart-model="$pieChartModel" />
        </div>
        <div class="h-64 text-black">
            <livewire:livewire-line-chart :line-chart-model="$lineChartModel"/>
        </div>
        @else
        <p class="text-2xl font-extrabold text-center">Reklama se još ne prikazuje</p>
        @endif
    </div>
    <!-- END CHARTS -->

</div>
