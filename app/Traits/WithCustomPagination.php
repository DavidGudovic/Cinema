<?php

namespace  App\Traits;

use Livewire\WithPagination;

trait WithCustomPagination
{
    use WithPagination;

    public int $quantity = 10; //pagination quantity

    public function paginationView(): string
    {
        return 'pagination.custom';
    }

    public function refreshPage(): void
    {
        $this->resetPage();
    }
}
