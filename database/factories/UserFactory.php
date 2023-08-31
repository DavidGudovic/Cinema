<?php

namespace Database\Factories;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do{ $name = fake()->name(); } while(strlen($name) > 15);
        do{ $username = fake()->unique()->userName(); } while(strlen($username) > 16);
        do{ $email = fake()->unique()->safeEmail(); } while(strlen($email) > 25);
        return [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement([Roles::BUSINESS_CLIENT, Roles::CLIENT]),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
