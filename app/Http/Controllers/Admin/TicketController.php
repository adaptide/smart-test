<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Ticket\Status;
use App\Http\Requests\TicketStatusUpdateRequest;
use App\Models\Ticket;
use App\Repositories\TicketRepository;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController 
{
    public function __construct(
        private readonly TicketRepository $ticketRepository,
        private readonly TicketService $ticketService,
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['email', 'phone', 'status', 'date_from', 'date_to']);
        
        $tickets = $this->ticketRepository->getFiltered($filters);
        $statistics = $this->ticketRepository->getStatistics();
        return view('admin.tickets.index', compact('tickets', 'statistics'));
    }

    public function show(Ticket $ticket): View
    {
        $ticket->load(['customer', 'media']);
        
        return view('admin.tickets.show', compact('ticket'));
    }

    public function updateStatus(TicketStatusUpdateRequest $request, Ticket $ticket)
    {
        $status = Status::from($request->input('status'));

        $this->ticketService->updateStatus($ticket, $status);

        return redirect()->route('admin.tickets.show', $ticket)
            ->with('success', 'Статус заявки успешно обновлен');
    }

    public function addResponse(Request $request, Ticket $ticket)
    {
        $request->validate([
            'response' => 'required|string|max:5000',
        ]);
        
        $this->ticketService->addManagerResponse(
            $ticket,
            $request->input('response')
        );

        return redirect()->route('admin.tickets.show', $ticket)
            ->with('success', 'Ответ успешно добавлен');
    }
}