<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Services\Resources\TicketService;


class TicketController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index(User $user, TicketService $ticketService)
    {
        return view('users.tickets.index', [
            'tickets' => $ticketService->getUsersTickets($user),
            'movies' => $ticketService->getUniqueMovies($user),
            'user' => $user
        ]);
    }

    /**
    * Display the specified resource.
    */
    public function show(User $user, Ticket $ticket, TicketService $ticketService)
    {
        $ticketService->sendTicketEmail($user, $ticket);

        return view('users.tickets.show', [
            'ticket' => $ticket,
            'user' => $user,
        ]);
    }

    /**
    * Print the specified resource.
    */
    public function print(User $user, Ticket $ticket, TicketService $ticketService)
    {
        return $ticketService->getTicketPDF($user, $ticket)->download('ticket.pdf');
    }
}
