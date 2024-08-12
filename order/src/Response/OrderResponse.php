<?php

declare(strict_types=1);

namespace App\Response;

use App\Enum\OrderStatus;
use Symfony\Component\Uid\Uuid;

readonly class OrderResponse implements \JsonSerializable
{
    public function __construct(
        private string $customer,
        private Uuid $id,
        private string $status,
        private int $quantity,
        private ProductResponse $product
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'orderId' => $this->id,
            'customerName' => $this->customer,
            'orderStatus' => OrderStatus::from($this->status)->capitalize(),
            'quantityOrdered' => $this->quantity,
            'product' => $this->product
        ];
    }
}