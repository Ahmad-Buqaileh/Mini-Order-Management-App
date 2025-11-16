<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use RuntimeException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class CartService
{
    private CartRepository $cartRepository;
    private UserRepository $userRepository;

    public function __construct(CartRepository $cartRepository, UserRepository $userRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
    }

    public function getCartItems(string $id): array
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if (!$user) {
            throw new UserNotFoundException("User not found");
        }
        $cart = $this->cartRepository->findOneBy(['user' => $user]);
        if (!$cart) {
            throw new RuntimeException("Cart not found for this user.");
        }
        return array_map(static function (CartItem $item) {
            return [
                'id' => $item->getId(),
                'quantity' => $item->getQuantity(),
                'subtotal' => $item->getSubtotal(),
                'product' => [
                    'id' => $item->getProduct()->getId(),
                    'name' => $item->getProduct()->getName(),
                    'price' => $item->getProduct()->getPrice(),
                ],
            ];
        }, $cart->getItems()->toArray());
    }

    public
    function createCartForUser(string $userId): Cart
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new UserNotFoundException('User not found.');
        }
        $existingCart = $this->cartRepository->findOneBy(['user' => $user]);
        if (null != $existingCart) {
            throw new RuntimeException('The cart already exists.');
        }
        $cart = new Cart();
        $cart->setUser($user);
        $this->cartRepository->save($cart, true);
        return $cart;
    }
}
