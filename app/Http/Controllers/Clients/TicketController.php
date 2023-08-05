<?php

namespace App\Http\Controllers\Clients;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketEmail;


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
        $mailable = new TicketEmail($user->username, $ticket->screening->movie->title, $user, $ticket);
        Mail::to($user->email)->send($mailable);

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
