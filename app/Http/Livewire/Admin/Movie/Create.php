<?php

namespace App\Http\Livewire\Admin\Movie;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public Collection $genres;
    public $banner;
    public $poster;
    public function render()
    {
        return view('livewire.admin.movie.create');
    }
}
