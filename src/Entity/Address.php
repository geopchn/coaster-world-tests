<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        max: 150,
        maxMessage: "Le libellé doit comporter au maximum {{ limit }} caractères",
    )]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $street = null;

    #[Assert\Length(
        max: 10,
        maxMessage: "Le code postal doit comporter au maximum {{ limit }} caractères",
    )]
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $zipcode = null;

    #[Assert\NotBlank(message: "Vous devez saisir une ville")]
    #[Assert\Length(
        max: 50,
        maxMessage: "La ville doit comporter au maximum {{ limit }} caractères",
    )]
    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[Assert\NotBlank(message: "Vous devez saisir un pays")]
    #[ORM\Column(length: 2)]
    private ?string $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function __toString(): string
    {
        $diplayed = $this->street ? $this->street . ' - ' : '';
        $diplayed .= $this->zipcode ? $this->zipcode . ' ' : '';
        $diplayed .= $this->city . ' ' . $this->country;

        return $diplayed;
    }
}
