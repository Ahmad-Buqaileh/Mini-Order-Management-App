<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/v1/carts")]
class CartController extends AbstractController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route("/cart/{id}", name: "api_cart_items", methods: ['GET'])]
    public function getCartItems(string $id): JsonResponse
    {
        try {
            $items = $this->cartService->getCartItems($id);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse([
            'success' => true,
            'cart items' => $items
        ], Response::HTTP_OK);
    }

    #[Route("/{id}", name: "api_cart_items_create", methods: ['POST'])]
    public function createCart(string $id): JsonResponse
    {
        try {
            $cart = $this->cartService->createCartForUser($id);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse([
            'success' => true,
            'cart' => $cart
        ], Response::HTTP_CREATED);
    }
}
