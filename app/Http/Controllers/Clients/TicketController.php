<?php

namespace App\Http\Controllers\Clients;

use App\Models\User;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
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
            'movies' => $ticketService->getUniqueMovies($user),
            'user' => $user
        ]);
    }

    /**
    * Display the specified resource.
    */
    public function show(User $user, Ticket $ticket, TicketService $ticketService)
    {
        return view('users.tickets.show', [
            'ticket' => $ticketService->getTicket($ticket->id),
            'user' => $user
        ]);
    }

    /**
    * Print the specified resource.
    */
    public function print(User $user, Ticket $ticket)
    {
        return PDF::loadView('pdf.ticket', [
            'ticket' => $ticket,
            'user' => $user,
            'movie' => $ticket->screening->movie,
            'screening' => $ticket->screening,
            'seats' => $ticket->seats
            ])
            ->setPaper('a5', 'landscape')
            ->download('ticket.pdf');
    }
}
