<?php
namespace App\Services;

use App\Models\Genre;

class GenreService
{
    public function getGenres()
    {
        return Genre::all();
    }

    public function getFictionGenres()
    {
        return Genre::fiction()->get();
    }

    public function getNonFictionGenres()
    {
        return Genre::nonFiction()->get();
    }

}
