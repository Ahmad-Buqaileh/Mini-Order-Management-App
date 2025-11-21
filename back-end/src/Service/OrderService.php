<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Security\JwtService;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class OrderService
{
    private OrderRepository $orderRepository;
    private UserRepository $userRepository;
    private CartRepository $cartRepository;
    private CartItemRepository $cartItemRepository;
    private OrderItemRepository $orderItemRepository;
    private JwtService  $jwtService;

    public function __construct(OrderRepository     $orderRepository, UserRepository $userRepository,
                                CartRepository      $cartRepository, CartItemRepository $cartItemRepository,
                                OrderItemRepository $orderItemRepository, JwtService $jwtService)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->jwtService = $jwtService;
    }

    public function getOrderItems(string $orderId): array
    {
        $order = $this->orderRepository->find($orderId);
        if(!$order){
            throw new \RuntimeException('Order not found');
        }
        return array_map(function (OrderItem $item) {
            return [
                'id' => $item->getId(),
                'productName' => $item->getProduct()->getName(),
                'quantity' => $item->getQuantity(),
                'price' => $item->getProduct()->getPrice(),
                'subtotal' => $item->getSubtotal(),
            ];
        }, $order->getItems()->toArray());
    }

    public function getUserOrders(string $userToken): array
    {
        $userId = $this->jwtService->getUserIdFromToken($userToken);
        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new UserNotFoundException('User not found');
        }
        $orders = $this->orderRepository->findBy(['user' => $user]);
        return array_map(static function (Order $order) {
            return [
                'id' => $order->getId(),
                'total' => $order->getTotal(),
                'createdAt' => $order->getCreatedAt(),
            ];
        }, $orders);
    }

    public function createOrderFromUserCart(string $userToken): Order
    {
        $userId = $this->jwtService->getUserIdFromToken($userToken);
        $user = $this->userRepository->find($userToken);
        if (!$user) {
            throw new UserNotFoundException('User not found');
        }
        $cart = $this->cartRepository->findOneBy(['user' => $user]);
        if (!$cart) {
            throw new \RuntimeException('Cart not found');
        }
        $cartItems = $cart->getItems();
        if ($cartItems === null || $cartItems->isEmpty()) {
            throw new \RuntimeException('Cart items not found');
        }
        $order = new Order();
        $order->setUser($user);
        $total = 0.0;
        foreach ($cartItems as $item) {
            $product = $item->getProduct();
            $quantity = $item->getQuantity();
            if ($product->getStock() < $quantity) {
                throw new \RuntimeException('Stock not available for product: ' . $product->getName());
            }
            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $orderItem->setProduct($product);
            $orderItem->setQuantity($quantity);
            $subtotal = (float)$product->getPrice() * $quantity;
            $orderItem->setSubtotal(number_format($subtotal, 2, '.', ''));
            $this->orderItemRepository->save($orderItem, true);
            $total += $subtotal;
            $product->setStock($product->getStock() - $quantity);
        }
        $order->setTotal($total);
        $this->orderRepository->save($order, true);
        foreach ($cartItems as $cartItem) {
            $this->cartItemRepository->remove($cartItem, true);
        }
        return $order;
    }
}
