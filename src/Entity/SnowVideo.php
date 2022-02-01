<?php

namespace App\Entity;

use App\Repository\SnowVideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SnowVideoRepository::class)]
class SnowVideo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: SnowFigure::class, inversedBy: 'video')]
    #[ORM\JoinColumn(nullable: true)]
    private $snowFigure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
