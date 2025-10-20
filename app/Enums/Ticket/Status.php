<?php

namespace App\Enums\Ticket;

use Spatie\Enum\Enum;

/**
 * @method static self new()
 * @method static self inProgress()
 * @method static self processed()
 */
class Status extends Enum
{
    public static function getBadgeClass(string $status): string
    {
        return match ($status) {
            'new' => 'bg-blue-100 text-blue-800',
            'inProgress' => 'bg-yellow-100 text-yellow-800',
            'processed' => 'bg-green-100 text-green-800',
        };
    }

    public static function getLabel(string $status): string
    {
        return match ($status) {
            'new' => 'Новая',
            'inProgress' => 'В процессе',
            'processed' => 'Обработана',
        };
    }
}
