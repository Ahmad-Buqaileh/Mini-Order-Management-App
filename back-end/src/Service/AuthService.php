<?php

namespace App\Service;

use App\Dto\Request\User\UserLoginRequestDTO;
use App\Dto\Request\User\UserRegisterRequestDTO;
use App\Entity\Exception\UserAlreadyExistsException;
use App\Mapper\UserMapper;
use App\Repository\UserRepository;
use App\Security\JwtService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Exception\LogicException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class AuthService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private JwtService $jwtService;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher,
                                JwtService     $jwtService)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->jwtService = $jwtService;
    }

    public function register(UserRegisterRequestDTO $dto): array
    {
        if ($this->userRepository->existsByEmail($dto->getEmail())) {
            throw new UserAlreadyExistsException('User already exists');
        }
        $user = UserMapper::toEntity($dto);
        $encodedPassword = $this->passwordHasher->hashPassword($user, $dto->getPassword());
        $user->setHashedPassword($encodedPassword);
        $this->userRepository->save($user, true);
        $accessToken = $this->jwtService->generateAccessToken($user->getId());
        $refreshToken = $this->jwtService->generateRefreshToken($user->getId());
        return [
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken,
        ];
    }

    public function login(UserLoginRequestDTO $dto): array
    {
        $user = $this->userRepository->findOneBy(['email' => $dto->getEmail()]);
        if (!$user) {
            throw new UserNotFoundException("User not found");
        }
        if (!$this->passwordHasher->isPasswordValid($user, $dto->getPassword())) {
            throw new LogicException("Invalid credentials");
        }
        $accessToken = $this->jwtService->generateAccessToken($user->getId());
        $refreshToken = $this->jwtService->generateRefreshToken($user->getId());
        return [
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken,
        ];
    }

    public function refreshToken(Request $request): string{
        return $this->jwtService->refreshAccessToken($request);
    }
}
