<?php

namespace App\Services\Resources;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class GenreService
{
    /**
     * Get all genres.
     *
     * @return EloquentCollection
     */
    public function getGenres(): EloquentCollection
    {
        return Genre::all();
    }

    /**
     * Get Filters for Livewire/Resources/Movies/Filters [GenreID => bool(selected)]
     *
     * @param array|null $selected_genre
     * @return array
     */
    public function getFiltersForGenres(?array $selected_genre): array
    {
        return $this->getGenres()
            ->mapWithKeys(function ($genre) use ($selected_genre) {
                return [
                    $genre->id => $genre->id == $selected_genre
                ];
            })->toArray();
    }
}
