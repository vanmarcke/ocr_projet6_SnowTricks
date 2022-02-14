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
     * Method getPublishedFigures.
     */
    public function getPublishedFigures(): array
    {
        $figuresPublished = $this->snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC']);

        return $figuresPublished;
    }

    /**
     * Method getPublishedFiguresLimit.
     *
     * @param int $max limit the display to 5 thumbnails when arriving on the home page
     */
    public function getPublishedFiguresLimit(int $max): array
    {
        $figuresPublishedHome = $this->snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC'], $max);

        return $figuresPublishedHome;
    }

    /**
     * Method getPublishedNumFigure.
     *
     * @param int $max       Displays a maximum of 5 thumbnails on each request
     * @param int $numFigure 5 in 5 thumbnail display
     */
    public function getPublishedNumFigure(int $max, int $numFigure): array
    {
        $figures = $this->snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC'], $max, $numFigure);

        return $figures;
    }

    /**
     * Method getComment.
     *
     * @param SnowFigure $snowFigure Contains the information of the figure
     * @param int        $offset     Contains the comment offset count
     */
    public function getComment(SnowFigure $snowFigure, int $offset): Paginator
    {
        $paginator = $this->snowCommentRepository->getCommentPaginator($snowFigure, $offset);

        return $paginator;
    }

    /**
     * Method newComment.
     *
     * @param SnowComment $comment contains the content of the comment
     * @param SnowFigure  $figure  contains the information of the figure
     * @param SnowUser    $user    contains user information
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
     * Method newFigure.
     *
     * @param SnowFigure $figure contains the information of the figure
     * @param SnowUser   $user   contains user information
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
     * Method editFigure.
     *
     * @param SnowFigure $figure contains the information of the figure
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
     * Method removeFigure.
     *
     * @param SnowFigure $figure contains the information of the figure
     *
     * @return void
     */
    public function removeFigure(SnowFigure $figure): void
    {
        $this->entityManager->remove($figure);
        $this->entityManager->flush();
    }
}
