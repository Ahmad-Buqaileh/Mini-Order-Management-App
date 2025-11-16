<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
#[ORM\HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    private string $id;
    #[ORM\Column(nullable: false)]
    private string $name;
    #[ORM\Column(nullable: false)]
    private string $category;
    #[ORM\Column(type: 'decimal', scale: 2, nullable: false)]
    private string $price;
    #[ORM\Column(type: 'integer', nullable: false)]
    private int $stock = 0;
    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->id = Uuid::uuid7()->toString();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
