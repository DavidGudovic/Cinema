<?php

namespace Database\Seeders\Random;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(100)->create();
    }
}