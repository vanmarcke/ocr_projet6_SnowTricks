<?php

namespace App\Entity;

use App\Repository\SnowCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SnowCategoryRepository::class)]
class SnowCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'snowCategory', targetEntity: SnowFigure::class)]
    private $figure;

    public function __construct()
    {
        $this->figure = new ArrayCollection();
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

    /**
     * @return Collection|SnowFigure[]
     */
    public function getFigure(): Collection
    {
        return $this->figure;
    }

    public function addFigure(SnowFigure $figure): self
    {
        if (!$this->figure->contains($figure)) {
            $this->figure[] = $figure;
            $figure->setSnowCategory($this);
        }

        return $this;
    }

    public function removeFigure(SnowFigure $figure): self
    {
        if ($this->figure->removeElement($figure)) {
            // set the owning side to null (unless already changed)
            if ($figure->getSnowCategory() === $this) {
                $figure->setSnowCategory(null);
            }
        }

        return $this;
    }
}
