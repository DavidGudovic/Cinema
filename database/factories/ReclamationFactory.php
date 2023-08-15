<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\BusinessRequest;
use App\Models\Reclamation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReclamationFactory extends Factory
{
    protected $model = Reclamation::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => fake()->randomElement([Status::ACCEPTED, Status::REJECTED, Status::PENDING]),
            'text' => $this->faker->paragraph(),
            'comment' => $this->faker->paragraph(),
        ];
    }
}
