<?php

namespace App\Models;

use App\Enums\Ticket\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;


class Ticket extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'customer_id',
        'subject',
        'description',
        'status',
        'response_at',
        'manager_response',
    ];

    protected $casts = [
        'response_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeCreatedToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeCreatedThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeCreatedThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    public function scopeByStatus(Builder $query, Status $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeFilterByEmail(Builder $query, ?string $email): Builder
    {
        return $query->when($email, fn($q) => $q->whereHas('customer', fn($q) => $q->where('email', 'like', "%{$email}%")));
    }

    public function scopeFilterByPhone(Builder $query, ?string $phone): Builder
    {
        return $query->when($phone, fn($q) => $q->whereHas('customer', fn($q) => $q->where('phone', 'like', "%{$phone}%")));
    }

    public function scopeFilterByStatus(Builder $query, ?string $status): Builder
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }

    public function scopeFilterByDateRange(Builder $query, ?string $dateFrom, ?string $dateTo): Builder
    {
        return $query->when($dateFrom, fn($q) => $q->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->whereDate('created_at', '<=', $dateTo));
    }
}
