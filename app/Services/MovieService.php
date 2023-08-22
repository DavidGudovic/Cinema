<?php

namespace App\Services;

use App\Interfaces\CanExport;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MovieService implements CanExport
{
    /**
     * Create a new movie
     */
    public function createMovie($request, UploadService $uploadService): Movie
    {
        $paths = $this->uploadMovieImages($request->banner, $request->poster, $uploadService);

        return Movie::create([
            'title' => $request->title,
            'director' => $request->director,
            'description' => $request->description,
            'banner_url' => $paths['banner_url'],
            'image_url' => $paths['image_url'],
            'trailer_url' => $request->trailer_url,
            'release_date' => $request->release_date,
            'duration' => $request->duration,
            'is_showcased' => true,
            'genre_id' => $request->genre
        ]);
    }

    /**
     * Update an existing movie
     */
    public function updateMovie($request, $movie, UploadService $uploadService): Movie
    {
        $paths = $this->uploadMovieImages($request->banner, $request->poster, $uploadService);

        $movie->update([
            'title' => $request->title,
            'director' => $request->director,
            'description' => $request->description,
            'banner_url' => $paths['banner_url'] ?? $movie->banner_url,
            'image_url' => $paths['image_url'] ?? $movie->image_url,
            'trailer_url' => $request->trailer_url,
            'release_date' => $request->release_date,
            'duration' => $request->duration,
            'is_showcased' => true,
            'genre_id' => $request->genre
        ]);

        return $movie;
    }

    /**
     * Returns a key-value array of banner_url and/or image_url if either is passed
     */
    private function uploadMovieImages($banner, $poster, UploadService $uploadService): array
    {
        return [
            'banner_url' => $banner ? $uploadService->uploadImage($banner, 'images/movies') : null,
            'image_url' => $poster ? $uploadService->uploadImage($poster, 'images/movies') : null,
        ];
    }


    /**
     * Get all movies that have upcoming screenings now, tomorrow or in the next week, filtered by genre when genre != NULL.
     * Can sort/paginate optionally
     */
    public function getFilteredMoviesPaginated(?array $genres = NULL, ?string $screening_time = 'any', bool $paginate = false, int $quantity = 0, bool $do_sort = false, string $sort_by = 'title', string $sort_direction = 'ASC'): EloquentCollection|LengthAwarePaginator
    {
        return Movie::with('genre')
            ->fromGenres($genres)
            ->screeningTime($screening_time)
            ->sortOptional($do_sort, $sort_by, $sort_direction)
            ->paginateOptional($paginate, $quantity);
    }

    /**
     * Get all movies by title/director/genre query, can sort/paginate optionally
     */
    public function getBySearch(string $search_query, bool $only_screening = true, bool $paginate = false, int $quantity = 10, bool $do_sort = false, string $sort_by = 'title', string $sort_direction = 'ASC'): EloquentCollection|LengthAwarePaginator
    {
        return Movie::with('genre')
            ->search($search_query)
            ->screeningTime($only_screening ? 'default' : 'with past')
            ->sortOptional($do_sort, $sort_by, $sort_direction)
            ->paginateOptional($paginate, $quantity);
    }

    /**
     * Get distinct tag image urls for each movie that has screenings [MovieID => [tag1, tag2, ...]]
     */
    public function getDistinctTagUrls(): array
    {
        return Movie::with('screenings.tags')
            ->hasScreenings()
            ->get()
            ->mapWithKeys(function ($movie) {
                return [
                    $movie->id => $movie->screenings
                        ->pluck('tags.*.image_url')
                        ->flatten()
                        ->unique()
                ];
            })->toArray();
    }


    /**
     * Returns assoc array of next screening times for all movies with screenings  [MovieID => Next_Screening_Time]
     */
    public function getNextScreenings(): array
    {
        return Movie::with('screenings')
            ->hasScreenings()
            ->get()
            ->mapWithKeys(function ($movie) {
                return [$movie->id =>
                    $movie->screenings
                        ->where('start_time', '>=', now())
                        ->sortBy('start_time')
                        ->first()
                        ->start_time
                        ->format('d/m H:i')
                ];
            })
            ->toArray();
    }

    /**
     * Eager load all relevant direct/nested relationships for a movie
     */
    public function eagerLoadMovie(int $id): Movie
    {
        return Movie::with('genre', 'screenings.tags')
            ->findOrFail($id);
    }

    /**
     * Checks wether a movie has any upcoming screenings
     */
    public function isMovieScreening(int $movie_id): bool
    {
        return Movie::whereId($movie_id)
            ->whereHas('screenings', function ($query) {
                $query->upcoming();
            })->exists();
    }

    /**
     * Soft deletes movie
     */
    public function deleteMovie(int $movie_id): void
    {
        Movie::whereId($movie_id)->delete();
    }

    /**
     * Prepares a movie array|Collection for export, adds BOM, flattens the passed array and puts the proper headers
     * Implementation of CanExport interface
     */
    public function sanitizeForExport(array|Collection $data): array
    {
        $bom = "\xEF\xBB\xBF";

        $headers = [
            $bom . 'Naslov',
            'Režiser',
            'Žanr',
            'Trajanje',
            'Opis',
            'Slika',
            'Trailer',
        ];
        $output = [];
        foreach ($data as $movie) {
            $output[] = [
                $movie['title'] ?? '',
                $movie['director'] ?? '',
                $movie['genre']->name ?? $movie['genre']['name'] ?? '',
                $movie['duration'] ?? '',
                $movie['description'] ?? '',
                $movie['image_url'] ?? '',
                $movie['trailer_url'] ?? '',
            ];
        }
        array_unshift($output, $headers);
        return $output;
    }
}
