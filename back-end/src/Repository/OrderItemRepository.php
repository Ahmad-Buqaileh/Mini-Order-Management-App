<?php

namespace App\Repository;

use App\Entity\OrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }

    public function save(OrderItem $orderItem, bool $flush = false): OrderItem
    {
        $this->getEntityManager()->persist($orderItem);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $orderItem;
    }

    public function remove(OrderItem $orderItem, bool $flush = false): void
    {
        $this->getEntityManager()->remove($orderItem);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
