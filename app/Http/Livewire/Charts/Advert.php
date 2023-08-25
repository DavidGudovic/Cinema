<?php

namespace App\Http\Livewire\Charts;

use Livewire\Component;
use App\Services\AdvertService;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use App\Models\Advert as AdvertModel;

class Advert extends Component
{
    public $advert;
    public $request;
    protected $lineChartModel;
    protected $pieChartModel;

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

    protected $listeners = [
        'refreshChart' => 'refreshChart',
    ];

    public function mount(){
        $this->refreshChart(new AdvertService(), $this->advert);
    }
    /**
    *  Livewire refuses to rerender the charts without this method, something about reactiveKeys, no documentation
    */
    public function refreshChart(AdvertService $advertService,AdvertModel $advert)
    {
        $this->advert = $advert;
        $this->lineChartModel = LivewireCharts::lineChartModel()
        ->setTitle('Pregledi po danima')
        ->setAnimated(false)
        ->setSmoothCurve()
        ->withGrid()
        ->setColors($this->colors);

        $this->pieChartModel = LivewireCharts::pieChartModel()
        ->setTitle('Procenat pregledanih')
        ->setAnimated(true)
        ->setType('pie')
        ->legendPositionBottom()
        ->legendHorizontallyAlignedCenter();

        foreach($advertService->getViewsByWeekMap($this->advert) as $date => $count) {
            $this->lineChartModel->addPoint($date, $count);
        }

        $adverts_scheduled = $advertService->getScheduledCount($this->advert);
        $adverts_shown = $this->advert->quantity - $this->advert->quantity_remaining - $adverts_scheduled;
        $this->pieChartModel
        ->addSlice('Pregledano', $adverts_shown, $this->colors['green'])
        ->addSlice('Zakazano', $adverts_scheduled , $this->colors['indigo'])
        ->addSlice('Nepregledano', $this->advert->quantity_remaining, $this->colors['red']);
    }

    public function render()
    {
        return view('livewire.charts.advert', [
            'lineChartModel' => $this->lineChartModel,
            'pieChartModel' => $this->pieChartModel,
        ]);
    }

}
