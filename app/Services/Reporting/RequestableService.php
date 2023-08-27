<?php

namespace App\Services\Reporting;

use App\Enums\Period;
use App\Enums\Status;
use App\Interfaces\CanReport;
use App\Models\BusinessRequest;

class RequestableService implements CanReport
{
    /**
     * [status => count, status => count, ...]
     *
     * @param Period $period
     * @param int $hall_id
     *
     * @return array
     */
    public function getReportableDataByPeriod(Period $period, int $hall_id): array
    {
        $data = BusinessRequest::fromPeriod($period)
            ->fromHallOrManagedHalls($hall_id)
            ->get()
            ->groupBy(function ($requests) {
                return $requests->status;
            })->mapWithKeys(function ($requests_collection, $status_key) { // mapWithKeys is used to convert the Status enum to a string
                return [
                    Status::from($status_key)->toSrLatinString() => $requests_collection->count()
                ];
            })->toArray();

        return array_replace($this->buildFillerData(), $data);
    }

    /**
     *  Builds an array with all possible statuses as keys and 0 as values
     *  Does not conform to the FillerData trait
     *
     * @return array
     */
    public function buildFillerData(): array
    {
        $data = [];
        foreach (Status::cases() as $status) {
            $data[$status->toSrLatinString()] = 0;
        }
        return $data;
    }
}
