<?php

namespace App\Controller;

use App\Dto\Request\Product\ProductRequestDTO;
use App\Service\ProductService;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/products')]
class ProductController extends AbstractController
{
    private ProductService $productService;
    private ValidatorInterface $validator;

    public function __construct(ProductService $productService, ValidatorInterface $validator)
    {
        $this->productService = $productService;
        $this->validator = $validator;
    }

    #[Route(name: 'api_products', methods: ['GET'])]
    public function getAllProducts(): JsonResponse
    {
        try {
            $products = $this->productService->getAllProducts();
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response:: HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'products' => $products
        ], Response::HTTP_OK);
    }

    #[Route('/product/id/{id}', name: 'api_products_by_id', methods: ['GET'])]
    public function getProductById(string $id): JsonResponse
    {
        try {
            $product = $this->productService->getProductById($id);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response:: HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'product' => $product
        ], Response::HTTP_OK);
    }

    #[Route('/product/name', name: 'api_products_by_name', methods: ['GET'])]
    public function getProductByName(Request $request): JsonResponse
    {
        $name = $request->query->get('search');
        if (!$name) {
            return $this->json([
                'success' => false,
                'message' => 'Query parameter "category" is required.'
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $products = $this->productService->getProductsByName($name);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response:: HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'products' => $products
        ], Response::HTTP_OK);
    }

    #[Route('/product/category', name: 'api_products_by_category', methods: ['GET'])]
    public function getProductsByCategory(Request $request): JsonResponse
    {
        $category = $request->query->get('category');
        if (!$category) {
            return $this->json([
                'success' => false,
                'message' => 'Query parameter "category" is required.'
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $products = $this->productService->getProductsByCategory($category);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response:: HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'products' => $products
        ], Response::HTTP_OK);
    }

    #[Route('/add', name: 'api_products_add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if ($data == null && json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid JSON'
            ], Response:: HTTP_BAD_REQUEST);
        }
        $dto = new ProductRequestDTO(
            $data['name'],
            $data['category'],
            $data['price'],
            $data['stock']
        );
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json([
                'success' => false,
                'message' => $errorsArray
            ], Response:: HTTP_BAD_REQUEST);
        }
        try {
            $product = $this->productService->createProduct($dto);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response:: HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'message' => 'Product added successfully',
            'product' =>
                [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'category' => $product->getCategory(),
                    'price' => $product->getPrice(),
                    'stock' => $product->getStock(),
                ]
        ]);
    }

    #[Route('/{id}', name: 'api_products_delete', methods: ['DELETE'])]
    public function remove(string $id): JsonResponse
    {
        try {
            $this->productService->removeProduct($id);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response:: HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }
}
