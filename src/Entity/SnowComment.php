<?php

namespace App\Entity;

use App\Repository\SnowCommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SnowCommentRepository::class)]
class SnowComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: SnowFigure::class, inversedBy: 'Comment')]
    #[ORM\JoinColumn(nullable: false)]
    private $snowFigure;

    #[ORM\ManyToOne(targetEntity: SnowUser::class, inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: false)]
    private $snowUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getSnowUser(): ?SnowUser
    {
        return $this->snowUser;
    }

    public function setSnowUser(?SnowUser $snowUser): self
    {
        $this->snowUser = $snowUser;

        return $this;
    }
}
