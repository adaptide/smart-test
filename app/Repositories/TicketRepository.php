<?php

namespace App\Repositories;

use App\Enums\Ticket\Status;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TicketRepository
{
    public function findById(int $id): ?Ticket
    {
        return Ticket::with(['customer', 'media'])->find($id);
    }

    public function getFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Ticket::query()
            ->with(['customer'])
            ->filterByEmail($filters['email'] ?? null)
            ->filterByPhone($filters['phone'] ?? null)
            ->filterByStatus($filters['status'] ?? null)
            ->filterByDateRange($filters['date_from'] ?? null, $filters['date_to'] ?? null)
            ->latest()
            ->paginate($perPage);
    }

    public function updateStatus(Ticket $ticket, Status $status): bool
    {
        return $ticket->update(['status' => $status->value]);
    }


    public function addManagerResponse(Ticket $ticket, string $response): bool
    {
        return $ticket->update([
            'manager_response' => $response,
            'response_at' => now(),
            'status' => Status::processed(),
        ]);
    }

    public function getStatistics(?string $period = null): array
    {
        $query = Ticket::query();

        $query = match ($period) {
            'today' => $query->createdToday(),
            'week' => $query->createdThisWeek(),
            'month' => $query->createdThisMonth(),
            default => $query,
        };

        return [
            'total' => $query->count(),
            'new' => $query->clone()->byStatus(Status::new())->count(),
            'in_progress' => $query->clone()->byStatus(Status::inProgress())->count(),
            'processed' => $query->clone()->byStatus(Status::processed())->count(),
        ];
    }
}