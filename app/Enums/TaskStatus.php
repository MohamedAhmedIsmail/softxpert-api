<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public static function values(): array
    {
        return array_map(fn(self $s) => $s->value, self::cases());
    }
}
