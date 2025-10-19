<?php

namespace App\DTO;

use Illuminate\Http\UploadedFile;

final class TicketDTO
{
   public function __construct(
        public readonly string $customerName,
        public readonly string $customerEmail,
        public readonly string $customerPhone,
        public readonly string $subject,
        public readonly string $description,
        public readonly UploadedFile|array|null $attachments = null
    ) {
    }

    public static function fromRequest(array $customerData, array $ticketData, UploadedFile|array|null $attachments = null): self
    {
        return new self(
            customerName: $customerData['name'],
            customerEmail: $customerData['email'],
            customerPhone: $customerData['phone'],
            subject: $ticketData['subject'],
            description: $ticketData['description'],
            attachments: $attachments
        );
    }

    public function getCustomerData(): array
    {
        return [
            'name' => $this->customerName,
            'email' => $this->customerEmail,
            'phone' => $this->customerPhone,
        ];
    }

    public function getTicketData(): array
    {
        return [
            'subject' => $this->subject,
            'description' => $this->description,
        ];
    }
}