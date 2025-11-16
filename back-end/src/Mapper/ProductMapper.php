<?php

namespace App\Mapper;

use App\Dto\Request\Product\ProductRequestDTO;
use App\Entity\Product;

class ProductMapper
{
    public static function toEntity(ProductRequestDTO $requestDto): Product
    {
        $product = new Product();
        $product->setName($requestDto->getName());
        $product->setCategory($requestDto->getCategory());
        $product->setPrice($requestDto->getPrice());
        $product->setStock($requestDto->getStock());
        return $product;
    }
}
