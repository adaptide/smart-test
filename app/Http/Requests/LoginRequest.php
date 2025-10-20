<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
   
    public function rules(): array
    {
        return [
            'email' => 'required|email:dns|exists:users,email',
            'password' => 'required|string|min:8',
        ];
    }
}
