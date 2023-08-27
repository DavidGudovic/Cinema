<?php

namespace App\Http\Livewire\Admin\Charts;

use App\Enums\Periods;
use App\Services\AdvertService;
use App\Traits\ChartModelBuilder;
use Asantibanez\LivewireCharts\Models\BaseChartModel;
use Livewire\Component;

class AdvertsChart extends Component
{
    use ChartModelBuilder;
    public Periods $period;
    public int $hall_id;

    protected $listeners = [
        'setPeriod' => 'setPeriod',
        'setHall' => 'setHall',
    ];

    public function render(AdvertService $advertService)
    {
        return view('livewire.admin.charts.adverts-chart', [
            'chartModel' => $this->buildAdvertsChart($advertService),
        ]);
    }

    public function buildAdvertsChart(AdvertService $advertService) : BaseChartModel
    {
        return $this->buildChartModel(
            title: 'Oglašavanje',
            data: $this->getData($advertService),
            colors: ['#f6ad55', '#fc8181', '#90cdf4', '#48bb78', '#9f7aea', '#ed64a6', '#f56565', '#68d391', '#4299e1', '#ed8936', '#edf2f7', '#cbd5e0', '#a0aec0', '#718096', '#4a5568', '#2d3748', '#1a202c'],
            chart_type: 'area',
            animated: true,
        );
    }

    public function getData(AdvertService $advertService) : array
    {
        $data = $advertService->getAdvertsCountByPeriod($this->period, $this->hall_id);
        return $data->map(function ($item, $key) {
            $item->date = $item->date->format($this->getDataFormat($this->period));
            return $item;
        });
    }

    public function getDataFormat(Periods $periods)
    {
        return match($periods) {
            Periods::YEARLY => 'm',
            Periods::MONTHLY, Periods::WEEKLY => 'd',
        };
    }

}
