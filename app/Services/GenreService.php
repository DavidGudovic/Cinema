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
    * Get all fiction genres.
    */
    public function getFictionGenres() : EloquentCollection
    {
        return Genre::fiction()->get();
    }

    /*
    * Get all non-fiction genres.
    */
    public function getNonFictionGenres() : EloquentCollection
    {
        return Genre::nonFiction()->get();
    }

    /*
    * Get Filters for Livewire/Resources/Movies/Filters [GenreID => bool(selected)]
    */
    public function getFiltersForGenres($selected_genre) : array
    {
        $all_genres = $this->getGenres();
        $filters = [];

        foreach($all_genres as $genre){
            $filters[$genre->id] = $genre->id == $selected_genre;
        }

        return $filters;
    }

}
