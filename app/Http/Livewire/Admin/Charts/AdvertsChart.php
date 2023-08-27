<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Services\Reporting\AdvertService;
use App\Traits\Reporting\ReportChartBuilder;
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
                chart_type: 'area',
                animated: true,
            )
        ]);
    }
}
