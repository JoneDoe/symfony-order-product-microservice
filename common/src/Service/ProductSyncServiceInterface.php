<?php

declare(strict_types=1);

namespace SharedBundle\Service;

use SharedBundle\Amqp\Message\ProductSync;

interface ProductSyncServiceInterface
{
    public function sync(ProductSync $message): void;
}