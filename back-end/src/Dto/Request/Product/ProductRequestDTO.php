<?php

namespace App\Dto\Request\Product;

use Symfony\Component\Validator\Constraints as Assert;

class ProductRequestDTO
{
    #[Assert\NotBlank(message: "Name can't be empty")]
    private string $name;
    #[Assert\NotBlank(message: "Category can't be empty")]
    private string $category;
    #[Assert\NotBlank(message: "Price can't be empty")]
    private string $price;
    #[Assert\NotBlank(message: "Stock can't be empty")]
    #[Assert\PositiveOrZero]
    private int $stock;

    public function __construct(string $name, string $category, string $price, int $stock)
    {
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}
