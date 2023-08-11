<?php

namespace App\Http\Livewire\Users\Business\Requests;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\RequestableService;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Index extends Component
{
    use WithPagination;

    public $status_filter = "all";
    public $type_filter = 0;

    private $colors = [
        'green' => '#10B981',
        'red' => '#EF4444',
        'blue' => '#3B82F6',
        'yellow' => '#F59E0B',
        'purple' => '#8B5CF6',
        'pink' => '#EC4899',
        'indigo' => '#6366F1',
        'gray' => '#6B7280',
    ];

    public $listeners = [
        'setRequestFilters' => 'setRequestFilters',
        'cancelRequest' => 'cancelRequest',
        'RequestCancelled' => 'refresh'
    ];

    public function refresh()
    {
    }

    public function paginationView()
    {
        return 'pagination.custom';
    }

    public function render(RequestableService $requestableService)
    {
        $lineChartModel =LivewireCharts::lineChartModel()
        ->setTitle('Pregledi po danima')
        ->setAnimated(true)
        ->setSmoothCurve()
        ->withGrid()
        ->multiLine()
        ->addSeriesPoint("Eho Gneva", 1, 10, ['color' => $this->colors['green']])
        ->addSeriesPoint("Eho Gneva", 4, 40, ['color' => $this->colors['green']])
        ->addSeriesPoint("Dusko", 2, 20, ['color' => $this->colors['red']])
        ->addSeriesPoint("Dusko", 3, 30, ['color' => $this->colors['red']])
        ->setColors($this->colors);
        ;

        $pieChartModel = LivewireCharts::pieChartModel()
        ->setTitle('Procenat pregledanih')
        ->setAnimated(true)
        ->setType('pie')
        ->withOnSliceClickEvent('onSliceClick')
        ->legendPositionBottom()
        ->legendHorizontallyAlignedCenter()
        ->addSlice('Pregledano', 60, $this->colors['green'])
        ->addSlice('Zakazano', 30, $this->colors['indigo'])
        ->addSlice('Nepregledano', 40, $this->colors['red']);

        return view('livewire.users.business.requests.index', [
            'requests' => $requestableService->getFilteredRequestsPaginated($this->status_filter,$this->type_filter),
            'user' => auth()->user(),
            'lineChartModel' => $lineChartModel,
            'pieChartModel' => $pieChartModel,
        ]);
    }

    /*
    Applies status and type filter
    Filter passed by event raised outside of Livewire
    */
    public function setRequestFilters($status, $type): void
    {
        $this->status_filter = $status;
        $this->type_filter = $type;
        $this->resetPage();
    }

}
