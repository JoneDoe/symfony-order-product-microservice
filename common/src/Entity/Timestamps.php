<?php

declare(strict_types=1);

namespace SharedBundle\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait Timestamps
{
     #[ORM\Column(name: "created_at", type: "datetime", nullable: true)]
    private ?DateTimeInterface $createdAt;

    #[ORM\Column(name: "updated_at", type: "datetime", nullable: true)]
    private ?DateTimeInterface $updatedAt;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $timestamp): self
    {
        $this->createdAt = $timestamp;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $timestamp): self
    {
        $this->updatedAt = $timestamp;

        return $this;
    }


    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->setUpdatedAtValue();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}