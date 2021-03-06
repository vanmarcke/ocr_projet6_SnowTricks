<?php

namespace App\Manager;

use App\Entity\SnowComment;
use App\Entity\SnowFigure;
use App\Entity\SnowUser;
use App\Repository\SnowCommentRepository;
use App\Repository\SnowFigureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\String\Slugger\SluggerInterface;

class FigureManager implements FigureManagerInterface
{
    public function __construct(private SnowFigureRepository $snowFigureRepository, private SnowCommentRepository $snowCommentRepository, private EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
    }

    /**
     * {@inheritdoc}
     */
    public function getFiguresList(): array
    {
        return $this->snowFigureRepository->findBy([], ['id' => 'DESC']);
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishedFigures(): array
    {
        return $this->snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC']);
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishedFiguresLimit(int $max): array
    {
        return $this->snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC'], $max);
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishedNumFigure(int $max, int $numFigure): array
    {
        return $this->snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC'], $max, $numFigure);
    }

    /**
     * {@inheritdoc}
     */
    public function getComment(SnowFigure $snowFigure, int $offset): Paginator
    {
        return $this->snowCommentRepository->getCommentPaginator($snowFigure, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function newComment(SnowComment $comment, SnowFigure $figure, SnowUser $user): void
    {
        $comment
            ->setSnowFigure($figure)
            ->setSnowUser($user)
            ->setCreatedAt(
                new DateTime()
            );

        $this->entityManager->persist($comment) .
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function newFigure(SnowFigure $figure, SnowUser $user): void
    {
        $slug = $this->slugger->slug($figure->getName())->folded();
        $figure
            ->setSlug($slug)
            ->setCreatedAt(new DateTime())
            ->setSnowUser($user);

        $this->entityManager->persist($figure);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function editFigure(SnowFigure $figure): void
    {
        $slug = $this->slugger->slug($figure->getName())->folded();
        $figure
            ->setSlug($slug)
            ->setEditedAt(new DateTime());

        $this->entityManager->persist($figure);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function handleFigure(SnowFigure $figure, ?SnowUser $user): bool
    {
        if (!$figure->getId() && null !== $user) {
            $this->newFigure($figure, $user);

            return true;
        } else {
            $this->editFigure($figure);

            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeFigure(SnowFigure $figure): void
    {
        $this->entityManager->remove($figure);
        $this->entityManager->flush();
    }
}
