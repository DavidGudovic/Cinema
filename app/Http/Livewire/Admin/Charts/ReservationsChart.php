<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Services\Reporting\TicketService;
use App\Traits\ReportChartBuilder;
use Livewire\Component;

class ReservationsChart extends Component
{
    use ReportChartBuilder;

    protected $listeners = [
        'setPeriod' => 'setPeriod',
        'setHall' => 'setHall',
    ];
    public function render(TicketService $ticketService)
    {
        return view('livewire.admin.charts.reservations-chart', [
            'chartModel' => $this->buildReportChart(
                title: 'Rezervacije',
                service: $ticketService,
                chart_type: 'multi-line',
            )
        ]);
    }
}
