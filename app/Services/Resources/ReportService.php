<?php

namespace App\Services\Resources;

use App\Enums\Period;
use App\Interfaces\CanExport;
use App\Models\Report;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ReportService implements CanExport
{

    /**
     * Returns a paginated, filtered list of reports or a searched through list of reports if $this->search_query is set
     * All parameters are optional, if none are set, all reports are returned, paginated by $quantity, default 10
     *
     * @param int $hall_id
     * @param int $user_id
     * @param string $period
     * @param bool $do_sort
     * @param string $sort_by
     * @param string $sort_direction
     * @param string $search_query
     * @param int $paginate_quantity
     * @return LengthAwarePaginator|Collection
     */
    public function getFilteredReportsPaginated(int $hall_id = 0, int $user_id = 0, string $period = '', bool $do_sort = false, string $sort_by = 'created_at' , string $sort_direction = 'ASC', string $search_query = '', int $paginate_quantity = 10) : LengthAwarePaginator|Collection
    {
        return Report::forHall($hall_id)
            ->fromUser($user_id)
            ->forPeriod($period)
            ->search($search_query)
            ->sort($do_sort, $sort_by, $sort_direction)
            ->paginateOptional($paginate_quantity);
    }

    /**
     * @param array|Collection $data
     * @return array
     */
    public function sanitizeForExport(array|Collection $data): array
    {
        $bom = "\xEF\xBB\xBF";

        $headers = [
            $bom . 'Kreiran',
            'Sala',
            'Period',
            'Datum',
            'Menađer',
            'Tekst',
            'Fajl',
        ];


        $output = [];
        foreach ($data as $report) {
            $output[] = [
                $report['created_at'],
                $report['hall']['name'],
                Period::from($report['period'])?->toSrLatinString() ?? '',
                $report['hall']['name'] ?? '',
                $report['date_from'] ?? '',
                $report['user']['username'] ?? '',
                $report['text'],
                $report['PDF_url'] ?? ''
            ];
        }

        array_unshift($output, $headers);
        return $output;
    }
}
