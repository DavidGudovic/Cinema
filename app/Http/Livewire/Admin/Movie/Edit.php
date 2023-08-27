<?php

namespace App\Http\Livewire\Admin\Movie;

use App\Models\Movie;
use App\Services\Resources\MovieService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Collection $genres;
    public $banner;
    public $poster;
    public Movie $movie;

    public function render(MovieService $movieService)
    {
        return view('livewire.admin.movie.edit', [
            'is_screening' => $movieService->isMovieScreening($this->movie->id),
        ]);
    }
}
