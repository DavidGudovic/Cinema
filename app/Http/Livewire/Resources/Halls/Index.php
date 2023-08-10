<?php

namespace App\Http\Livewire\Resources\Halls;

use Livewire\Component;
use App\Services\HallService;
use Illuminate\Support\Carbon;

class Index extends Component
{
    //[Date => [Hall, Hall]..]
    public $halls_map = [];
    public $start_time;
    public $end_time;

    protected $listeners = [
        'refreshIndex' => '$refresh',
        'submit' => 'submit',
    ];

    public function render()
    {
        if(app()->environment('production')) setlocale(LC_TIME, 'sr_RS.UTF-8@latin'); else  setlocale(LC_TIME, 'sr_Latn_RS.UTF-8');
        return view('livewire.resources.halls.index');
    }

    public function submit($from_date, $start_time, $duration, HallService $hallService)
    {
        $this->start_time = Carbon::createFromFormat('H', $start_time)->format('H:i');
        $this->end_time = Carbon::createFromFormat('H',$start_time + $duration)->format('H:i');
        $start_datetime = Carbon::createFromFormat('Y-m-d', $from_date)->setTime(0,0)->addHours($start_time);
        $end_datetime = Carbon::createFromFormat('Y-m-d', $from_date)->setTime(0,0)->addHours($start_time)->addHours($duration);
        $this->halls_map = $hallService->getAvailableHallsForDateMap($start_datetime, $end_datetime, 7);
    }
}
