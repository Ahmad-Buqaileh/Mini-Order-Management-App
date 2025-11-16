<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProductsByName(string $name): array
    {
        return $this->createQueryBuilder('p')
            ->where('LOWER(p.name) LIKE LOWER(:name)')
            ->setParameter('name', '%' . strtolower($name) . '%')
            ->getQuery()
            ->getResult();
    }

    public function getProductsByCategory(string $category): array
    {
        return $this->createQueryBuilder('p')
            ->where('LOWER(p.category) LIKE LOWER(:category)')
            ->setParameter('category', '%' . strtolower($category) . '%')
            ->getQuery()
            ->getResult();
    }

    public function save(Product $product, bool $flush = false): Product
    {
        $this->getEntityManager()->persist($product);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $product;
    }

    public function remove(Product $product, bool $flush = false): void
    {
        $this->getEntityManager()->remove($product);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
