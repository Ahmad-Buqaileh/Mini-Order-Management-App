<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: "orders")]
#[ORM\HasLifecycleCallbacks]
class Order
{
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    private string $id;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "orders")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", nullable: false)]
    private User $user;
    #[ORM\Column(name: "total", type: "decimal", scale: 2, nullable: false)]
    private string $total = "0.00";
    #[ORM\Column(name: "created_at", type: "datetime_immutable")]
    private \DateTimeImmutable $createdAt;
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: "order", cascade: ['persist', 'remove'], fetch: 'LAZY',
        orphanRemoval: true)]
    private Collection $items;

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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getTotal(): string
    {
        return $this->total;
    }

    public function setTotal(string $total): void
    {
        $this->total = $total;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }
}
