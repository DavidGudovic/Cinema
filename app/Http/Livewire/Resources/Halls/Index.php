<?php

namespace App\Http\Livewire\Resources\Halls;

use Livewire\Component;
use App\Services\HallService;
use Illuminate\Support\Carbon;

class Index extends Component
{
    //[Date => [Hall, Hall]..]
    public $halls_map = [];

    protected $listeners = [
        'refreshIndex' => '$refresh',
        'submit' => 'submit',
    ];

    public function mount()
    {

    }

    public function render()
    {
              setlocale(LC_TIME, 'sr_Latn_RS.UTF-8');
        return view('livewire.resources.halls.index');
    }

    public function submit($from_date, $start_time, $duration, HallService $hallService)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $from_date)->setTime(0,0)->addHours($start_time);
        $end_date = Carbon::createFromFormat('Y-m-d', $from_date)->setTime(0,0)->addHours($start_time)->addHours($duration);
        $this->halls_map = $hallService->getAvailableDatesMap($start_date, $end_date, 7);
    }
}
