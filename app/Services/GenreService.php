<?php
namespace App\Services;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

/*
* This service is responsible for handling genre requests.
*/

class GenreService
{
    /*
    * Get all genres.
    */
    public function getGenres() : Collection
    {
        return Genre::all();
    }

    /*
    * Get all fiction genres.
    */
    public function getFictionGenres() : Collection
    {
        return Genre::fiction()->get();
    }

    /*
    * Get all non-fiction genres.
    */
    public function getNonFictionGenres() : Collection
    {
        return Genre::nonFiction()->get();
    }

}
