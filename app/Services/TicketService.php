<?php

namespace App\Services;

use App\DTO\TicketDTO;
use App\Enums\Ticket\Status;
use App\Models\Ticket;
use App\Repositories\CustomerRepository;
use App\Repositories\TicketRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

final class TicketService
{
   public function __construct(
        private readonly TicketRepository $ticketRepository,
        private readonly CustomerRepository $customerRepository,
    ) {
    }

    public function createTicket(TicketDTO $dto): Ticket
    {

        return DB::transaction(function () use ($dto) {
            $customer = $this->customerRepository->updateOrCreate(
                ['email' => $dto->customerEmail],
                $dto->getCustomerData()
            );

            $ticket = $this->customerRepository->createTicket(
                $customer,
                [
                    ...$dto->getTicketData(),
                    'status' => Status::new()->value,
                ]
            );

           if ($dto->attachments) {
                $this->attachFiles($ticket, $dto->attachments);
            }

            return $ticket->load(['customer', 'media']);
        });
    }

    private function attachFiles(Ticket $ticket, UploadedFile|array $files): void
    {
        if (is_array($files)) {
            foreach ($files as $file) {
                $ticket->addMedia($file)->toMediaCollection('attachments');
            }
        } else {
            $ticket->addMedia($files)->toMediaCollection('attachments');
        }
    }
}
