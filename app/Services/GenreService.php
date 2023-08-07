<?php
namespace App\Services;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Nette\NotImplementedException;

/*
* This service is responsible for handling genre requests.
*/

class GenreService
{
    /*
    * Get all genres.
    */
    public function getGenres() : EloquentCollection
    {
        return Genre::all();
    }



    /*
    * Get Filters for Livewire/Resources/Movies/Filters [GenreID => bool(selected)]
    */
    public function getFiltersForGenres($selected_genre) : array
    {
        return $this->getGenres()
        ->mapWithKeys(function($genre) use ($selected_genre){
            return [
                $genre->id => $genre->id == $selected_genre
            ];
        })->toArray();
    }

}
