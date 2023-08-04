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
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user, Ticket $ticket, TicketService $ticketService)
    {
        $ticketService->createTicket($request, $user, $ticket);
        return redirect()->route('resources.screenings.ticket.store', $ticket);
    }

}
