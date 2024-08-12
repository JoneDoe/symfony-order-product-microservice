<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Order;
use App\Response\OrderResponse;
use App\Response\ProductResponse;

class OrderTransformer
{
    public function transform(Order $order): OrderResponse
    {
        return new OrderResponse(
            customer: $order->getCustomerName(),
            id: $order->getId(),
            status: $order->getStatus(),
            quantity: $order->getQuantity(),
            product: new ProductResponse(
                name: $order->getProduct()->getName(),
                id: $order->getProduct()->getProductUuid(),
                price: $order->getProduct()->getPrice(),
                quantity: $order->getProduct()->getQuantity()
            )
        );
    }

    public function transformToList(array $orders): array
    {
        return [
            'data' => array_map(
                fn (Order $order) => $this->transform($order),
                $orders
            ),
        ];
    }
}