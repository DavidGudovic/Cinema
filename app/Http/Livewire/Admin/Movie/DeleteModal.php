<?php

namespace App\Http\Livewire\Admin\Movie;

use App\Http\Livewire\ModalBase;
use App\Services\MovieService;

class DeleteModal extends ModalBase
{
    public ?int $movie_id;
    public bool $screening;

    public function render(MovieService $movieService)
    {
        if(isset($this->params[0])){
            $this->movie_id = $this->params[0];
            $this->screening = $this->isMovieScreening($movieService);
        }

        return view('livewire.admin.movie.delete-modal');
    }

    /**
     * Checks if movie is screening in the future
     */
    public function IsMovieScreening(MovieService $movieService) : bool
    {
        return $this->movie_id && $movieService->isMovieScreening($this->movie_id);
    }

    /**
     * Deletes movie, flashes message to the modal and emits event to the index component
     */
    public function deleteMovie(MovieService $movieService): void
    {
        $movieService->deleteMovie($this->movie_id);
        session()->flash('success','Uspešno ste izbrisali film');
        $this->emit('MovieDeleted');
    }

}
