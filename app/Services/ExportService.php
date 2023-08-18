<?php

namespace App\Services;

use App\Interfaces\CanExport;
use Illuminate\Support\Collection;

class ExportService
{
    /* Generates a CSV from a passed [ [] [] [] ] */
    public function generateCSV(array|Collection $data, CanExport $service) : string|bool
    {
        $data = $service->sanitizeForExport($data);

        $output = fopen('php://temp', 'r+');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        return $csv;
    }
}
