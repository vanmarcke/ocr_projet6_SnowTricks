<?php

namespace App\Controller;

use App\Entity\SnowComment;
use App\Entity\SnowFigure;
use App\Form\CommentFormType;
use App\Form\FigureFormType;
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

    #[Route('/new', name: 'figure_new')]
    #[Route('/figure/edit/{slug}', name: 'figure_edit')]
    public function new(SnowFigure $figure = null, Request $request, FigureManagerInterface $figureManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$figure) {
            $figure = new SnowFigure();
        }

        $user = $this->getUser();
        $form = $this->createForm(FigureFormType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                if (!$figure->getId()) {
                    $figureManager->newFigure($figure, $user);
                } else {
                    $figureManager->editFigure($figure);
                }
            } catch (Exception $ex) {
                $this->addFlash('danger', $ex->getMessage() . 'Erreur Système : veuillez ré-essayer');

                return $this->redirectToRoute('home');
            }
            $this->addFlash('success', 'L\'opération a bien été effectuée');

            return $this->redirectToRoute('figure_show', [
                'slug' => $figure->getSlug(),
            ]);
        }

        return $this->render('figure/managedFigure.html.twig', [
            'figureForm' => $form->createView(),
            'figure' => $figure,
            'editMode' => null !== $figure->getId(),
        ]);
    }

    #[Route('/figure/delete/{slug}', name: 'figure_delete')]
     public function deleteFigure(SnowFigure $figure, FigureManagerInterface $figureManager): Response
     {
         $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

         $hasBeenRemoved = $figureManager->removeFigure($figure);

         if ($hasBeenRemoved) {
             $this->addFlash('danger', 'La figure n\'a pas pu être supprimée');
         }
         $this->addFlash('success', 'La figure a bien été supprimée');

         return $this->redirectToRoute('home');
     }
}
