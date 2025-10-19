<?php

namespace App\Http\Controllers\Api;

use App\DTO\TicketDTO;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Resources\TicketResource;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;

final class TicketController 
{
        public function __construct(
            private readonly TicketService $ticketService
        ) {
        }

        public function store(TicketStoreRequest $request): JsonResponse
        {
            $ticket = $this->ticketService->createTicket(
                TicketDTO::fromRequest(
                    $request->getCustomerData(),
                    $request->getTicketData(),
                    $request->file('attachments')
                )
            );

            return response()->json([
                'status' => 'success',
                'data' => TicketResource::make($ticket)
            ], JsonResponse::HTTP_CREATED);
        }
}