<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email:dns|max:255',
            'phone' => 'required|string|regex:/^\+[1-9]\d{1,14}$/',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx',
        ];
    }

    public function getCustomerData(): array
    {
        return [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
        ];
    }

    public function getTicketData(): array
    {
        return [
            'subject' => $this->input('subject'),
            'description' => $this->input('description'),
        ];
    }
}
