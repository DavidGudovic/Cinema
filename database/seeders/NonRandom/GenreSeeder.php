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
                ['name' => 'Akcija', 'image_url' => 'action.webp'],
                ['name' => 'Komedija', 'image_url' => 'comedy.webp'],
                ['name' => 'Drama', 'image_url' => 'drama.webp'],
                ['name' => 'Triler', 'image_url' => 'triler.webp'],
                ['name' => 'Dokumentarac', 'image_url' => 'documentary.webp'],
                ['name' => 'Sci Fi', 'image_url' => 'sci_fi.webp'],
                ['name' => 'Avantura', 'image_url' => 'adventure.webp'],
                ['name' => 'Horor', 'image_url' => 'horror.webp'],
            ];

        Genre::insert($genres);
    }
}
