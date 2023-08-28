<?php

namespace App\Services\Resources;

use App\Enums\Period;
use App\Models\Report;
use App\Services\UploadService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Barryvdh\DomPDF\PDF as DomPDF;
use Carbon\Carbon;

class ReportService
{
    /**
     * Checks if a report has already been created
     */
    public function checkIfReportExists(Period $period, int $hall): bool
    {
        $date = $this->generateStartDate($period);

        return Report::forHall($hall)
            ->forDatePeriod($date, $period)
            ->exists();
    }


    /**
     * Generates a report, uploads it and persists metadata
     *
     * @param Period $period
     * @param int $hall
     * @param string $text
     * @param UploadService $uploadService
     * @return DomPDF
     */
    public function generateReport(Period $period, int $hall, string $text, UploadService $uploadService): DomPDF
    {
        //Generate, upload
        $PDF = $this->generatePDF($period, $hall, $text);
        $date_from = $this->generateStartDate($period);
        $PDF_path = $uploadService->uploadPDF($PDF, 'reports/' . $period->value . '/' . $hall . '_' . now()->format('Y-m-d_H-i') . '.pdf');

        //Persist metadata
        Report::create([
            'period' => $period,
            'hall_id' => $hall,
            'text' => $text,
            'date_from' => $date_from,
            'user_id' => auth()->user()->id,
            'created_at' => now(),
            'PDF_path' => $PDF_path
        ]);

        //Return the PDF file for streaming
        return $PDF;
    }

    /**
     * Builds and returns a DomPDF object ready for storing/streaming
     *
     * @param Period $period
     * @param int $hall
     * @param string $text
     * @return DomPDF
     */
    private function generatePDF(Period $period, int $hall, string $text): DomPDF
    {
        return PDF::loadView('pdf.report', [
            'period' => $period->toSrLatinString(),
            'date' => $this->formatForPDF($this->generateStartDate($period), $period),
            'hall' => $hall,
            'text' => $text,
            'manager' => auth()->user()
        ]);
    }

    /**
     * Formats a date to an appropriate string format for a PDF report
     *
     * @param Carbon $date
     * @param Period $period
     * @return string
     */
    private function formatForPDF(Carbon $date, Period $period): string
    {
        return match ($period) {
            Period::YEARLY => $date->format('Y'),
            Period::MONTHLY => $date->format('m/Y'),
            Period::WEEKLY => $date->format('m/d/y'),
        };
    }


    /**
     * Generates a start date for a report based on the period
     *
     * @param Period $period
     * @return Carbon
     */
    private function generateStartDate(Period $period): Carbon
    {
        return match ($period) {
            Period::YEARLY => now()->subYear()->startOfYear(),
            Period::MONTHLY => now()->subMonth()->startOfMonth(),
            Period::WEEKLY => now()->subWeek()->startOfWeek(),
        };
    }


}
