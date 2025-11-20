<?php

namespace App\Dto\Request\CartItem;

use Symfony\Component\Validator\Constraints as Assert;

class AddCartItemRequestDTO
{
    #[Assert\NotBlank(message: "product id can't be empty")]
    private string $productId;
    #[Assert\NotBlank(message: "user id can't be empty")]
    private string $userId;
    #[Assert\NotBlank(message: "quantity can't be empty")]
    #[Assert\Range(notInRangeMessage: ("quantity can't be lower than 1 and higher that 100"), min: 1, max: 100), ]
    private int $quantity;

    public function __construct(string $productId, string $userId, int $quantity = 1)
    {
        $this->productId = $productId;
        $this->userId = $userId;
        $this->quantity = $quantity;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
