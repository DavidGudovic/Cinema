<?php
namespace App\Services;

use App\Models\User;

class TicketService{
    public function getUsersTickets(User $user){
        return $user->tickets()->with('screenings.movie')->paginate(10);
    }
}
