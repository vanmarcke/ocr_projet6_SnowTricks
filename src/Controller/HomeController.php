<?php

namespace App\Controller;

use App\Manager\FigureManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(FigureManagerInterface $figureManager): Response
    {
        //list of published figures, by decreasing id
        $figuresPublished = $figureManager->getPublishedFigures();
        $figuresPublishedHome = $figureManager->getPublishedFiguresLimit(5);

        //total number of figures published
        $nbFiguresPublished = count($figuresPublished);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'figures' => $figuresPublishedHome,
            'nbFigures' => $nbFiguresPublished,
        ]);
    }

    #[Route('/blockFigures', name: 'blockFigures')]
    public function blockFigures(Request $request, FigureManagerInterface $figureManager): Response
    {
        $numFigure = $request->query->get('numFigure');
        $figures = $figureManager->getPublishedNumFigure(5, $numFigure);

        return $this->render('home/_blockFigures.html.twig', [
            'figures' => $figures,
        ]);
    }
}
