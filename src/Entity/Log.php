<?php

namespace App\Entity;

use App\Entity\Ad;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LogRepository;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $doneAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ad $Ad = null;

    public function __construct()
    {
        $this->doneAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDoneAt(): ?\DateTimeImmutable
    {
        return $this->doneAt;
    }

    public function setDoneAt(\DateTimeImmutable $doneAt): static
    {
        $this->doneAt = $doneAt;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->Ad;
    }

    public function setAd(?Ad $Ad): static
    {
        $this->Ad = $Ad;

        return $this;
    }

    public function setSeen(?Ad $Ad): static
    {
        $this->Ad = $Ad;
        $this->type = 'seen';

        return $this;
    }

    public function setClick(?Ad $Ad): static
    {
        $this->Ad = $Ad;
        $this->type = 'clicked';

        return $this;
    }
}
