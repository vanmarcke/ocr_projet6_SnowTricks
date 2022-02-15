<?php

namespace App\Manager;

use App\Entity\SnowComment;
use App\Entity\SnowFigure;
use App\Entity\SnowUser;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface FigureManagerInterface
{
    /**
     * Method getPublishedFigures.
     */
    public function getPublishedFigures(): array;

    /**
     * Method getPublishedFiguresLimit.
     *
     * @param int $max limit the display to 5 thumbnails when arriving on the home page
     */
    public function getPublishedFiguresLimit(int $max): array;

    /**
     * Method getPublishedNumFigure.
     *
     * @param int $max       Displays a maximum of 5 thumbnails on each request
     * @param int $numFigure 5 in 5 thumbnail display
     */
    public function getPublishedNumFigure(int $max, int $numFigure): array;

    /**
     * Method getComment.
     *
     * @param SnowFigure $snowFigure Contains the information of the figure
     * @param int        $offset     Contains the comment offset count
     */
    public function getComment(SnowFigure $snowFigure, int $offset): Paginator;

    /**
     * Method newComment.
     *
     * @param SnowComment $comment returns the content of the comment
     * @param SnowFigure  $figure  returns the id of the figure
     * @param SnowUser    $user    returns user information
     */
    public function newComment(SnowComment $comment, SnowFigure $figure, SnowUser $user): void;

    /**
     * Method newFigure.
     *
     * @param SnowFigure $figure contains the information of the figure
     * @param SnowUser   $user   contains user information
     */
    public function newFigure(SnowFigure $figure, SnowUser $user): void;

    /**
     * Method newFigure.
     *
     * @param SnowFigure $figure contains the information of the figure
     */
    public function editFigure(SnowFigure $figure): void;

    /**
     * Method removeFigure.
     *
     * @param SnowFigure $figure contains the information of the figure
     */
    public function removeFigure(SnowFigure $figure): void;

    /**
     * Method handleFigure.
     *
     * @param SnowFigure $figure contains the information of the figure
     * @param ?SnowUser  $user   contains user information if not null
     *
     * @return bool true if created, false if edited
     */
    public function handleFigure(SnowFigure $figure, ?SnowUser $user): bool;
}
