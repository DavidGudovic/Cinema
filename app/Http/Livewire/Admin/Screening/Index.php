<?php

namespace App\Http\Livewire\Admin\Screening;

use App\Http\Livewire\Admin\TableBase;
use App\Services\ExportService;
use App\Services\Resources\ScreeningService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Index extends TableBase
{
    public Collection $movies;
    public Collection $halls;

    /* Screening specific filter criteria */
    public string $screening_time = 'any';
    public string $hall = 'all';
    public string $movie = 'all';

    protected $listeners = [
        'ScreeningDeleted' => 'refresh',
    ];

    public function mount()
    {
        $this->sort_by = 'start_time';
        $this->sort_direction = 'DESC';
        $this->quantity = 20;
    }

    public function render(ScreeningService $screeningService)
    {
        $screenings = $this->getScreeningsList($screeningService);

        if ($this->global_sort == 'false') {
            $this->sortDisplayedPaginatorCollection($screenings);
        }

        return view('livewire.admin.screening.index', [
            'screenings' => $screenings,
        ]);
    }

    /**
     * Returns a paginated, filtered list of screenings or a searched through list of screenings if $this->search_query is set
     */
    public function getScreeningsList(ScreeningService $screeningService): LengthAwarePaginator|Collection
    {
        return $screeningService->getFilteredScreeningsPaginated(
            time: $this->screening_time,
            hall_id: $this->hall == 'all' ? 0 : $this->hall,
            movie_id: $this->movie == 'all' ? 0 : $this->movie,
            search_query: $this->search_query,
            do_sort: $this->global_sort == 'true',
            sort_by: $this->sort_by,
            sort_direction: $this->sort_direction,
            quantity: $this->quantity,
        );
    }

    /**
     * Exports the advert list to a CSV file
     * Returns a StreamedResponse with the CSV file
     * The CSV file is generated by the ExportService
     */
    public function export(ExportService $exportService, ScreeningService $screeningService, string $scope = 'displayed'): StreamedResponse
    {
        $data = ($scope == 'displayed')
            ? $this->getScreeningsList($screeningService)->values()->toArray()
            : $screeningService->getFilteredScreeningsPaginated(time: 'with past', quantity: 0)->toArray();

        $csv = $exportService->generateCSV($data, $screeningService);

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'projekcije' . now()->format('-d:m:Y') . '.csv');
    }
}
