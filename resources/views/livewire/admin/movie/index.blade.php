<div class="flex flex-col justify-center items-center gap-4 h-full w-full mb-6">
    <!-- Actions -->
    <div class="flex flex-col md:flex-row justify-between items-center w-full mb-12 md:mb-4 text-sm md:text-base">

        <!-- Filters -->
        <div class="flex gap-4">

            <!-- Filter for Genre -->
            <div class="flex flex-col gap-1">
                <label class="opacity-40 text-sm" for="genres">Žanrovi</label>
                <select wire:change="refresh" id="genres"
                        class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70" wire:model="genre">
                    <option class="cursor-pointer" value=''>Svi žanrovi</option>
                    @foreach($genres as $genre)
                        <option class="cursor-pointer" value="{{$genre->id}}">{{$genre->name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter for Next Screening -->
            <div class="flex flex-col gap-1">
                <label class="opacity-40 text-sm" for="screening">Prikazuje se</label>
                <select wire:change="refresh" id="screening"
                        class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70"
                        wire:model="screening_time">
                    <option class="cursor-pointer" value="with past">Ignoriši</option>
                    <option class="cursor-pointer" value="week">Ove nedelje</option>
                    <option class="cursor-pointer" value="now">Danas</option>
                    <option class="cursor-pointer" value="tomorrow">Sutra</option>
                    <option class="cursor-pointer" value="any">Bilo kada</option>
                </select>
            </div>

            <!-- Sort all or shown-->
            <div class="flex flex-col gap-1">
                <label class="opacity-40 text-sm" for="sort">Sortiraj</label>
                <select id="sort" class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70"
                        wire:model="global_sort">
                    <option class="cursor-pointer" value='false'>Prikazano</option>
                    <option class="cursor-pointer" value='true'>Sve podatke</option>
                </select>
            </div>

            <!-- Paginate quantity-->
            <div class="hidden md:flex flex-col gap-1">
                <label class="opacity-40 text-sm" for="sort">Prikaži</label>
                <select wire:change="refresh" id="sort"
                        class="border rounded cursor-pointer p-2 bg-neutral-700 bg-opacity-70" wire:model="quantity">
                    <option class="cursor-pointer" value="5">5</option>
                    <option class="cursor-pointer" value="10">10</option>
                    <option class="cursor-pointer" value="15">15</option>
                    <option class="cursor-pointer" value="20">20</option>
                    <option class="cursor-pointer" value="25">25</option>
                    <option class="cursor-pointer" value="50">50</option>
                    <option class="cursor-pointer" value="100">100</option>
                </select>
            </div>

        </div>
        <!-- End filters -->

        <!-- Load indicator MD -->
        <div wire:loading class="mt-4 absolute top-36  md:top-0 md:relative">
            <i class="fa-solid fa-gear fa-lg animate-spin"></i>
        </div>
        <!-- End load indicator -->

        <!-- Buttons and Search -->
        <div x-data="{showExcelDropdown: false}" class="flex gap-4">
            <!-- Search Bar -->
            <div class="relative flex flex-col gap-1">
                <label class="opacity-40 text-sm" for="search">Pretraži po</label>
                <input id="search" type="text" wire:model.debounce.300ms="search_query"
                       placeholder="Naziv, Žanr, Režiser..."
                       class="border rounded p-2 pl-8 bg-neutral-700 bg-opacity-70 w-44 md:w-auto">
                <i class="fa-solid fa-search absolute left-2 bottom-1 transform -translate-y-2/4"></i>
            </div>
            <!-- End Search Bar -->

            <!-- Add -->
            <a href="{{route('movies.create')}}"
               class="border rounded p-2 flex gap-2 mt-6 items-center bg-neutral-700 bg-opacity-70">
                <span>Dodaj </span>
                <i class="fa-solid fa-plus"></i>
            </a>
            <!-- End Add -->

            <!-- CSV -->
            <div x-on:click="showExcelDropdown = !showExcelDropdown" x-on:click.outside="showExcelDropdown = false"
                 wire:loading.class.remove="cursor-pointer hover:text-red-700" wire:loading.class="opacity-50"
                 class=" flex items-center cursor-pointer group relative border rounded p-2 gap-2 mt-6 bg-neutral-700 bg-opacity-70">
                <span class="group-hover:text-red-700">Excel</span>
                <i class="group-hover:text-red-700 fa-solid fa-file-csv"></i>
                <i class="group-hover:text-red-700 fa-solid fa-angle-down fa-xs pt-1"></i>
                <!-- Dropdown -->
                <div x-cloak x-show="showExcelDropdown"
                     class="absolute z-10 top-10 left-0 flex flex-col justify-center p-2 bg-neutral-500 rounded-lg">
                    <a href="#" wire:click.prevent="export('global')" class="text-center w-full">Sve</a>
                    <a href="#" wire:click.prevent="export('displayed')" class="text-center w-full">Prikazano</a>
                </div>
                <!-- End Dropdown -->
            </div>
            <!-- End CSV -->
        </div>
        <!-- End buttons search -->

    </div>
    <!-- End actions -->


    <!-- Table -->
    <div class="flex flex-1 w-full text-white">
        <div class="w-screen md:w-auto min-w-full md:overflow-x-hidden overflow-y-hidden overflow-x-scroll">
            <table x-data="{ sortBy: @entangle('sort_by') }"
                   class="w-max md:w-full table-fixed md:overflow-x-hidden overflow-y-hidden overflow-x-auto">
                <thead class="">
                <tr>
                    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'title' }"
                        wire:click="setSort('title')" class="cursor-pointer p-2 w-40"><i
                            class="fa-solid fa-sort opacity-40 fa-xs"></i>
                        Naslov
                    </th>
                    <th class="p-2 w-32">Opis</th>
                    <th class="p-2">Slika</th>
                    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'release_date' }"
                        wire:click="setSort('release_date')" class="cursor-pointer p-2"><i
                            class="fa-solid fa-sort opacity-40 fa-xs"></i>
                        Godina
                    </th>
                    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'duration' }"
                        wire:click="setSort('duration')" class="cursor-pointer p-2"><i
                            class="fa-solid fa-sort opacity-40 fa-xs"></i>
                        Trajanje
                    </th>
                    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'genre_id' }"
                        wire:click="setSort('genre_id')" class="cursor-pointer p-2"><i
                            class="fa-solid fa-sort opacity-40 fa-xs"></i>
                        Žanr
                    </th>
                    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'director' }"
                        wire:click="setSort('director')" class="cursor-pointer p-2"><i
                            class="fa-solid fa-sort opacity-40 fa-xs"></i>
                        Režiser
                    </th>
                    <th x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'is_showcased' }"
                        wire:click="setSort('is_showcased')" class="cursor-pointer p-2"><i
                            class="fa-solid fa-sort opacity-40 fa-xs"></i>
                        Istaknuto
                    </th>
                    <th class="cursor-pointer p-2">
                        Akcije
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($movies as $movie)
                    <tr x-data="{showToolTip{{$movie->id}}: false}"
                        class="odd:bg-neutral-950 odd:bg-opacity-30 text-center relative ">
                        <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'title' }"
                            class="p-2">{{ $movie->title }}</td>
                        <td x-on:mouseenter="showToolTip{{$movie->id}} = true"
                            x-on:mouseleave="showToolTip{{$movie->id}} = false"
                            class="group m-2 line-clamp-2">{{ implode(' ',explode(' ', $movie->description, 3))}}
                            <span x-cloak x-show="showToolTip{{$movie->id}}"
                                  class=" transition-opacity bg-gray-800 text-gray-100 p-2 text-sm rounded-md  absolute left-40 top-0 z-20 w-96 h-auto">{{$movie->description}}</span>
                        </td>
                        <td class="p-2">{{ $movie->image_url }}</td>
                        <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'release_date' }"
                            class="p-2">{{ $movie->release_year }}</td>
                        <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'duration' }"
                            class="p-2">{{ $movie->duration }}</td>
                        <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'genre_id' }"
                            class="p-2">{{ $genres[$movie->genre_id - 1]->name }}</td>
                        <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'director' }"
                            class="p-2">{{ $movie->director }}</td>
                        <td x-bind:class="{ 'bg-neutral-700 bg-opacity-30': sortBy === 'is_showcased' }"
                            class="p-2">{{ $movie->is_showcased ? 'Da' : 'Ne' }}</td>
                        <td class="p-2">
                            <div class="flex gap-5 justify-center items-center h-full">
                                <a href="{{route('screenings.create', ['movie' => $movie])}}">
                                    <i class="fa-solid fa-clapperboard"></i>
                                </a>
                                <a href="{{route('movies.edit', $movie)}}" class="hover:text-gray-300">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="#" wire:click.prevent="openDeleteModal({{$movie->id}})"
                                   class="text-red-700 hover:text-gray-300">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End table-->
    <p>{{$movies->links()}}</p>
    <!-- Delete modal-->
    @livewire('admin.movie.delete-modal')
</div>

