<?php

namespace Database\Factories;

use App\Models\BusinessRequest;
use App\Models\Hall;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Enums\Status;
class BusinessRequestFactory extends Factory
{
    protected $model = BusinessRequest::class;

    public function definition(): array
    {

        return [
            'created_at' => fake()->dateTimeBetween('-20 months', '+1 week'),
            'updated_at' => Carbon::now(),
            'status' => fake()->randomElement(Status::cases()),
            'text' => fake()->paragraph(),
            'comment' => null,
            'requestable_id' => fake()->randomNumber(),
            'requestable_type' => fake()->randomElement(["App\Models\Advert", "App\Models\Booking"]),
        ];
    }
}
