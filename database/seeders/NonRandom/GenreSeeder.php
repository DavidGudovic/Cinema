<?php

namespace Database\Seeders\NonRandom;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres =
            [
                ['name' => 'Akcija', 'image_url' => 'action.png'],
                ['name' => 'Komedija', 'image_url' => 'comedy.png'],
                ['name' => 'Drama', 'image_url' => 'drama.png'],
                ['name' => 'Triler', 'image_url' => 'triler.png'],
                ['name' => 'Dokumentarac', 'image_url' => 'documentary.png'],
                ['name' => 'Sci Fi', 'image_url' => 'sci_fi.png'],
                ['name' => 'Avantura', 'image_url' => 'adventure.png'],
                ['name' => 'Horor', 'image_url' => 'horror.png'],
            ];

        Genre::insert($genres);
    }
}
