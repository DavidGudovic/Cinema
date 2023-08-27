<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Traits\ChartModelBuilder;
use Livewire\Component;

class BookingsChart extends Component
{
    use ChartModelBuilder;

    public function render()
    {
        return view('livewire.admin.charts.bookings-chart', [
            'chartModel' => $this->buildChartModel(
                title: 'Rentiranja',
                data: [
                    'Disabled' => 230,
                    'Enabled' => 430,
                    'Pending' => 210,
                    'Canceled' => 120,
                ],
                colors: [
                    '#10B981',
                    '#EF4444',
                    '#F59E0B',
                    '#3B82F6',
                ],
                chart_type: 'area',
                animated: true),
        ]);
    }

}
