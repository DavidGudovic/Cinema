<?php

namespace App\Http\Livewire\Admin\Report;

use App\Enums\Period;
use App\Services\Resources\ReportService;
use App\Services\UploadService;
use Illuminate\Support\Collection;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
            'already_exists' => $reportService->checkIfReportExists(Period::from($this->selected_period), $this->selected_hall)
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
     * Validates and generates a report
     * flashes a message to session and calls streamDownload
     *
     * @param ReportService $reportService
     * @return StreamedResponse
     */
    public function submit(ReportService $reportService) : StreamedResponse
    {
        $this->validate([
            'text' => 'required|string|min:10|max:1000',
        ]);

        $pdf = $reportService->generateReport(Period::from($this->selected_period), $this->selected_hall, $this->text);

        session()->flash('success', 'Report generated successfully!');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'report.pdf');
    }
}
