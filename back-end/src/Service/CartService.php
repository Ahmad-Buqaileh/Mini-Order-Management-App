<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use App\Security\JwtService;
use RuntimeException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class CartService
{
    private CartRepository $cartRepository;
    private UserRepository $userRepository;
    private JwtService $jwtService;

    public function __construct(CartRepository $cartRepository, UserRepository $userRepository, JwtService $jwtService)
    {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
        $this->jwtService = $jwtService;
    }

    public function getCartItems(string $userToken): array
    {
        $userId = $this->jwtService->getUserIdFromToken($userToken);
        $user = $this->userRepository->findOneBy(['id' => $userId]);
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
                    'stock' => $item->getProduct()->getStock(),
                ],
            ];
        }, $cart->getItems()->toArray());
    }

    public
    function createCartForUser(string $userToken): Cart
    {
        $userId = $this->jwtService->getUserIdFromToken($userToken);
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
