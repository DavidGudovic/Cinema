<?php

namespace Database\Seeders\Random;

use App\Enums\Roles;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\User;
use App\Services\SeatService;
use Illuminate\Database\Seeder;

/* !!! Extremely inefficient + more then 3000 database queries (needlessly)  !!!, only ran once, works,  so is fine TODO fix*/
class TicketSeeder extends Seeder
{
    public function run(SeatService $seatService): void
    {
        //Arrange data
        $tickets = Ticket::factory()->count(1000)->make();
        $screenings = Screening::all();

        $tickets->each(function ($ticket) use ($screenings) { // 1000 database queries..... TODO fix
            $ticket->user_id = User::where('role', Roles::CLIENT)->inRandomOrder()->first()->id;
        });

        //Attach screenings
        $screenings->each(function ($screening) use ($tickets, $seatService) {  // n
            //Attach 10- 16 tickets to each screening
            $screening->tickets()->saveMany($tickets->splice(0, fake()->numberBetween(10, 16))); // 300 - 500 database queries

            //Attach seats to each ticket
            $screening->tickets()->each(function ($ticket) use ($screening, $seatService) {  //n ^ n
                $seats = Seat::factory()->count(fake()->numberBetween(1, 6))->make();
                $takenSeats = $seatService->getTakenSeatsMap($screening);

                // Foreach seat make sure it's not taken and assign it to the ticket
                $seats->each(function ($seat) use ($takenSeats) {   // n ^ n ^ n
                    do {
                        $seat->row = fake()->numberBetween(1, 10);
                        $seat->column = fake()->numberBetween(1, 10);
                    } while (in_array([$seat->row, $seat->column], $takenSeats));

                    // Add the newly taken seat
                    $takenSeats[] = [$seat->row, $seat->column];
                });

                $ticket->seats()->saveMany($seats); // 10-16 * 300-500 database queries

                // Calculate ticket prices
                $ticket->technology_price_addon = $ticket->calc_technology_price_addon;
                $ticket->long_movie_addon = $ticket->calc_long_movie_addon;
                $ticket->subtotal = $ticket->calc_subtotal;
                $ticket->discount = $ticket->calc_discount;
                $ticket->total = $ticket->calc_total;
                $ticket->seat_count = $ticket->seats->count();
                $ticket->save();  // 10-16 * 300-500 database queries

            });
        });


    }
}
