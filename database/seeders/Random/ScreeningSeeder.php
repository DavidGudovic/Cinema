<?php

namespace Database\Seeders\Random;

use App\Models\Movie;
use App\Models\Screening;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ScreeningSeeder extends Seeder
{
    public function run(): void
    {
        // Doesnt save to database
        $screenings = Screening::factory()->count(6000)->make();
        $tags = Tag::all();

        //Calculate end_time
        foreach ($screenings as $screening) {
            $screening->end_time = $screening->start_time
                ->addMinutes($screening->movie->duration)
                ->addMinutes(config('settings.advertising.per_screening') * config('settings.advertising.duration'));
        }
        //Ensure it doesn't overlap and add to database
        foreach ($screenings as $screening) {
            $overlap = Screening::where('hall_id', $screening->hall_id)
                ->where('start_time', '<', $screening->end_time)
                ->where('end_time', '>', $screening->start_time)
                ->exists();

            if (!$overlap) {
                // Add tags
                $screening->save();
                $screening->tags()->saveMany([$tags[2], $tags[fake()->randomElement([0, 1, 3])]]);
            }
        }
    }
}
