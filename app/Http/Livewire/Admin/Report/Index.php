<?php

namespace App\Http\Livewire\Admin\Report;

use App\Enums\Period;
use App\Http\Livewire\Admin\TableBase;
use App\Models\Report;
use App\Services\ExportService;
use App\Services\Resources\ReportService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Index extends TableBase
{
    public Collection $halls;
    public Collection $managers;
    public array $periods;

    public int|string $user_id = 0;
    public int $hall_id = 0;
    public string $period = '';
    public $showErrorModal = false;

    public function mount()
    {
        $this->sort_by = 'created_at';
        $this->sort_direction = 'DESC';
        $this->quantity = 10;

        $this->periods = collect(Period::cases())->mapWithKeys(function ($period) {
            return [$period->value => $period->ToSrLatinString()];
        })->toArray();
    }
    public function render(ReportService $reportService)
    {
        $reports = $this->getReportsList($reportService);

        if ($this->global_sort == 'false') {
            $this->sortDisplayedPaginatorCollection($reports);
        }

        return view('livewire.admin.report.index', [
            'reports' => $reports,
        ]);
    }

    /**
     * Returns a paginated, filtered list of reports or a searched through list of reports if $this->search_query is set
     */
    public function getReportsList(ReportService $reportService): LengthAwarePaginator|Collection
    {
        return $reportService->getFilteredReportsPaginated(
            hall_id: $this->hall_id,
            user_id: $this->user_id == '' ? null :(int)$this->user_id,
            period: $this->period,
            do_sort: $this->global_sort == 'true',
            sort_by: $this->sort_by,
            sort_direction: $this->sort_direction,
            search_query: $this->search_query,
            paginate_quantity: $this->quantity,
        );
    }

    /**
     * Streams a PDF file of the given report to the user, flashes a message if the report is unavailable
     *
     * @param Report $report
     * @param ReportService $reportService
     * @return StreamedResponse|null
     */
    public function exportReport(Report $report, ReportService $reportService): StreamedResponse|null
    {

        $pdf = $reportService->getReportPDF($report);

        if(is_null($pdf)) {
            $this->toggleErrorModal();
            return null;
        }

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf;
        }, $report->PDF_path);
    }

    /**
     * Exports the report list to a CSV file
     * Returns a StreamedResponse with the CSV file
     * The CSV file is generated by the ExportService
     */
    public function export(ExportService $exportService, ReportService $reportService, string $scope = 'displayed'): StreamedResponse
    {
        $data = ($scope == 'displayed')
            ? $this->getReportsList($reportService)->values()->toArray()
            : $reportService->getFilteredReportsPaginated(paginate_quantity: 0)->toArray();

        $csv = $exportService->generateCSV($data, $reportService);

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'izveštaji' . now()->format('-d:m:Y') . '.csv');
    }

    public function toggleErrorModal(): void
    {
        $this->showErrorModal = !$this->showErrorModal;
    }
}
