<?php

namespace App\Controller;

use App\Repository\SnowFigureRepository;
use App\Manager\SnowFigureManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(SnowFigureManager $snowFigureManager): Response
    {
        //list of published figures, by decreasing id
        $figuresPublished = $snowFigureManager->getPublishedFigures();
        $figuresPublishedHome = $snowFigureManager->getPublishedFiguresLimit(5);

        //total number of figures published
        $nbFiguresPublished = count($figuresPublished);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'figures' => $figuresPublishedHome,
            'nbFigures' => $nbFiguresPublished,
        ]);
    }

    #[Route('/blockFigures', name: 'blockFigures', methods: 'GET')]
    public function blockFigures(SnowFigureRepository $snowFigureRepository): Response
    {
        $numFigure = $_GET['numFigure'];
        $figures = $snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC'], 5, $numFigure);

        return $this->render('home/_blockFigures.html.twig', [
            'figures' => $figures,
        ]);
    }
}
