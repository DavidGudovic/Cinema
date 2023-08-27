<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Traits\ChartModelBuilder;
use Livewire\Component;

class RequestsChart extends Component
{
    use ChartModelBuilder;

    public function render()
    {
        return view('livewire.admin.charts.requests-chart', [
            'chartModel' => $this->buildChartModel(
                title: 'Requests',
                data: [
                    'Prihvacen' => 10,
                    'Odbijen' => 20,
                    'Na cekanju' => 30,
                    'Otkazan' => 40,
                    ],
                colors: ['Otkazan' => '#f44336', 'Na cekanju' => '#E91E63', 'Odbijen' => '#9C27B0', 'Prihvacen' => '#673AB7'],
                chart_type: 'pie',
                animated: true,
            ),
        ]);
    }
}
