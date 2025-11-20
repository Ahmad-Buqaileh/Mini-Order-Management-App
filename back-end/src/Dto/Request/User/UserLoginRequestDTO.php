<?php

namespace App\Dto\Request\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserLoginRequestDTO
{
    #[Assert\NotBlank(message: 'Email should not be empty')]
    #[Assert\Email(message: 'Input must be a valid email')]
    private string $email;
    #[Assert\NotBlank(message: ("Password can not be empty"))]
    #[Assert\Length(min: 4, max: 16, minMessage: ("Password must be at least 4 characters"), maxMessage: ("Password must be at most 16 characters"))]
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
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
