<?php

declare(strict_types=1);

namespace App\Enum;

enum OrderStatus: string
{
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';
    case FAILED = 'failed';

    public function capitalize(): string
    {
        return ucfirst($this->value);
    }
}