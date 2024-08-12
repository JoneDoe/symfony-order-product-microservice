<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use SharedBundle\Amqp\Message\ProductSync;
use SharedBundle\Service\ProductSyncServiceInterface;

readonly class ProductService implements ProductSyncServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ProductRepository $productRepository
    ) {

    }

    public function sync(ProductSync $message): void
    {
        $product = $this->productRepository->findByUuid((string)$message->getId());

        if (null === $product) {
            $product = new Product();
            $this->entityManager->persist($product);
            $product->setProductUuid($message->getId());
        }

        $product->setName($message->getName());
        $product->setPrice($message->getPrice());
        $product->setQuantity($message->getQuantity());

        $this->entityManager->flush();
    }
}