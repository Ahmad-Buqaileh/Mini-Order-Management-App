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
}
