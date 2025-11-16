<?php

namespace App\Mapper;

use App\Dto\Request\User\UserRegisterRequestDTO;
use App\Entity\User;

class UserMapper
{
    public static function toEntity(UserRegisterRequestDTO $requestDto): User
    {
        $user = new User();
        $user->setName($requestDto->getName());
        $user->setEmail($requestDto->getEmail());
        return $user;
    }
}
