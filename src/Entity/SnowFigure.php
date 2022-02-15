<?php

namespace App\Entity;

use App\Repository\SnowFigureRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SnowFigureRepository::class)]
#[UniqueEntity(fields: 'name', message: 'Cette figure est déjà enregistrée !')]
class SnowFigure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'boolean')]
    private $publish;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'snowFigure', targetEntity: SnowImage::class, cascade: ['persist'], orphanRemoval: true)]
    private $images;

    #[ORM\OneToMany(mappedBy: 'snowFigure', targetEntity: SnowVideo::class, cascade: ['persist'],  orphanRemoval: true)]
    private $videos;

    #[ORM\OneToMany(mappedBy: 'snowFigure', targetEntity: SnowComment::class, orphanRemoval: true)]
    private $Comments;

    #[ORM\ManyToOne(targetEntity: SnowCategory::class, inversedBy: 'figure')]
    #[ORM\JoinColumn(nullable: false)]
    private $snowCategory;

    #[ORM\ManyToOne(targetEntity: SnowUser::class, inversedBy: 'figure')]
    #[ORM\JoinColumn(nullable: false)]
    private $snowUser;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $editedAt;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->Comments = new ArrayCollection();
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
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(SnowImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCreatedAt(new DateTime());
            $image->setSnowFigure($this);
        }

        return $this;
    }

    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    public function removeImage(SnowImage $image): self
    {
        $image->setSnowFigure(null);
        $this->images->removeElement($image);
        return $this;
    }

    /**
     * @return Collection|SnowVideo[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(SnowVideo $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setCreatedAt(new DateTime());
            $video->setSnowFigure($this);
        }

        return $this;
    }

    public function removeVideo(SnowVideo $video): self
    {
        $video->setSnowFigure(null);
        $this->videos->removeElement($video);
        return $this;
    }

    /**
     * @return Collection|SnowComment[]
     */
    public function getComments(): Collection
    {
        return $this->Comments;
    }

    public function addComment(SnowComment $comment): self
    {
        if (!$this->Comments->contains($comment)) {
            $this->Comments[] = $comment;
            $comment->setSnowFigure($this);
        }

        return $this;
    }

    public function removeComment(SnowComment $comment): self
    {
        if ($this->Comments->removeElement($comment)) {
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

    public function getEditedAt(): ?\DateTimeInterface
    {
        return $this->editedAt;
    }

    public function setEditedAt(?\DateTimeInterface $editedAt): self
    {
        $this->editedAt = $editedAt;

        return $this;
    }
}
