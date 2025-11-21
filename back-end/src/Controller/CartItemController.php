<?php

namespace App\Controller;

use App\Dto\Request\CartItem\AddCartItemRequestDTO;
use App\Dto\Request\CartItem\UpdateCartItemQuantityDTO;
use App\Dto\Response\CartItem\CartItemResponseDTO;
use App\Service\CartItemService;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route("/api/v1/cart_items")]
class CartItemController extends AbstractController
{
    private CartItemService $cartItemService;
    private ValidatorInterface $validator;

    public function __construct(CartItemService $cartItemService, ValidatorInterface $validator)
    {
        $this->cartItemService = $cartItemService;
        $this->validator = $validator;
    }

    #[Route(name: "api_cart_item_add", methods: ["POST"])]
    public function addItemToCart(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if ($data == null && json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid JSON'
            ], Response::HTTP_BAD_REQUEST);
        }
        $dto = new AddCartItemRequestDTO(
            $data['productId'],
            $data['userToken'],
            $data['quantity']
        );
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorArray = [];
            foreach ($errors as $error) {
                $errorArray[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json([
                'success' => false,
                'message' => $errorArray
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $this->cartItemService->addItemToCart($dto);
        } catch (\Exception $exception) {
            return $this->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'message' => 'Item added to cart successfully'
        ], Response::HTTP_CREATED);
    }

    #[Route('/update', name: 'update_cart_item', methods: ['PUT'])]
    public function update(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if ($data == null && json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid JSON'
            ], Response::HTTP_BAD_REQUEST);
        }
        $dto = new UpdateCartItemQuantityDTO(
            $data['cartItemId'],
            $data['quantity'],
        );
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorArray = [];
            foreach ($errors as $error) {
                $errorArray[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json([
                'success' => false,
                'message' => $errorArray
            ], Response::HTTP_BAD_REQUEST);
        }
        try{
            $item = $this->cartItemService->updateQuantity($dto);
        } catch (\Exception $exception) {
            return $this->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'message' => 'Item updated successfully',
            'cartItem' => new CartItemResponseDTO($item)
        ],Response::HTTP_OK);
    }

    #[Route(name: "api_cart_item_delete", methods: ["DELETE"])]
    public function deleteItemFromCart(Request $request): JsonResponse
    {
        $cartItemId = $request->query->get('itemId');
        if ($cartItemId == null) return $this->json([
            'success' => false,
            'message' => 'Item id not provided must be query'
        ], Response::HTTP_BAD_REQUEST);
        try {
            $this->cartItemService->removeItemFromCart($cartItemId);
        } catch (Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'message' => 'Item deleted from cart successfully',
            'cartItemId' => $cartItemId
        ], Response::HTTP_OK);
    }
}
