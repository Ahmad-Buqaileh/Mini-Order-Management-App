<?php

namespace App\Service;

use App\Entity\Product;
use App\Mapper\ProductMapper;
use App\Repository\ProductRepository;
use App\Dto\Request\Product\ProductRequestDTO;
use RuntimeException;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(ProductRequestDTO $dto): Product
    {
        $product = ProductMapper::toEntity($dto);
        $this->productRepository->save($product, true);
        return $product;
    }

    public function getAllProducts(): array
    {
        $products = $this->productRepository->findAll();
        if (empty($products)) {
            throw new RuntimeException('No products found');
        }
        return $products;
    }

    public function getProductsByName(string $name): array
    {
        $products = $this->productRepository->getProductsByName($name);
        if (empty($products)) {
            throw new RuntimeException('No products found');
        }
        return $products;
    }

    public function getProductsByCategory(string $category): array
    {
        $products = $this->productRepository->getProductsByCategory($category);
        if (empty($products)) {
            throw new RuntimeException('No products found');
        }
        return $products;
    }

    public function getProductById(string $id): object|string
    {
        $product = $this->productRepository->find($id);
        if (empty($product)) {
            throw new RuntimeException('Product not found');
        }
        return $product;
    }

    public function removeProduct(string $id): void
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw new RuntimeException('Product not found');
        }
        try {
            $this->productRepository->remove($product, true);
        } catch (\Exception $e) {
            throw new RuntimeException('Unable to remove product');
        }
    }
}
