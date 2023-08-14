<?php

namespace Database\Factories;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ScreeningFactory extends Factory
{
    protected $model = Screening::class;

    public function definition(): array
    {
        return [
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now(),

            'movie_id' => Movie::factory(),
            'hall_id' => Hall::factory(),
        ];
    }
}
