<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class ProductCreateRequest
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public string $id;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Positive]
    public float $price;

    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    public int $quantity;
}