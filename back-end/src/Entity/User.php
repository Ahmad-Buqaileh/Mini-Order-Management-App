<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User
{
    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    private string $id;
    #[ORM\Column(nullable: false)]
    private string $name;
    #[ORM\Column(unique: true, nullable: false)]
    private string $email;
    #[ORM\Column(name: "hashed_password", nullable: false)]
    private string $hashedPassword;
    #[ORM\Column(name: "created_at", type: "datetime_immutable", nullable: false)]
    private \DateTimeImmutable $createdAt;
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: "user", cascade: ['persist', 'remove'], fetch: 'LAZY', orphanRemoval: true)]
    private Collection $orders;

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->id = Uuid::uuid7()->toString();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setHashedPassword(string $hashedPassword): void
    {
        $this->hashedPassword = $hashedPassword;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }
}
