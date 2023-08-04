<?php

namespace App\Http\Controllers\Clients;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Services\TicketService;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user, TicketService $ticketService)
    {
        return view('users.tickets.index', [
            'tickets' => $ticketService->getUsersTickets($user),
            'movies' => $ticketService->getUniqueMovies($user)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Ticket $ticket, TicketService $ticketService)
    {
        return view('users.tickets.show', [
            'ticket' => $ticketService->getTicket($ticket->id)
        ]);
    }
}
