<?php

namespace App\Controller;

use App\Entity\SnowFigure;
use App\Repository\SnowCommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FigureController extends AbstractController
{
    #[Route('/figure/{slug}', name: 'figure_show')]
    public function index(Request $request, SnowCommentRepository $snowCommentRepository, SnowFigure $snowFigure): Response
    {
        // Back to home page if the requested figure is not published
        if (!$snowFigure->getPublish()) {
            $this->addFlash('danger', 'Cette figure n\'est pas publiée !');

            return $this->redirectToRoute('home');
        }

        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $snowCommentRepository->getCommentPaginator($snowFigure, $offset);

        dump($snowFigure);

        return $this->render('figure/index.html.twig', [
            'controller_name' => 'FigureController',
            'figure' => $snowFigure,
            'comments' => $paginator,
            'previous' => $offset - SnowCommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + SnowCommentRepository::PAGINATOR_PER_PAGE),
        ]);
    }
}
