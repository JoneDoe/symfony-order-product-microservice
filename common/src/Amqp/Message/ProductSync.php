<?php

declare(strict_types=1);

namespace SharedBundle\Amqp\Message;

use Symfony\Component\Uid\Uuid;

readonly class ProductSync
{
    public function __construct(
        private string $name,
        private Uuid $id,
        private float $price,
        private int $quantity
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}