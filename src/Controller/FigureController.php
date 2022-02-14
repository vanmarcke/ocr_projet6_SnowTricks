<?php

namespace App\Controller;

use App\Entity\SnowComment;
use App\Entity\SnowFigure;
use App\Form\CommentFormType;
use App\Manager\FigureManagerInterface;
use App\Repository\SnowCommentRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FigureController extends AbstractController
{
    #[Route('/figure/{slug}', name: 'figure_show')]
    public function index(Request $request, FigureManagerInterface $figureManager, SnowFigure $figure): Response
    {
        // Back to home page if the requested figure is not published
        if (!$figure->getPublish()) {
            $this->addFlash('danger', 'Cette figure n\'est pas publiée !');

            return $this->redirectToRoute('home');
        }

        $user = $this->getUser();
        $comment = new SnowComment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $user) {
            try {
                $figureManager->newComment($comment, $figure, $user);
            } catch (Exception) {
                $this->addFlash('danger', 'Erreur Système : veuillez ré-essayer');

                return $this->redirectToRoute('figure_show', [
                    'slug' => $figure->getSlug(),
                ]);
            }
            $this->addFlash('success', 'Votre commentaire a bien été ajouté');

            return $this->redirectToRoute('figure_show', [
                'slug' => $figure->getSlug(),
            ]);
        }

        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $figureManager->getComment($figure, $offset);

        return $this->render('figure/index.html.twig', [
            'controller_name' => 'FigureController',
            'figure' => $figure,
            'commentForm' => $form->createView(),
            'comments' => $paginator,
            'previous' => $offset - SnowCommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + SnowCommentRepository::PAGINATOR_PER_PAGE),
        ]);
    }
}
