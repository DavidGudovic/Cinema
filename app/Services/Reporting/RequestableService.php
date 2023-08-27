<?php

namespace App\Services\Reporting;

use App\Enums\Periods;
use App\Enums\Status;
use App\Interfaces\CanReport;
use App\Models\BusinessRequest;

class RequestableService implements CanReport
{

    /**
     * [status => count, status => count, ...]
     *
     * @param Periods $period
     * @param int $hall_id
     *
     * @return array
     */
    public function getReportableDataByPeriod(Periods $period, int $hall_id): array
    {
        $data = BusinessRequest::fromPeriod($period)
            ->fromHallOrManagedHalls($hall_id)
            ->get()
            ->groupBy(function ($requests) {
                return $requests->status;
            })->map(function ($requests) {
                return $requests->count();
            })->toArray();

        return array_replace($this->buildFillerData(), $data);
    }

    /**
     *  Builds an array with all possible statuses as keys and 0 as values
     *
     * @param Periods|null $period
     * @return array
     */
    public function buildFillerData(?Periods $period = null): array
    {
        $data = [];
        foreach (Status::cases() as $status) {
            $data[$status->toSrLatinString()] = 0;
        }
        return $data;
    }
}
