<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Repository\ProductRepository;
use App\Request\OrderCreateRequest;
use Doctrine\ORM\EntityManagerInterface;

readonly class OrderService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ProductRepository $productRepository
    ) {
    }

    public function create(OrderCreateRequest $request): Order
    {
        $product = $this->productRepository->findByUuid($request->productUuid);
        if (null === $product) {
            throw new \InvalidArgumentException('Product not found');
        }

        if ($product->getQuantity() < $request->quantity) {
            throw new \InvalidArgumentException('Not enough product quantity');
        }

        $order = new Order();
        $order->setCustomerName($request->customerName);
        $order->setQuantity($request->quantity);
        $order->setProduct($product);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }
}