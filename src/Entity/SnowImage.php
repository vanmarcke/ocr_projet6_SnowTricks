<?php

namespace App\Entity;

use App\Repository\SnowImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SnowImageRepository::class)]
class SnowImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $src;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: SnowFigure::class, inversedBy: 'image')]
    #[ORM\JoinColumn(nullable: true)]
    private $snowFigure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSnowFigure(): ?SnowFigure
    {
        return $this->snowFigure;
    }

    public function setSnowFigure(?SnowFigure $snowFigure): self
    {
        $this->snowFigure = $snowFigure;

        return $this;
    }
}
