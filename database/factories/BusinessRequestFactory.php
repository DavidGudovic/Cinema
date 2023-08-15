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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => $this->faker->randomElement(Status::cases()),
            'text' => $this->faker->paragraph(),
            'comment' => null,
            'requestable_id' => $this->faker->randomNumber(),
            'requestable_type' => $this->faker->randomElement(["App\Models\Advert", "App\Models\Booking"]),
        ];
    }
}
