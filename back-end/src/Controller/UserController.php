<?php

namespace App\Controller;

use App\Dto\Request\User\UserRegisterRequestDTO;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/users')]
class UserController extends AbstractController
{
    private UserService $userService;
    private ValidatorInterface $validator;

    public function __construct(UserService $userService, ValidatorInterface $validator)
    {
        $this->userService = $userService;
        $this->validator = $validator;
    }

    #[Route('/register', name: 'api_users_register', methods: ['POST'])]
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
            $user = $this->userService->register($dto);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_CONFLICT);
        }
        return $this->json([
            'success' => true,
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ],
        ], Response::HTTP_CREATED);
    }

}
