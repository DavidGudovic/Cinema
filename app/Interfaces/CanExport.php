<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

/* Strategy pattern for exporting data to CSV */
interface CanExport
{
    public function sanitizeForExport(array|Collection $data): array;
}
