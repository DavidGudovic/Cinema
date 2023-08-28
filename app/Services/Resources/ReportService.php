<?php

namespace App\Services\Resources;

use App\Models\Report;
use App\Services\UploadService;

class ReportService
{
    /**
     * Checks if a report has already been created
     */
    public function checkIfReportExists(string $period, int $hall) : bool
    {
        return false;
    }

    /**
     * @param string $period
     * @param int $hall
     * @param string $text
     * @return void
     */
    public function generateReport(string $period, int $hall, string $text, UploadService $uploadService) : void
    {
        $PDF_path = $uploadService->uploadPDF($text, 'reports');
        $CSV_path = $uploadService->uploadCSV($text, 'reports');

        $report = Report::create([
            'period' => $period,
            'hall_id' => $hall,
            'text' => $text,
            'user_id' => auth()->user()->id,
            'created_at' => now(),
        ]);
    }

    public function generatePDF(string $period, int $hall, string $text) : void
    {
        //generate pdf
    }

    public function generateCSV(string $period, int $hall, string $text) : void
    {
        //generate csv
    }
}
