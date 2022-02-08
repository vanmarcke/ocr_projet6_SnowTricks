<?php

namespace App\Manager;

use App\Repository\SnowFigureRepository;

class SnowFigureManager
{
    public function __construct(private SnowFigureRepository $snowFigureRepository)
    {
    }
    
    /**
     * Method getPublishedFigures
     *
     * @return array
     */
    public function getPublishedFigures(): array
    {
        $figuresPublished = $this->snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC']);

        return $figuresPublished;
    }
    
    /**
     * Method getPublishedFiguresLimit
     *
     * @param int $max limit the display to 5 thumbnails when arriving on the home page
     *
     * @return array
     */
    public function getPublishedFiguresLimit(int $max): array
    {
        $figuresPublishedHome = $this->snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC'], $max);

        return $figuresPublishedHome;
    }
}
