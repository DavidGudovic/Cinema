<div class="w-full h-full md:h-72 flex-grow flex flex-col md:flex-row justify-around items-center">
    @if($request->status == 'ACCEPTED')
    <div class="h-64">
        <livewire:livewire-pie-chart key="{{$pieChartModel->reactiveKey()}}" :pie-chart-model="$pieChartModel" />
    </div>
    <div class="h-64 text-black">
        <livewire:livewire-line-chart key="{{ $lineChartModel->reactiveKey()}}" :line-chart-model="$lineChartModel"/>
    </div>
    @else
    <p class="text-2xl font-extrabold text-center">Reklama se još ne prikazuje</p>
    @endif
</div>
