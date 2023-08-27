<?php

namespace App\Http\Livewire\Admin\Report;

use App\Enums\Period;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    public Collection $halls;

    public string $selected_period = 'WEEKLY';
    public int $selected_hall = 0;

    public function mount(Collection $halls)
    {
        $this->halls = $halls; //passed by Controller
    }

    public function render()
    {
        return view('livewire.admin.report.create', [
            'periods' => collect(Period::cases()),
        ]);
    }

    /**
     * Emits events to child components to sync selected state
     *
     * @return void
     */
    public function syncState() : void
    {
        $this->emit('setPeriod', $this->selected_period);
        $this->emit('setHall', $this->selected_hall);
    }
}
