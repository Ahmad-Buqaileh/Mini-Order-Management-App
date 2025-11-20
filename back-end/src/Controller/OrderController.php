<?php

namespace App\Controller;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/orders')]
class OrderController extends AbstractController
{
    private OrderService $orderService;
    private ValidatorInterface $validator;

    public function __construct(OrderService $orderService, ValidatorInterface $validator)
    {
        $this->orderService = $orderService;
        $this->validator = $validator;
    }

    #[Route('/order/{orderId}', name: 'api_orders_order_get', methods: ['GET'])]
    public function getOrderItems(string $orderId): JsonResponse
    {
        try {
            $orderItems = $this->orderService->getOrderItems($orderId);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(
            [
                'success' => true,
                'OrderItems' => $orderItems
            ], Response::HTTP_OK);
    }

    #[Route('/{userId}', name: 'api_orders_get', methods: ['GET'])]
    public function getUserOrders(string $userId): JsonResponse
    {
        try {
            $orders = $this->orderService->getUserOrders($userId);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(
            [
                'success' => true,
                'orders' => $orders
            ], Response::HTTP_OK);
    }

    #[Route('/{userId}', name: 'api_orders_add', methods: ['POST'])]
    public function createOrder(string $userId): JsonResponse
    {
        try {
            $order = $this->orderService->createOrderFromUserCart($userId);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'order' => [
                'id' => $order->getId(),
                'total' => $order->getTotal(),
                'createdAt' => $order->getCreatedAt(),
            ],
        ], Response::HTTP_CREATED);
    }
}
