<?php

namespace App\Http\Livewire\Admin\Screening;

use App\Http\Livewire\Admin\TableBase;
use Livewire\Component;

class Index extends TableBase
{
    public function render()
    {
        return view('livewire.admin.screening.index');
    }
}
