<?php

namespace Database\Seeders\Random;

use App\Enums\Roles;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\User;
use App\Services\Resources\SeatService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/* Inefficient */
class TicketSeeder extends Seeder
{
    public function run(SeatService $seatService): void
    {
        DB::transaction(function () use ($seatService) {
            $screenings = Screening::all();

            $screenings->each(function ($screening) use ($seatService) {
                $tickets = $this->createTickets();
                $screening->tickets()->saveMany($tickets);
                $this->assignSeatsAndCalculatePrices($screening, $seatService);
            });
        });
    }

    /**
     * Create a random number of tickets for a screening
     * Each ticket is assigned to a random client
     */
    private function createTickets(): Collection
    {
        $tickets = Ticket::factory()->count(fake()->numberBetween(5, 10))->make();
        $tickets->each(fn ($ticket) => $ticket->user_id = User::isRole(Roles::CLIENT)->inRandomOrder()->first()->id);

        return $tickets;
    }

    /**
     * Assign seats to each ticket and calculate the prices
     * The seats are assigned randomly, but not to the same seat twice
     * The prices are calculated based on the ticket's attributes
     */
    private function assignSeatsAndCalculatePrices(Screening $screening, SeatService $seatService): void
    {
        $takenSeats = $seatService->getTakenSeatsMap($screening);

        $screening->tickets()->each(function ($ticket) use ($screening, $seatService, &$takenSeats) {
            $this->assignSeats($ticket, $takenSeats);
            $this->calculateTicketPricesOrMarkCancelled($ticket);
        });
    }

    /**
     * Assign seats to a ticket
     * The seats are assigned randomly, but not to the same seat twice
     */
    private function assignSeats(Ticket $ticket, array &$takenSeats): void
    {
        $seats = Seat::factory()->count(fake()->numberBetween(0, 6))->make();

        $seats->each(function ($seat) use (&$takenSeats) {
            do {
                $seat->row = fake()->numberBetween(1, 10);
                $seat->column = fake()->numberBetween(1, 10);
            } while (in_array([$seat->row, $seat->column], $takenSeats));
            $takenSeats[] = [$seat->row, $seat->column];
        });

        $ticket->seats()->saveMany($seats);;
    }

    /**
     * Calculate the prices for a ticket
     */
    private function calculateTicketPricesOrMarkCancelled(Ticket $ticket): void
    {
        $ticket->technology_price_addon = $ticket->calc_technology_price_addon;
        $ticket->long_movie_addon = $ticket->calc_long_movie_addon;
        $ticket->subtotal = $ticket->calc_subtotal;
        $ticket->discount = $ticket->calc_discount;
        $ticket->total = $ticket->calc_total;

        if($ticket->seats->count() == 0){
            $ticket->deleted_at = now();
            $ticket->seat_count = 0;
        } else {
            $ticket->seat_count = $ticket->seats->count();
        }

        $ticket->save();
    }
}
