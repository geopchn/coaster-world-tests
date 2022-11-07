<?php

namespace App\Entity;

use App\Repository\CoasterRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CoasterRepository::class)]
class Coaster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Veuillez saisir un nom")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit comporter au moins {{ limit }} caractères",
        maxMessage: "Le nom doit comporter au maximum {{ limit }} caractères",
    )]
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[Assert\Expression(
        "this.getImage() or this.getImageFile()",
        message: 'Veuillez choisir une image',
    )]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png'],
        maxSizeMessage: 'L\'image ne doit pas éxcéder 2Mo',
        mimeTypesMessage: 'L\'image doit être au format JPEG ou PNG',
    )]
    private ?UploadedFile $imageFile = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $openedAt;

    #[Assert\Range(
        notInRangeMessage: 'La taille minimum doit être entre {{ min }}cm et {{ max }}cm',
        min: 50,
        max: 230,
    )]
    #[ORM\Column(nullable: true)]
    private ?int $minimumHeight = null;

    #[Assert\Range(
        notInRangeMessage: 'La taille maximum doit être entre {{ min }}cm et {{ max }}cm',
        min: 50,
        max: 230,
    )]
    #[ORM\Column(nullable: true)]
    private ?int $maximumHeight = null;

    #[Assert\NotBlank(message: "Veuillez saisir une durée")]
    #[Assert\LessThan(
        value: "1970-01-01 01:00:00",
        message: "L'attraction ne peut durer plus de 2 heures"
    )]
    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?DateTimeInterface $duration = null;

    #[Assert\NotBlank(message: "Veuillez séléctionner un constructeur")]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Manufacturer $manufacturer = null;

    #[Assert\Count(
        min: 1,
        minMessage: "Vous devez choisir au moins une catégorie"
    )]
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    #[ORM\ManyToOne(inversedBy: 'coasters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Park $park = null;

    public function __construct()
    {
        $this->openedAt = new DateTime('2020-01-01');
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    public function setImageFile(?UploadedFile $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getOpenedAt(): ?DateTimeInterface
    {
        return $this->openedAt;
    }

    public function setOpenedAt(?DateTimeInterface $openedAt): self
    {
        $this->openedAt = $openedAt;

        return $this;
    }

    public function getMinimumHeight(): ?int
    {
        return $this->minimumHeight;
    }

    public function setMinimumHeight(?int $minimumHeight): self
    {
        $this->minimumHeight = $minimumHeight;

        return $this;
    }

    public function getMaximumHeight(): ?int
    {
        return $this->maximumHeight;
    }

    public function setMaximumHeight(?int $maximumHeight): self
    {
        $this->maximumHeight = $maximumHeight;

        return $this;
    }

    public function getDuration(): ?DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getPark(): ?Park
    {
        return $this->park;
    }

    public function setPark(?Park $park): self
    {
        $this->park = $park;

        return $this;
    }
}
