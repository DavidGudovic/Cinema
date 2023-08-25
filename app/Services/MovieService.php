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
     * @param $request
     * @param UploadService $uploadService
     * @return Movie
     * Creates a new movie, delegates image upload to UploadService
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
     * @param $request
     * @param $movie
     * @param UploadService $uploadService
     * @return Movie
     * Updates a movie, delegates image upload to UploadService
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
     * @param $banner
     * @param $poster
     * @param UploadService $uploadService
     * @return array
     * Uploads movie images to the server and returns their paths
     */
    private function uploadMovieImages($banner, $poster, UploadService $uploadService): array
    {
        return [
            'banner_url' => $banner ? $uploadService->uploadImage($banner, 'images/movies') : null,
            'image_url' => $poster ? $uploadService->uploadImage($poster, 'images/movies') : null,
        ];
    }

    /**
     * @param array|null $genres
     * @param string $screening_time
     * @param bool $paginate
     * @param int $quantity
     * @param bool $do_sort
     * @param string $sort_by
     * @param string $sort_direction
     * @return EloquentCollection|LengthAwarePaginator
     * Returns a paginated, filtered, sorted list of movies
     * All parameters are optional, if none are passed, all movies are returned
     */
    public function getFilteredMoviesPaginated(?array $genres = NULL, string $screening_time = 'any', bool $paginate = false, int $quantity = 0, bool $do_sort = false, string $sort_by = 'title', string $sort_direction = 'ASC'): EloquentCollection|LengthAwarePaginator
    {
        return Movie::with('genre')
            ->fromGenres($genres)
            ->screeningTime($screening_time)
            ->sortOptional($do_sort, $sort_by, $sort_direction)
            ->paginateOptional($paginate, $quantity);
    }

    /**
     * @param string $search_query
     * @param bool $only_screening
     * @param bool $paginate
     * @param int $quantity
     * @param bool $do_sort
     * @param string $sort_by
     * @param string $sort_direction
     * @return EloquentCollection|LengthAwarePaginator
     * Returns a paginated, searched through, sorted list of movies
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
     * @return array
     * Returns an associative array of all distinct tag urls for all movies with screenings
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
     * @return array
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
     * @param int $id
     * @return Movie
     * Eager load all relevant direct/nested relationships for a movie
     */
    public function eagerLoadMovie(int $id): Movie
    {
        return Movie::with('genre', 'screenings.tags')
            ->findOrFail($id);
    }

    /**
     * @param int $id
     * @return Movie
     * Get a movie by id
     */
    public function getMovie(int $id): Movie
    {
        return Movie::find($id);
    }

    /**
     * @param int $movie_id
     * @return bool
     * Checks if a movie has any upcoming screenings
     */
    public function isMovieScreening(int $movie_id): bool
    {
        return Movie::whereId($movie_id)
            ->whereHas('screenings', function ($query) {
                $query->upcoming();
            })->exists();
    }

    /**
     * @param int $movie_id
     * @return void
     * Soft deletes movie
     */
    public function deleteMovie(int $movie_id): void
    {
        Movie::whereId($movie_id)->delete();
    }

    /**
     * @param array|Collection $data
     * @return array
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
