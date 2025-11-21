<?php

namespace App\Dto\Response\CartItem;

use App\Entity\CartItem;

class CartItemResponseDTO
{
    public string $id;
    public string $productId;
    public int $quantity;
    public float $subtotal;
    public array $product;

    public function __construct(CartItem $item)
    {
        $this->id = $item->getId();
        $this->productId = $item->getProduct()->getId();
        $this->quantity = $item->getQuantity();
        $this->subtotal = (float)$item->getSubtotal();
        $this->product = [
            'name' => $item->getProduct()->getName(),
            'price' => $item->getProduct()->getPrice(),
            'stock' => $item->getProduct()->getStock(),
        ];
    }
}
