<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'order_items')]
#[ORM\HasLifecycleCallbacks]
class OrderItem
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    private string $id;
    #[ORM\Column(nullable: false)]
    private int $quantity;
    #[ORM\Column(type: 'decimal', scale: 2, nullable: false)]
    private string $subtotal;
    #[ORM\ManyToOne(targetEntity: Order::class, cascade: ['persist', 'remove'], inversedBy: "items")]
    #[ORM\JoinColumn(name: "order_id", referencedColumnName: "id", nullable: false)]
    private Order $order;
    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id", nullable: false)]
    private Product $product;

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->id = Uuid::uuid7()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getSubtotal(): string
    {
        return $this->subtotal;
    }

    public function setSubtotal(string $subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
}
