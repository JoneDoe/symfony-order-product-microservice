<?php

declare(strict_types=1);

namespace SharedBundle\Amqp\Handler;

use SharedBundle\Amqp\Message\ProductSync;
use SharedBundle\Service\ProductSyncServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ProductSyncHandler
{
    public function __construct(
        private ProductSyncServiceInterface $productSyncService,
    ) {
    }

    public function __invoke(ProductSync $message): void
    {
        $this->productSyncService->sync($message);
    }
}