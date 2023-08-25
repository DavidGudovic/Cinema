<?php

namespace App\Services;

use App\Interfaces\CanExport;
use Illuminate\Support\Collection;

class ExportService
{
    /**
     * @param array|Collection $data
     * @param CanExport $service
     * @return string|bool
     * Generates a CSV from a passed array or collection of data, sanitized by any implementation of CanExport interface
     */
    public function generateCSV(array|Collection $data, CanExport $service): string|bool
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
