<?php

namespace App\Http\Livewire\Resources\Movies;

use Livewire\Component;
use App\Services\MovieService;

class Index extends Component
{
  public $movie_list; //filtered result

  public $listeners = [
    'filter' => 'filter',
    'applySearch' => 'applySearch',
  ];

  public function render()
  {
    return view('livewire.resources.movies.index');
  }

  /*
  Applies filters to movie list. [genres, price_range, sorting]
  Filter criteria provided by movies.filters component by raising a filter event
  */
  public function filter(MovieService $movieService, $genre_list = [], $price_range = null, $sort_by='title', $sort_direction='ASC') : void
  {
    $this->movie_list = $movieService->getScreeningMoviesByGenres(array_keys($genre_list, true));

    if(!empty($price_range)){
      $this->filterPrice($price_range);
    }

    $this->sort($sort_by, $sort_direction);
  }

  /*
    Removes elements from $movie_list where item price is higher then $price_range
  */
  public function filterPrice(int $price_range) : void
  {
    foreach($this->movie_list as $movieCollectionKey => $movie){
      if($movie->price > $price_range){
        $this->movie_list->forget($movieCollectionKey);
      }
    }
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
