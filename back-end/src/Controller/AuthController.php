<?php

namespace App\Controller;

use App\Dto\Request\User\UserLoginRequestDTO;
use App\Dto\Request\User\UserRegisterRequestDTO;
use App\Security\JwtService;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route("/api/v1/auth")]
class AuthController extends AbstractController
{
    private AuthService $authService;
    private ValidatorInterface $validator;
    private JwtService $jwtService;

    public function __construct(AuthService $authService, ValidatorInterface $validator, JwtService $jwtService)
    {
        $this->authService = $authService;
        $this->validator = $validator;
        $this->jwtService = $jwtService;
    }

    #[Route("/login", name: "api_auth_login", methods: ['POST'])]
    public function getCartItems(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if ($data == null && json_last_error() == JSON_ERROR_NONE) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid JSON'
            ], Response:: HTTP_BAD_REQUEST);
        }
        $dto = new UserLoginRequestDTO(
            $data['email'],
            $data['password']
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
            $result = $this->authService->logIn($dto);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        }
        $response = $this->json([
            'success' => true,
            'message' => "Successfully logged in",
            'accessToken' => $result['accessToken'],
        ], Response::HTTP_OK);
        $this->jwtService->addTokenToCookie($response, $result['refreshToken']);
        return $response;
    }

    #[Route('/register', name: 'api_auth_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if ($data == null && json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid JSON',
            ], Response::HTTP_BAD_REQUEST);
        }
        $dto = new UserRegisterRequestDTO(
            $data['name'],
            $data['email'],
            $data['password']
        );
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json([
                'success' => false,
                'message' => $errorsArray,
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $result = $this->authService->register($dto);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_CONFLICT);
        }
        $response = $this->json([
            'success' => true,
            'message' => "Successfully logged in",
            'accessToken' => $result['accessToken'],
        ], Response::HTTP_CREATED);
        $this->jwtService->addTokenToCookie($response, $result['refreshToken']);
        return $response;
    }

}
