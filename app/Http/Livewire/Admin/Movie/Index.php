<?php

namespace App\Http\Livewire\Admin\Movie;

use App\Services\GenreService;
use App\Services\MovieService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $genres; //mounted
    public $search_query = ""; //search criteria
    //filter criteria
    public $genre = NULL;
    public $sort_by = 'title';
    public $sort_direction = 'ASC';
    public $screening_time = "with past"; // 'any' 'now' 'tomorrow' 'week' 'with past'
    public $global_sort = 'true'; //sort all movies or just the ones on the current page - String because of livewire
    public $quantity = 10; //pagination quantity

    public function refresh(): void
    {
    }

    public function mount(GenreService $genreService): void
    {
        $this->genres = $genreService->getGenres();
    }

    public function render(MovieService $movieService)
    {
        $movies = $this->getMovieList($movieService);

        if ($this->global_sort == 'false') {
            $this->sortDisplayedMovieList($movies);
        }

        return view('livewire.admin.movie.index', [
            'movies' => $movies,
        ]);
    }

    public function paginationView(): string
    {
        return 'pagination.custom';
    }

    /*
     * Returns a paginated, filtered list of movies or a searched through list of movies if search_query is given
     */
    public function getMovieList(MovieService $movieService): LengthAwarePaginator|Collection
    {
        $genre = ($this->genre == NULL) ? NULL : [$this->genre];
        return ($this->search_query == '') ?
            $movieService->getMoviesByGenreScreeningTimes(
                $genre,
                $this->screening_time,
                true,
                $this->quantity,
                ($this->global_sort == 'true'),
                $this->sort_by,
                $this->sort_direction
            ) :
            $movieService->getBySearch(
                $this->search_query,
                false,
                true,
                $this->quantity,
                ($this->global_sort == 'true'),
                $this->sort_by,
                $this->sort_direction
            );
    }

    /*
     * Sorts the movie list by the given sort_by, if it's already sorting by that column, reverses order
     */
    public function setSort(string $sort_by): void
    {
        if ($this->sort_by == $sort_by) {
            $this->sort_direction = ($this->sort_direction == 'ASC') ? 'DESC' : 'ASC';
        } else {
            $this->sort_by = $sort_by;
            $this->sort_direction = 'ASC';
        }
    }

    /*
     * Sorts the movie list by the given sort_by, if it's already sorting by that column, reverses order
     * Only sorts the collection on the current page, doesn't change the LengthAwarePaginator $movies
     */
    public function sortDisplayedMovieList(&$movies): void
    {
        $sorted = $movies->getCollection()->sortBy(function ($movie, $key) {
            return $movie->{$this->sort_by};
        }, SORT_REGULAR, $this->sort_direction == 'DESC');

        $movies->setCollection($sorted);
    }
}
