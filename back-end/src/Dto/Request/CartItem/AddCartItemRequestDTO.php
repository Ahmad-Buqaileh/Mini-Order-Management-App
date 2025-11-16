<?php

namespace App\Dto\Request\CartItem;

use Symfony\Component\Validator\Constraints as Assert;

class AddCartItemRequestDTO
{
    #[Assert\NotBlank(message: "product id can't be empty")]
    private string $productId;
    #[Assert\NotBlank(message: "cart id can't be empty")]
    private string $cartId;
    #[Assert\NotBlank(message: "quantity can't be empty")]
    #[Assert\Range(notInRangeMessage: ("quantity can't be lower than 1 and higher that 100"), min: 1, max: 100), ]
    private int $quantity;

    public function __construct(string $productId, string $cartId, int $quantity = 1)
    {
        $this->productId = $productId;
        $this->cartId = $cartId;
        $this->quantity = $quantity;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
