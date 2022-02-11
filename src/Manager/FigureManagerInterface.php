<?php

namespace App\Manager;

use App\Entity\SnowComment;
use App\Entity\SnowFigure;
use App\Entity\SnowUser;

interface FigureManagerInterface
{
    /**
     * Method newComment.
     *
     * @param SnowComment $comment returns the content of the comment
     * @param SnowFigure  $figure  returns the id of the figure
     * @param SnowUser    $user    returns user information
     *
     * @return void
     */
    public function newComment(SnowComment $comment, SnowFigure $figure, SnowUser $user);
}
