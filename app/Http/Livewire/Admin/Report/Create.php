<?php

namespace App\Http\Livewire\Admin\Report;

use App\Enums\Periods;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    public Collection $halls;

    public function mount(Collection $halls)
    {
        $this->halls = $halls;
        $this->setPeriod(Periods::WEEKLY);
        $this->setHall(0);
    }

    public function render()
    {
        return view('livewire.admin.report.create');
    }

    /************* Both of these methods are used to set variables on the nested chart components *************/
    public function setPeriod(Periods $period) : void
    {
        $this->emit('setPeriod', $period);
    }

    public function setHall(int $hall_id) : void
    {
        $this->emit('setHall', $hall_id);
    }
}
