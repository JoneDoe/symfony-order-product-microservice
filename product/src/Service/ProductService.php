<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Request\ProductCreateRequest;
use Doctrine\ORM\EntityManagerInterface;
use SharedBundle\Amqp\Message\ProductSync;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly MessageBusInterface $messageBus
    ) {

    }

    public function createProduct(ProductCreateRequest $request): Product
    {
        $product = new Product();
        $product->setName($request->name);
        $product->setPrice($request->price);
        $product->setQuantity($request->quantity);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->messageBus->dispatch(new ProductSync(
            name: $product->getName(),
            id: $product->getId(),
            price: $product->getPrice(),
            quantity: $product->getQuantity()
        ));

        return $product;
    }

    public function updateProduct(Product $product, ProductCreateRequest $request): Product
    {
        $product->setName($request->name);
        $product->setPrice($request->price);
        $product->setQuantity($request->quantity);

        $this->entityManager->flush();

        $this->messageBus->dispatch(new ProductSync(
            name: $product->getName(),
            id: $product->getId(),
            price: $product->getPrice(),
            quantity: $product->getQuantity()
        ));

        return $product;
    }
}