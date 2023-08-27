<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Services\Reporting\BookingService;
use App\Traits\ReportChartBuilder;
use Livewire\Component;

class BookingsChart extends Component
{
    use ReportChartBuilder;

    protected $listeners = [
        'setPeriod' => 'setPeriod',
        'setHall' => 'setHall',
    ];
    public function render(BookingService $bookingService)
    {
        return view('livewire.admin.charts.bookings-chart', [
            'chartModel' => $this->buildReportChart(
                title: 'Rentiranja',
                service: $bookingService,
                chart_type: 'area',
                animated: true,
            )
        ]);
    }

}
