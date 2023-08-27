<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Traits\ChartModelBuilder;
use Livewire\Component;

class ReservationsChart extends Component
{
    use ChartModelBuilder;

    public function render()
    {
        return view('livewire.admin.charts.reservations-chart',[
        'chartModel' => $this->buildChartModel(
            title: 'Rezervacije',
            data: [
                'Cancelled' => [
                    'Jan' => 10,
                    'Feb' => 20,
                    'Mar' => 30,
                    'Apr' => 40,
                    'May' => 20,
                    'Jun' => 30,
                    'Jul' => 40,
                    'Aug' => 20,
                    'Sep' => 30,
                    'Oct' => 40,
                    'Nov' => 20,
                    'Dec' => 30,
                    ],
                'Accepted' => [
                    'Jan' => 120,
                    'Feb' => 110,
                    'Mar' => 100,
                    'Apr' => 230,
                    'May' => 220,
                    'Jun' => 210,
                    'Jul' => 200,
                    'Aug' => 190,
                    'Sep' => 280,
                    'Oct' => 270,
                    'Nov' => 260,
                    'Dec' => 250,
                    ],
                ],
            colors: ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#009688', '#4CAF50', '#FFC107', '#FF9800'],
            chart_type: 'multi-line',
        ),
        ]);
    }
}
