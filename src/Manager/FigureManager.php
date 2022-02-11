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
     * @param SnowFigure $snowFigure Return the figure
     * @param int        $offset     Returns the comment offset count
     */
    public function getComment(SnowFigure $snowFigure, int $offset): Paginator
    {
        $paginator = $this->snowCommentRepository->getCommentPaginator($snowFigure, $offset);

        return $paginator;
    }

    /**
     * Add a new comment.
     *
     * @throws Exception
     */
    /**
     * Method newComment.
     *
     * @param SnowComment $comment contains the content of the comment 
     * @param SnowFigure  $figure  contains the information of the figure 
     * @param SnowUser    $user    contains user information 
     */
    public function newComment(SnowComment $comment, SnowFigure $figure, SnowUser $user): void
    {
        $comment->setSnowFigure($figure);
        $comment->setSnowUser($user);
        $comment->setCreatedAt(new DateTime()); 

        $this->entityManager->persist($comment) .
        $this->entityManager->flush();
    }
}
