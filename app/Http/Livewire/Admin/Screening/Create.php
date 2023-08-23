<?php

namespace App\Http\Livewire\Admin\Screening;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\Tag;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    public Movie $movie;
    public Collection $halls;
    public Collection $tags;
    public int $step = 3;

    public ?Hall $picked_hall;
    public ?Tag $picked_tag;
    public array $picked_dates = [];
    public array $picked_times = [];

    protected $listeners = [
        'backtrack' => 'backtrack',
    ];

    public function render()
    {
        return view('livewire.admin.screening.create');
    }

    public function setHall(Hall $picked_hall)
    {
        $this->picked_hall = $picked_hall;
        $this->step++;
    }

    public function setTag(Tag $picked_tag)
    {
        $this->picked_tag = $picked_tag;
        $this->step++;
    }

    public function backtrack(int $step)
    {
        $actions = [
            3 => function() { $this->picked_dates = []; $this->picked_times = []; $this->emit('clearDates'); },
            2 => function() { $this->picked_tag = null; },
            1 => function() { $this->picked_hall = null; },
        ];

        foreach ($actions as $actionStep => $action) {
            if ($step <= $actionStep) {
                $action();
            }
        }

        $this->step = $step;
    }

}
