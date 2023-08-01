<div x-data="{ showFilters: false, showSearchBar: false }">

  <!-- Fixed elements -->
  <!-- Search -->

    <!-- Closed search icons-->
  <button class="fixed top-20 right-6 pt-2 hover:text-red-700 text-white z-30" type="button"
          x-on:click="showSearchBar = true"
          x-show="!showSearchBar">
            <i class="fa-solid fa-arrow-left fa-2xl"></i>
            <i class="fa-solid fa-magnifying-glass fa-2xl"></i>
  </button>
  <!-- End closed search icons -->

  <!-- Search form open -->
  <form wire:submit.prevent="search" x-cloak class="text-white">
    <!-- Search Submit-->
    <button class="fixed top-20 right-6 pt-2 hover:text-red-700 z-30" type="submit"
            x-on:click="showFilters = false"
            @click="$nextTick(() => window.scrollTo(0,0))"
            x-show="showSearchBar">
      <i class="fa-solid fa-magnifying-glass fa-2xl"></i>
    </button>
    <!-- End search submit -->

      <!--Hidden search bar-->
      <!-- Close icon-->
      <a href="" class="fa-solid fa-arrow-right fa-2xl fixed top-24 pt-2 right-72 z-30"
       x-show="showSearchBar" x-on:click.prevent="showSearchBar = !showSearchBar"></a>
       <!-- End close icon -->
       <input type="text" name="searchBar" placeholder="Film, Režiser ili Žanr"
           x-show="showSearchBar"
           x-cloak x-transition-opacity
           wire:model="search_query"
           class="fixed top-20 right-4 bg-gray-950 bg-opacity-75 border-2 border-gray-200 rounded-3xl p-2 w-64 z-30">
      <!-- End search bar -->
  </form>
  <!-- End search open -->
  <!--End Search -->

  <!-- Open/Close filters -->
  <button class="fixed top-20 left-6 pt-2 z-10 hover:text-yellow text-white" type="button"
          x-on:click="showFilters = !showFilters"
          @click="$nextTick(() => showFilters ? window.scrollTo(0,0) : true)">
      <i class="fa-solid fa-sliders fa-2xl" :class="{'rotate-90 inline-block': showFilters}"></i>
      <p x-show="!showFilters" x-cloak class="text-opacity-70">Filteri</p>
  </button>
  <!-- End open/close filters-->

  <!--End fixed elements-->

  <!-- Filters Responsive Form -->
  <form wire:submit.prevent="submit" class="flex flex-col gap-4 border-2 border-gray-800 bg-gray-950 bg-opacity-90 p-6 md:mr-9 min-w-[250px] text-white"
      x-show="showFilters" x-transition.opacity x-ref="filters" x-on:click="showSearchBar = false">
      <div class="flex flex-row justify-center">
        <p class="font-bold text-center">Filteri</p>
        <div wire:loading wire:target="submit, resetFilter" class="w-8 h-8">
          <img src="{{URL('/images/utility/loading.gif')}}" alt="">
        </div>
      </div>

    <!--Fiction-->
    <div class="flex flex-col ">
      <p class="text-opacity-70 text-sm">Fikcija</p>
      @foreach($fiction_genres as $genre)
        <div class="">
          <input wire:model="genre_list.{{$genre->id}}" type="checkbox"  name="{{$genre->id}}" @if($genre_list[$genre->id]) checked @endif> {{$genre->name}}
        </div>
      @endforeach
    </div>
    <!--End Fiction-->
    <!--NonFiction-->
    <div class="flex flex-col ">
      <p class="text-opacity-70 text-sm">Dokumentarci</p>
      @foreach($nonFiction_genres as $genre)
        <div class="">
          <input wire:model="genre_list.{{$genre->id}}" type="checkbox" name="{{$genre->id}}" @if($genre_list[$genre->id]) checked @endif> {{$genre->name}}
        </div>
      @endforeach
    </div>
    <!--End NonFiction-->

    <!-- Sort -->
    <div class="flex flex-col gap-2 mt-4">
    <p class="text-opacity-70 text-sm">Sortiraj po:</p>
    <!-- Sort criteria -->
    <select wire:model="sort_by" name="sortby" class="text-black  bg-gray-200">
      <option value="title">Nazivu</option>
      <option value="director">Režiseru</option>
      <option value="release_date">Godini</option>
    </select>
    <!-- Sort direction -->
    <select wire:model="sort_direction" name="sortdir" class="text-black bg-gray-200">
      <option value="ASC">Rastuće</option>
      <option value="DESC">Opadajuće</option>
    </select>
    </div>
    <!-- End Sort -->

    <!-- Actions -->
    <div class="flex flex-col gap-2">
      <input type="submit" value="Primeni filtere"
       class="border-2 border- bg-black text-white p-1 rounded-xl cursor-pointer hover:text-red-700">
      <input wire:click.prevent="resetFilter" type="reset" value="Resetuj filtere"
      class="border-2 text-white border-white p-1 rounded-xl cursor-pointer hover:text-red-700">
    </div>
    <!-- End actions-->
  </form>
    <!-- End filters form -->
  </div>
