<?php

namespace App\Http\Requests;

use App\Enums\Ticket\Status;
use App\Enums\User\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketStatusUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(Role::manager()->value);
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::in(Status::cases())],
        ];
    }

}
