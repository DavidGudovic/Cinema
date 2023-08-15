<?php

namespace Database\Factories;

use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeatFactory extends Factory
{
    protected $model = Seat::class;

    public function definition(): array
    {
        return [
            'row' => $this->faker->numberBetween(1, 10),
            'column' => $this->faker->numberBetween(1, 10),
        ];
    }
}
