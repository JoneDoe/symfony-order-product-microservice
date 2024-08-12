<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\Uid\Uuid;

readonly class ProductResponse implements \JsonSerializable
{
    public function __construct(
        private string $name,
        private Uuid $id,
        private float $price,
        private int $quantity
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }
}