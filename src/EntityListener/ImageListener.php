<?php

namespace App\EntityListener;

use App\Entity\SnowImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageListener
{
    private string $imageDir;

    private string $imageAbsoluteDir;

    /**
     * ImageListener constructor.
     */
    public function __construct(string $imageDir, string $imageAbsoluteDir)
    {
        $this->imageDir = $imageDir;
        $this->imageAbsoluteDir = $imageAbsoluteDir;
    }

    public function prePersist(SnowImage $image): void
    {
        $this->upload($image);
    }

    public function preUpdate(SnowImage $image): void
    {
        $this->upload($image);
    }

    public function preRemove(SnowImage $image): void
    {
        if (0 == strpos($image->getSrc(), $this->imageDir)) { //On vérifie si src contient imageDir
            $path = substr($image->getSrc(), strlen($this->imageDir) + 1); //on extrait le filename
            @unlink(sprintf('%s/%s', $this->imageAbsoluteDir, $path)); //on génère le chemin absolue + on supprime le fichier avc unlink (@pour ne pas générer d'erreur)
        }
    }

    private function upload(SnowImage $image): void
    {
        if ($image->getFile() instanceof UploadedFile) {
            $filename = random_int(1, 999) . '-' . 'SnowFigure' . '-' . $image->getFile()->getClientOriginalName();
            $image->getFile()->move($this->imageAbsoluteDir, $filename);
            $image->setSrc(sprintf('%s/%s', $this->imageDir, $filename));
        }
    }
}
