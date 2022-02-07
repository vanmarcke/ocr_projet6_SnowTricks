<?php

namespace App\Controller;

use App\Repository\SnowFigureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(SnowFigureRepository $snowFigureRepository): Response
    {
        //list of published figures, by decreasing id 
        $figuresPublished = $snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC']);
        $figuresPublishedHome = $snowFigureRepository->findBy(['publish' => '1'], ['id' => 'DESC'], 5, 0);
        
        //total number of figures published 
        $nbFiguresPublished = count($figuresPublished);
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'figures' => $figuresPublishedHome,
            'nbFigures' => $nbFiguresPublished
        ]);
    }
}
