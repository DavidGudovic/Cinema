<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Jobs\ScheduleAdverts;
use Database\Seeders\NonRandom\GenreSeeder;
use Database\Seeders\NonRandom\HallSeeder;
use Database\Seeders\NonRandom\MovieSeeder;
use Database\Seeders\NonRandom\TagSeeder;
use Database\Seeders\NonRandom\UserNonRandomSeeder;
use Database\Seeders\Random\BusinessRequestSeeder;
use Database\Seeders\Random\ReclamationSeeder;
use Database\Seeders\Random\ScreeningSeeder;
use Database\Seeders\Random\TicketSeeder;
use Database\Seeders\Random\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
       echo("Seeding this application should only be done with a fresh database!\n");
       echo("If the database isn't fresh run php artisan migrate:fresh --seed\n");
        usleep(500000);
       echo("Seeding non-random data..\n");
        $this->callWithLogging(GenreSeeder::class, "Seeding genres...\n");
        $this->callWithLogging(UserNonRandomSeeder::class, "Seeding users...\n");
        $this->callWithLogging(HallSeeder::class, "Seeding halls...\n");
        $this->callWithLogging(MovieSeeder::class, "Seeding movies...\n");
        $this->callWithLogging(TagSeeder::class, "Seeding tags...\n");

        echo("Seeding random data..\n");
        $this->callWithLogging(UserSeeder::class, "Seeding users...\n");
        $this->callWithLogging(ScreeningSeeder::class, "Seeding screenings...\n");
        $this->callWithLogging(TicketSeeder::class, "Seeding tickets... this one might take a while\n");
        $this->callWithLogging(BusinessRequestSeeder::class, "Seeding adverts and bookings...\n");
        $this->callWithLogging(ReclamationSeeder::class, "Seeding reclamations...\n");

        echo("Running Advert Scheduler - You should optimally have a queue worker running \n");
        dispatch(new ScheduleAdverts());
        echo("Job dispatched\n");
        usleep(500000);
        echo('Seeding complete!');
    }

    protected function callWithLogging($seederClass, $message) : void
    {
        echo($message);
        $this->call($seederClass);
        echo("Done!\n");
    }
}
