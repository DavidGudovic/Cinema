<?php

namespace App\Http\Livewire\Admin\Report;

use App\Enums\Period;
use App\Services\Resources\ReportService;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    public Collection $halls;

    public string $selected_period = 'YEARLY';
    public int $selected_hall;

    public string $text = '';

    public function mount(Collection $halls)
    {
        $this->halls = $halls; //passed by Controller
        $this->selected_hall = $this->halls->first()->id;
    }

    public function render(ReportService $reportService)
    {
        return view('livewire.admin.report.create', [
            'periods' => collect(Period::cases()),
            'already_exists' => $reportService->checkIfReportExists($this->selected_period, $this->selected_hall)
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

    /**
     *
     * @return void
     */
    public function submit(ReportService $reportService) : void
    {
        $this->validate([
            'text' => 'required|string|min:10|max:1000',
        ]);

        //$reportService->generateReport($this->selected_period, $this->selected_hall, $this->text);
    }
}
