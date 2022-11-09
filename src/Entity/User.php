<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message: "Cet e-mail existe déjo dans notre base de données")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Veuillez saisir une adresse e-mail")]
    #[Assert\Email(
        message: "Cette adresse n'est pas valide",
        mode: "strict"
    )]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank(message: "Veuillez saisir un mot de passe")]
    #[Assert\Length(
        min: 8,
        max: 32,
        minMessage: "Votre mot de passe doit contenir au moins {{ limit }} caractères",
        maxMessage: "Votre mot de passe doit contenir au maximum {{ limit }} caractères",
    )]
    #[Assert\NotCompromisedPassword(
        message: "Oops, ce mot de passe semble avoir fait l'objet d'une fuite chez un autre service en ligne",
    )]
    private ?string $plainPassword = null;

    #[Assert\NotBlank(message: "Veuillez saisir un nom d'utilisateur")]
    #[Assert\Length(
        min: 3,
        max: 30,
        minMessage: "Votre nom d'utilisateur doit contenir au moins {{ limit }} caractères",
        maxMessage: "Votre nom d'utilisateur doit contenir au maximum {{ limit }} caractères",
    )]
    #[ORM\Column(length: 30)]
    private ?string $username = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials()
    {
         $this->plainPassword = null;
    }
}
