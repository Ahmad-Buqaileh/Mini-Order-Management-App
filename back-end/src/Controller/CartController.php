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

    #[Route("/cart/{userToken}", name: "api_cart_items", methods: ['GET'])]
    public function getCartItems(string $userToken): JsonResponse
    {
        try {
            $items = $this->cartService->getCartItems($userToken);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse([
            'success' => true,
            'cartItems' => $items
        ], Response::HTTP_OK);
    }

    #[Route("/{userToken}", name: "api_cart_items_create", methods: ['POST'])]
    public function createCart(string $userToken): JsonResponse
    {
        try {
            $cart = $this->cartService->createCartForUser($userToken);
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
