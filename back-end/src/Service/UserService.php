<?php

namespace App\Service;

use App\Dto\Request\User\UserRegisterRequestDTO;
use App\Entity\Exception\UserAlreadyExistsException;
use App\Entity\User;
use App\Mapper\UserMapper;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function register(UserRegisterRequestDTO $dto): User
    {
        if ($this->userRepository->existsByEmail($dto->getEmail())) {
            throw new UserAlreadyExistsException('User already exists');
        }
        $user = UserMapper::toEntity($dto);
        $encodedPassword = $this->userPasswordHasher->hashPassword($user, $dto->getPassword());
        $user->setHashedPassword($encodedPassword);
        $this->userRepository->save($user, true);
        return $user;
    }
}
