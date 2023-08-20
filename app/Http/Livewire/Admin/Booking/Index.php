<?php

namespace App\Http\Livewire\Admin\Booking;

use App\Http\Livewire\Admin\TableBase;
use Livewire\Component;

class Index extends TableBase
{
    public function render()
    {
        return view('livewire.admin.booking.index');
    }
}
