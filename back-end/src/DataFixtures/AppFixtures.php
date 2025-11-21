<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;

class AppFixtures extends Fixture
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function load(ObjectManager $manager): void
    {
        $products = [
            ['name' => 'Smartphone X12', 'category' => 'electronics', 'price' => '899.99', 'stock' => 20],
            ['name' => 'Bluetooth Headphones', 'category' => 'electronics', 'price' => '129.99', 'stock' => 10],
            ['name' => '4K Monitor 27"', 'category' => 'electronics', 'price' => '349.00', 'stock' => 5],
            ['name' => 'Gaming Keyboard RGB', 'category' => 'electronics', 'price' => '79.99', 'stock' => 30],
            ['name' => 'Portable Power Bank', 'category' => 'electronics', 'price' => '45.00', 'stock' => 12],
            ['name' => 'Moisturizing Cream', 'category' => 'beauty', 'price' => '24.50', 'stock' => 50],
            ['name' => 'Perfume Deluxe', 'category' => 'beauty', 'price' => '79.00', 'stock' => 0],
            ['name' => 'Hair Conditioner Pro', 'category' => 'beauty', 'price' => '12.00', 'stock' => 25],
            ['name' => 'Facial Cleanser Fresh', 'category' => 'beauty', 'price' => '15.75', 'stock' => 8],
            ['name' => 'Lipstick Velvet Red', 'category' => 'beauty', 'price' => '9.99', 'stock' => 0],
            ['name' => 'Air Fryer Pro', 'category' => 'home-kitchen', 'price' => '129.99', 'stock' => 15],
            ['name' => 'Pressure Cooker 6L', 'category' => 'home-kitchen', 'price' => '89.99', 'stock' => 0],
            ['name' => 'Stainless Knife Set', 'category' => 'home-kitchen', 'price' => '59.99', 'stock' => 40],
            ['name' => 'Electric Kettle 1.7L', 'category' => 'home-kitchen', 'price' => '29.99', 'stock' => 12],
            ['name' => 'Non-stick Pan 30cm', 'category' => 'home-kitchen', 'price' => '34.50', 'stock' => 22],
            ['name' => 'Men\'s Running Shoes', 'category' => 'fashion', 'price' => '78.00', 'stock' => 0],
            ['name' => 'Women Jacket Classic', 'category' => 'fashion', 'price' => '120.00', 'stock' => 8],
            ['name' => 'Unisex Hoodie Black', 'category' => 'fashion', 'price' => '49.99', 'stock' => 15],
            ['name' => 'Men Slim Fit Jeans', 'category' => 'fashion', 'price' => '59.00', 'stock' => 5],
            ['name' => 'Women Sneakers White', 'category' => 'fashion', 'price' => '68.00', 'stock' => 11],
        ];
        $em = $this->registry->getManagerForClass(Product::class);
        $repo = $em->getRepository(Product::class);
        foreach ($products as $data) {
            $existing = $repo->findOneBy([
                'name' => $data['name'],
                'category' => $data['category']
            ]);
            if ($existing) {
                continue;
            }
            $product = new Product();
            $product->setName($data['name']);
            $product->setCategory($data['category']);
            $product->setPrice($data['price']);
            $product->setStock($data['stock']);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
