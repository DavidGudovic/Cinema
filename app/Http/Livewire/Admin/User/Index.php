<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Livewire\Admin\TableBase;

class Index extends TableBase
{
    public function render()
    {
        return view('livewire.admin.user.index');
    }
}
