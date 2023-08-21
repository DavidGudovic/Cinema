<?php

namespace Database\Factories;

use App\Models\Advert;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdvertFactory extends Factory
{
    protected $model = Advert::class;

    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1,30);
        return [
            'advert_url' => $this->faker->url(),
            'title' => ucfirst($this->faker->word()),
            'company' => ucfirst($this->faker->text(8)),
            'quantity' => $quantity,
            'quantity_remaining' => $quantity,
        ];
    }
}
