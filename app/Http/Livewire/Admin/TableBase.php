<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class TableBase extends Component
{
    use WithPagination;

    public $search_query = ""; //search criteria
    public $sort_by = 'title';
    public $sort_direction = 'ASC';
    public $global_sort = 'true'; //sort all resources or just the ones on the current page - String because of livewire
    public $quantity = 10; //pagination quantity

    public function refresh(): void
    {
    }

    public function paginationView(): string
    {
        return 'pagination.custom';
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

}
