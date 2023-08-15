<?php

namespace Database\Seeders\NonRandom;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserNonRandomSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Manager','email' => 'dgudovic@gmail.com', 'email_verified_at' => now(), 'password' => bcrypt('123456789'), 'username' => 'Manager', 'role' => Roles::MANAGER],
            ['name' => 'Client','email' => 'dgudovic.dev@gmail.com', 'email_verified_at' => now(), 'password' => bcrypt('123456789'), 'username' => 'Client', 'role' => Roles::CLIENT],
            ['name' => 'Business','email' => 'dgudovic2209@gmail.com', 'email_verified_at' => now(), 'password' => bcrypt('123456789'), 'username' => 'Business', 'role' => Roles::BUSINESS_CLIENT],
            ['name' => 'Admin','email' => 'dgudovic1@gmail.com', 'email_verified_at' => now(), 'password' => bcrypt('123456789'), 'username' => 'Admin', 'role' => Roles::ADMIN],
        ];
        User::insert($users);
    }
}
