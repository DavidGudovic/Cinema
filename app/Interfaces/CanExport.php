<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
interface CanExport
{
    public function sanitizeForExport(array|Collection $data): array;
}
