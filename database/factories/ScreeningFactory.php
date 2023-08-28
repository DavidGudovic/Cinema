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
            'start_time' => fake()->dateTimeBetween('-20 months', '+2 weeks', 'Europe/Berlin')->setTime(fake()->numberBetween(8, 20), fake()->randomElement([0, 15, 30, 45]), 0),
            'movie_id' => Movie::inRandomOrder()->first(),
            'hall_id' => Hall::inRandomOrder()->first(),
        ];
    }
}
