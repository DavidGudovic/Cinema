<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Services\Reporting\RequestableService;
use App\Traits\Reporting\ReportChartBuilder;
use Livewire\Component;

class RequestsChart extends Component
{
    use ReportChartBuilder;

    protected $listeners = [
        'setPeriod' => 'setPeriod',
        'setHall' => 'setHall',
    ];

    public function render(RequestableService $requestableService)
    {
        return view('livewire.admin.charts.requests-chart', [
            'chartModel' => $this->buildReportChart(
                title: 'Zahtevi',
                service: $requestableService,
                chart_type: 'pie',
                animated: true,
                colors: [
                    'Otkazan' => $this->colors['yellow'],
                    'Na čekanju' => $this->colors['red'],
                    'Odbijen' => $this->colors['blue'],
                    'Prihvaćen' => $this->colors['green']
                ],
            ),
        ]);
    }
}
