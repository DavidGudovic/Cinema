<?php

namespace App\Http\Livewire\Charts;

use App\Traits\ChartModelBuilder;
use Livewire\Component;
use App\Services\AdvertService;
use App\Models\Advert as AdvertModel;

class Advert extends Component
{
    use ChartModelBuilder;

    public $advert;
    public $request;
    protected $lineChartModel;
    protected $pieChartModel;

    private $colors = [
        'green' => '#10B981',
        'red' => '#EF4444',
        'blue' => '#3B82F6',
        'yellow' => '#F59E0B',
        'purple' => '#8B5CF6',
        'pink' => '#EC4899',
        'indigo' => '#6366F1',
        'gray' => '#6B7280',
    ];

    protected $listeners = [
        'refreshChart' => 'refreshChart',
    ];

    public function mount(AdvertService $advertService){
        $this->refreshChart($advertService, $this->advert);
    }

    public function render()
    {
        return view('livewire.charts.advert', [
            'lineChartModel' => $this->lineChartModel,
            'pieChartModel' => $this->pieChartModel,
        ]);
    }

    /**
     *  Fix for reactivity with nested livewire components, whenever the parent component changes it emits refreshChart, handled here
     */
    public function refreshChart(AdvertService $advertService,AdvertModel $advert): void
    {
        $this->advert = $advert;

        $this->lineChartModel = $this->buildChartModel(
            title: 'Pregledi po danima',
            data: $advertService->getViewsByWeekMap($this->advert),
            colors: $this->colors,
            chart_type: 'line',
        );

        $this->pieChartModel = $this->buildChartModel(
            title: 'Procenat pregledanih',
            data: $this->getPieData($advertService),
            colors: ['Pregledano' => $this->colors['green'], 'Zakazano' => $this->colors['indigo'], 'Nepregledano' => $this->colors['red']],
            chart_type: 'pie',
            animated: true,
        );
    }

    public function getPieData(AdvertService $advertService) : array
    {
        $adverts_scheduled = $advertService->getScheduledCount($this->advert);
        $adverts_shown = $this->advert->quantity - $this->advert->quantity_remaining - $adverts_scheduled;

        return [
            'Pregledano' => $adverts_shown,
            'Zakazano' => $adverts_scheduled,
            'Nepregledano' => $this->advert->quantity_remaining,
        ];
    }

}
