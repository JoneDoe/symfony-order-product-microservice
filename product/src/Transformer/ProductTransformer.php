<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Product;
use App\Response\ProductResponse;

class ProductTransformer
{
    public function transform(Product $product): ProductResponse
    {
        return new ProductResponse(
            name: $product->getName(),
            id: $product->getId(),
            price: $product->getPrice(),
            quantity: $product->getQuantity()
        );
    }

    public function transformToList(array $products): array
    {
        return [
            'data' => array_map(
                fn (Product $product) => $this->transform($product),
                $products
            ),
        ];
    }
}