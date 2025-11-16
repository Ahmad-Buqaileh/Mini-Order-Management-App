<?php

namespace App\Dto\Request\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterRequestDTO
{
    #[Assert\NotBlank(message: ("Name can not be empty"))]
    private string $name;
    #[Assert\NotBlank(message: ("Email can not be empty"))]
    #[Assert\Email(message: ("Email is not valid"))]
    private string $email;
    #[Assert\NotBlank(message: ("Password can not be empty"))]
    #[Assert\Length(min: 4, max: 16, minMessage: ("Password must be at least 4 characters"), maxMessage: ("Password must be at most 16 characters"))]
    private string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
