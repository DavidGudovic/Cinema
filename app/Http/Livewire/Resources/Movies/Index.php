<?php

namespace App\Http\Livewire\Resources\Movies;

use Livewire\Component;
use App\Services\MovieService;

class Index extends Component
{
  public $movie_list; //filtered result
  public $movie_tags; //tags movie list [MovieID => [tag1, tag2, ...]]
  public $movies_next_screening; // next screening for each movie [MovieID => Screening_Time]

  public $listeners = [
    'filter' => 'filter',
    'applySearch' => 'applySearch',
  ];

  public function mount(MovieService $movieService)
  {
    $this->movie_tags = $movieService->getDistinctTagUrls();
    $this->movies_next_screening = $movieService->getNextScreenings();
  }

  public function render()
  {
    return view('livewire.resources.movies.index');
  }

  /*
  Applies filters to movie list. [genres, sorting]
  Filter criteria provided by movies.filters component by raising a filter event
  */
  public function filter(MovieService $movieService, $genre_list = [], $sort_by='title', $sort_direction='ASC', $screening_time='any') : void
  {
    $this->movie_list = $movieService->getMoviesByGenreScreeningTimes(array_keys($genre_list, true), $screening_time);
    $this->sort($sort_by, $sort_direction);
  }

  /*
   Sorts the movie list by criteria and direction
  */
  public function sort($sort_by, $sort_direction) : void
  {
    $this->movie_list =
    $sort_direction == 'ASC' ?
    $this->movie_list->sortBy($sort_by) :
    $this->movie_list->sortByDesc($sort_by);
  }

  /*
  Applies validated search criteria passed by event raised by movies.filters
  */
  public function applySearch(MovieService $movieService,$searchQuery) : void
  {
    $this->movie_list = $movieService->getBySearch($searchQuery);
  }

}
