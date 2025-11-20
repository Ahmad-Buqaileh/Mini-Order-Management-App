<?php

namespace App\Service;

use App\Dto\Request\CartItem\AddCartItemRequestDTO;
use App\Dto\Request\CartItem\UpdateCartItemQuantityDTO;
use App\Entity\CartItem;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class CartItemService
{
    private ProductRepository $productRepository;
    private CartRepository $cartRepository;
    private UserRepository $userRepository;
    private CartItemRepository $cartItemRepository;

    public function __construct(ProductRepository  $productRepository, CartRepository $cartRepository,
                                CartItemRepository $cartItemRepository, UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->userRepository = $userRepository;
    }

    public function getCartItem(string $cartId, string $productId): object
    {
        $cart = $this->cartRepository->find($cartId);
        if (!$cart) {
            throw new \RuntimeException('Cart not found');
        }
        $product = $this->productRepository->find($productId);
        if (!$product) {
            throw new \RuntimeException('Product not found');
        }
        return $this->cartItemRepository->findOneBy([
            'cart' => $cart,
            'product' => $product,
        ]);
    }

    public function addItemToCart(AddCartItemRequestDTO $dto): CartItem
    {
        $user = $this->userRepository->find(['id' => $dto->getUserId()]);
        if (!$user) {
            throw new UserNotFoundException('User not found');
        }
        $cart = $this->cartRepository->findOneBy(['user' => $user]);
        if (!$cart) {
            throw new \RuntimeException('Cart not found');
        }
        $product = $this->productRepository->find($dto->getProductId());
        if (!$product) {
            throw new \RuntimeException('Product not found');
        }
        if ($product->getStock() < $dto->getQuantity()) {
            throw new \RuntimeException('Product out of stock');
        }
        $cartItem = $this->cartItemRepository->findOneBy([
            'cart' => $cart,
            'product' => $product,
        ]);
        if ($cartItem) {
            $newQuantity = $cartItem->getQuantity() + $dto->getQuantity();
            $cartItem->setQuantity($newQuantity);
        } else {
            $cartItem = new CartItem();
            $cartItem->setProduct($product);
            $cartItem->setCart($cart);
            $cartItem->setQuantity($dto->getQuantity());
        }
        $price = (float)$product->getPrice();
        $subtotal = $price * $cartItem->getQuantity();
        $cartItem->setSubtotal(number_format($subtotal, 2, '.', ''));
        $this->cartItemRepository->save($cartItem, true);
        return $cartItem;
    }

    public function updateQuantity(UpdateCartItemQuantityDTO $dto): object
    {
        $cartItem = $this->cartItemRepository->find($dto->getCartItemId());
        if (!$cartItem) {
            throw new \RuntimeException('Cart item not found');
        }
        $product = $cartItem->getProduct();
        if ($product->getStock() < $dto->getQuantity()) {
            throw new \RuntimeException('Not enough product stock');
        }
        $cartItem->setQuantity($dto->getQuantity());
        $cartItem->setSubtotal(number_format($dto->getQuantity() * $product->getPrice(), 2, '.', ''));
        $this->cartItemRepository->save($cartItem, true);
        return $cartItem;
    }

    public function removeItemFromCart(string $cartItemId): void
    {
        $cartItem = $this->cartItemRepository->find($cartItemId);
        if (null == $cartItem) {
            throw new \RuntimeException('Cart item not found');
        }
        $this->cartItemRepository->remove($cartItem, true);
    }
}
