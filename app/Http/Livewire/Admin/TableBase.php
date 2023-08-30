<?php

namespace App\Http\Livewire\Admin;

use App\Traits\WithCustomPagination;
use Livewire\Component;

/**
 * Base class for all admin tables
 * Contains the search bar, pagination, sorting and quantity
 * Setting the LengthAwarePaginator and Collection is almost the same for all tables
 * Should be extracted into a trait/here somehow
 */
abstract class TableBase extends Component
{
    use WithCustomPagination;

    public $search_query = ""; //search criteria
    public $sort_by = 'title';
    public $sort_direction = 'ASC';
    public $global_sort = 'true'; //sort all resources or just the ones on the current page - String because of livewire
    public $status_translations = [
        'CANCELLED' => 'OTKAZAN',
        'PENDING' => 'NA ČEKANJU',
        'ACCEPTED' => 'ODOBREN',
        'REJECTED' => 'ODBIJEN',
    ];

    public function refresh(): void
    {
    }

    /**
     * Sets $this->sort_by, if it's already sorting by that column, reverses order
     */
    public function setSort(string $sort_by): void
    {
        if ($this->sort_by == $sort_by) {
            $this->sort_direction = ($this->sort_direction == 'ASC') ? 'DESC' : 'ASC';
        } else {
            $this->sort_by = $sort_by;
            $this->sort_direction = 'ASC';
        }
    }

    /**
     * Sorts the resource list by $this->sort_by and $this->sort_direction or by the passed parameters
     * If $sort_params are passed, the collection is sorted by relation or directly by the column
     * Only sorts the collection on the current page
     */
    public function sortDisplayedPaginatorCollection(&$paginator_list, array $sort_params = []): void
    {
        $sorted = $paginator_list->getCollection()->sortBy(function ($resource) use ($sort_params){
            if(empty($sort_params)){  // if no sort params are passed, sort normally
                return $resource->{$this->sort_by};
            } else {  // if sort params are passed sort by them, used for sorting by relations
                return  $sort_params['type'] === 'relation'
                    ? $resource->{$sort_params['relation'] == 'halls' ? 'hall' : 'businessRequest'}->{$sort_params['column']}
                    : $resource->{$sort_params['column']};
            }
        }, SORT_REGULAR, $this->sort_direction == 'DESC');

        $paginator_list->setCollection($sorted);
    }
}
