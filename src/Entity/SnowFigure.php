<?php

namespace App\Entity;

use App\Repository\SnowFigureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SnowFigureRepository::class)]
class SnowFigure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'boolean')]
    private $publish;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'snowFigure', targetEntity: SnowImage::class, orphanRemoval: true)]
    private $image;

    #[ORM\OneToMany(mappedBy: 'snowFigure', targetEntity: SnowVideo::class, orphanRemoval: true)]
    private $video;

    #[ORM\OneToMany(mappedBy: 'snowFigure', targetEntity: SnowComment::class, orphanRemoval: true)]
    private $Comment;

    #[ORM\ManyToOne(targetEntity: SnowCategory::class, inversedBy: 'figure')]
    #[ORM\JoinColumn(nullable: false)]
    private $snowCategory;

    #[ORM\ManyToOne(targetEntity: SnowUser::class, inversedBy: 'figure')]
    #[ORM\JoinColumn(nullable: false)]
    private $snowUser;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $editAt;

    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->video = new ArrayCollection();
        $this->Comment = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublish(): ?bool
    {
        return $this->publish;
    }

    public function setPublish(bool $publish): self
    {
        $this->publish = $publish;

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

    /**
     * @return Collection|SnowImage[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(SnowImage $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setSnowFigure($this);
        }

        return $this;
    }

    public function removeImage(SnowImage $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getSnowFigure() === $this) {
                $image->setSnowFigure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SnowVideo[]
     */
    public function getVideo(): Collection
    {
        return $this->video;
    }

    public function addVideo(SnowVideo $video): self
    {
        if (!$this->video->contains($video)) {
            $this->video[] = $video;
            $video->setSnowFigure($this);
        }

        return $this;
    }

    public function removeVideo(SnowVideo $video): self
    {
        if ($this->video->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getSnowFigure() === $this) {
                $video->setSnowFigure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SnowComment[]
     */
    public function getComment(): Collection
    {
        return $this->Comment;
    }

    public function addComment(SnowComment $comment): self
    {
        if (!$this->Comment->contains($comment)) {
            $this->Comment[] = $comment;
            $comment->setSnowFigure($this);
        }

        return $this;
    }

    public function removeComment(SnowComment $comment): self
    {
        if ($this->Comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getSnowFigure() === $this) {
                $comment->setSnowFigure(null);
            }
        }

        return $this;
    }

    public function getSnowCategory(): ?SnowCategory
    {
        return $this->snowCategory;
    }

    public function setSnowCategory(?SnowCategory $snowCategory): self
    {
        $this->snowCategory = $snowCategory;

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

    public function getEditAt(): ?\DateTimeInterface
    {
        return $this->editAt;
    }

    public function setEditAt(?\DateTimeInterface $editAt): self
    {
        $this->editAt = $editAt;

        return $this;
    }
}
