<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use SharedBundle\Entity\SharedProduct;
use SharedBundle\Entity\Timestamps;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ORM\Table(name: 'products')]
class Product extends SharedProduct
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $productUuid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductUuid(): Uuid
    {
        return $this->productUuid;
    }

    public function setProductUuid(Uuid $productUuid): self
    {
        $this->productUuid = $productUuid;

        return $this;
    }
}
