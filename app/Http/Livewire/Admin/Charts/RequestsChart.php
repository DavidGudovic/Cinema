<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Services\Reporting\RequestableService;
use App\Traits\ReportChartBuilder;
use Livewire\Component;

class RequestsChart extends Component
{
    use ReportChartBuilder;

    public function render(RequestableService $requestableService)
    {
        return view('livewire.admin.charts.requests-chart', [
            'chartModel' => $this->buildReportChart(
                title: 'Requests',
                service: $requestableService,
                chart_type: 'pie',
                animated: true,
                colors: ['Otkazan' => '#f44336', 'Na čekanju' => '#E91E63', 'Odbijen' => '#9C27B0', 'Prihvaćen' => '#673AB7'],
            ),
        ]);
    }
}
