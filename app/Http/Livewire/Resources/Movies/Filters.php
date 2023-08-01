<?php

namespace App\Http\Livewire\Resources\Movies;

use Livewire\Component;
use App\Services\GenreService;

class Filters extends Component
{
  public $fiction_genres; //mounted
  public $nonFiction_genres; //mounted
  public $search_query = ""; //search criteria

  //filter criteria
  public $genre_list; //[K:GenreID -> V:true/false]
  public $price_range;
  public $sort_by = 'title';
  public $sort_direction = 'ASC';


  public $listeners = [
    'search' => 'search',
  ];

  public function mount(GenreService $genreService)
  {
    $this->fiction_genres = $genreService->getFictionGenres();
    $this->nonFiction_genres = $genreService->getNonFictionGenres();
  }

  public function render()
  {
    return view('livewire.resources.movies.filters');
  }

  /*
  Soft resets filters
  emits search query to livewire.movies.index
  */
  public function search() : void
  {
    $this->softResetFilter();
    $this->emit("applySearch", $this->search_query);
  }


  /*
  Emits filter criteria from form to livewire.movies.index
  Called when applying filters
  Resets search query (Items are filtered by filtes, not searchBar)
  */
  public function submit() : void
  {
    $this->resetSearchBar();
    $this->emit("filter", $this->genre_list, $this->price_range, $this->sort_by, $this->sort_direction);
  }

  /*
  Resets searchQuery, reRenders SearchBar
  */
  public function resetSearchBar() : void
  {
    $this->search_query = "";
  }
  /*
  input type(reset) behaviour but works on non user inputed data
  Resets form without emiting new filters to Resources/Movies/Index
  */
  public function softResetFilter() : void
  {
    $this->sort_by = "title";
    $this->sort_direction = "ASC";
    $this->price_range = null;
    foreach($this->genre_list as $genre => $checked){
      $this->genre_list[$genre] = false;
    }
  }
  /*
  calls soft reset
  Resets search query
  Emits empty filter to livewire.movies.index  ( displays all movies )
  */
  public function resetFilter() : void
  {
    $this->softResetFilter();
    $this->resetSearchBar();
    $this->emit("filter");
  }

}
