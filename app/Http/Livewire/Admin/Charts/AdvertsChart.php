<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Enums\Periods;
use App\Services\Resources\AdvertService;
use App\Traits\ChartModelBuilder;
use App\Traits\ColorPalette;
use App\Traits\ReportChartBuilder;
use Asantibanez\LivewireCharts\Models\BaseChartModel;
use Livewire\Component;

class AdvertsChart extends Component
{
    use ReportChartBuilder;

    protected $listeners = [
        'setPeriod' => 'setPeriod',
        'setHall' => 'setHall',
    ];

    public function render(AdvertService $advertService)
    {
        return view('livewire.admin.charts.adverts-chart', [
            'chartModel' => $this->buildReportChart(
                title: 'Oglašavanje',
                service: $advertService,
                colors: null,
                chart_type: 'area',
                animated: true
            )
        ]);
    }
}
