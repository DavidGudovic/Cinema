<?php

namespace App\Http\Livewire\Resources\Movies;

use Livewire\Component;
use App\Services\GenreService;

class Filters extends Component
{
  public $genres; //mounted
  public $search_query = ""; //search criteria

  //filter criteria
  public $genre_list; //[K:GenreID -> V:true/false]W
  public $sort_by = 'title';
  public $sort_direction = 'ASC';
  public $screening_time = "any"; // 'any' 'now' 'tommorow' 'week'


  public $listeners = [
    'search' => 'search',
  ];

  public function mount(GenreService $genreService)
  {
    $this->genres = $genreService->getGenres();
  }

  public function render()
  {
    return view('livewire.resources.movies.filters');
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
    $this->screening_time = 'any';
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
    $this->emit("filter", $this->genre_list, $this->sort_by, $this->sort_direction, $this->screening_time);
  }



}
