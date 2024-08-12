<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class OrderCreateRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $customerName;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public string $productUuid;

    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    public int $quantity;
}