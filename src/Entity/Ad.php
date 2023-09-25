<?php

namespace App\Entity;

use InvalidArgumentException;
use Doctrine\DBAL\Types\Types;
use App\Repository\AdRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdRepository::class)]
#[Vich\Uploadable]
class Ad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank(message: 'Veuiller selectionner une date de début.')]
    #[Assert\When(
        expression: 'this.getEndedAt() != null',
        constraints: [
            new Assert\LessThan(
                propertyPath: "endedAt",
                message: "The ending date should be before the starting date"
            )
        ]
    )]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank(message: 'Veuiller selectionner une date de fin.')]
    #[Assert\When(
        expression: 'this.getStartedAt() != null',
        constraints: [
            new Assert\GreaterThan(
                propertyPath: "startedAt",
                message: "The ending date should be after the starting date"
            )
        ]
    )]
    private ?\DateTimeImmutable $endedAt = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Veuiller selectionner un poids.')]
    private ?int $weight = null;

    #[ORM\Column(type: 'integer')]
    private ?int $views = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'ads', fileNameProperty: 'image', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\Column]
    private ?int $totalViews = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imageBase64 = null;

    #[ORM\Column]
    private ?int $click = null;

    public function __construct()
    {
        $this->views = 0;
        $this->totalViews = 0;
        $this->click = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }


    public function setStartedAt(\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $this->setNull($startedAt, $this->ifSetableAt($startedAt, $this->getEndedAt()));

        return $this;
    }

    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }


    public function setEndedAt(\DateTimeImmutable $endedAt): static
    {
        $this->endedAt = $this->setNull($endedAt, $this->ifSetableAt($this->getStartedAt(), $endedAt));

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): static
    {
        $this->views = $views;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile; //base64_encode($imageFile)
        $this->imageToBase64($imageFile);

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTotalViews(): ?int
    {
        return $this->totalViews;
    }

    public function setTotalViews(int $totalViews): static
    {
        $this->totalViews = $totalViews;

        return $this;
    }

    public function getImageBase64(): ?string
    {
        return $this->imageBase64;
    }

    public function setImageBase64(?string $imageBase64): static
    {
        $this->imageBase64 = $imageBase64;

        return $this;
    }

    public function getClick(): ?int
    {
        return $this->click;
    }

    public function setClick(int $click): static
    {
        $this->click = $click;

        return $this;
    }

    public function ifSetableAt(\DateTimeImmutable $start = null, \DateTimeImmutable $end = null)
    {
        if ($end != null && $start != null && $end < $start) {
            return false;
        }
        return true;
    }

    public function setNull(\DateTimeImmutable $date, $test = true)
    {
        if ($test == false) {
            $date = null;
        }
        return $date;
    }

    public function oneMoreView()
    {
        $this->views++;
    }

    public function actualViewInTotalView()
    {
        $this->totalViews += $this->views;
    }

    public function setViewToZero()
    {
        $this->views = 0;
    }

    public function isDisplayable()
    {
        return $this->views < $this->weight;
    }

    public function imageToBase64(?File $imageFile = null)
    {
        $this->setImageBase64(base64_encode(file_get_contents($imageFile)));
    }
}
