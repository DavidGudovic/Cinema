@extends('templates.app')

@section('background-pattern')bg-gray-950 @endsection

@section('content')

    <h1 class="font-extrabold text-3xl text-center my-12 text-white ">Trenutni Repertoar</h1>

  <!--Wrapper of products-->
  <div class="flex flex-col md:flex-row w-full p-10 pt-0 md:pr-6">
    <!-- Filters -->
    <div class="mb-6 md:mb-0">
      <livewire:resources.movies.filters :genre_list="$filters">
    </div>
    <!-- End filter -->
    <!-- Products catalog -->
    <div class="flex-1">
      <livewire:resources.movies.index :movie_list="$movies">
    </div>
    <!-- End products -->
  </div>
  <!--End wrapper -->
@endsection
