<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class CustomerRepository
{
    public function createTicket(Customer $customer, array $data): Model
    {
        return $customer->tickets()->create([
            'subject' => $data['subject'],
            'description' => $data['description'],
            'status' => $data['status'],
        ]);
    }

    public function updateOrCreate(array $attributes, array $values): Customer
    {
        return Customer::updateOrCreate($attributes, $values);
    }
}