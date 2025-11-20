<?php

namespace App\Dto\Request\CartItem;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateCartItemQuantityDTO
{
    #[Assert\NotBlank(message: "cart item quantity can't be empty")]
    private string $cartItemId;
    #[Assert\NotBlank(message: "cart item quantity can't be empty")]
    #[Assert\Positive(message: ("quantity must be over 0")), ]
    private int $quantity;

    public function __construct(string $cartItemId, int $quantity)
    {
        $this->cartItemId = $cartItemId;
        $this->quantity = $quantity;
    }

    public function getCartItemId(): string
    {
        return $this->cartItemId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
