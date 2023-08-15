<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Hall;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $start_time = fake()->dateTimeBetween('-1 week', '+1 week');
        $end_time = (clone $start_time)->add(new DateInterval('PT' . fake()->numberBetween(1, 3) . 'H'));

        return [
            'start_time' => $start_time,
            'end_time' => $end_time,
            'hall_id' => Hall::inRandomOrder()->first()->id,
        ];
    }
}
