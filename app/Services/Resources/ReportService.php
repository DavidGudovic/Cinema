<?php

namespace App\Services\Resources;

use App\Models\Report;
use App\Services\UploadService;
use Barryvdh\DomPDF\PDF;

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
     * @param UploadService $uploadService
     * @return void
     */
    public function generateReport(string $period, int $hall, string $text, UploadService $uploadService) : void
    {
        $PDF = $this->generatePDF($period, $hall, $text);

        $report = Report::create([
            'period' => $period,
            'hall_id' => $hall,
            'text' => $text,
            'user_id' => auth()->user()->id,
            'created_at' => now(),
            'PDF_path' => $uploadService->uploadPDF($PDF, 'reports/' . $period . '/' . $hall . '.pdf')
        ]);
    }

    public function generatePDF(string $period, int $hall, string $text) : PDF
    {
        //generate pdf
    }

}
