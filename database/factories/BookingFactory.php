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

    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        $start_time = fake()->dateTimeBetween('-20 months', '+2 weeks');
        $end_time = (clone $start_time)->add(new DateInterval('PT' . fake()->numberBetween(1, 3) . 'H'));

        return [
            'start_time' => $start_time,
            'end_time' => $end_time,
            'hall_id' => Hall::inRandomOrder()->first()->id,
        ];
    }
}
