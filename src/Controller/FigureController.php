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
use Symfony\Contracts\Translation\TranslatorInterface;

class FigureController extends AbstractController
{
    #[Route('/figures/list', name: 'figures_list')]
    public function figuresList(FigureManagerInterface $figureManager): Response
    {
        $figuresList = $figureManager->getListFigures();

        return $this->render('figure/listFigures.html.twig', [
            'controller_name' => 'FigureController',
            'figures' => $figuresList,
        ]);
    }

    #[Route('/figure/{slug}', name: 'figure_show')]
    public function index(Request $request, FigureManagerInterface $figureManager, SnowFigure $figure, TranslatorInterface $translator): Response
    {
        // Back to home page if the requested figure is not published
        if (!$figure->getPublish()) {
            $message = $translator->trans('This figure is not published!');
            $this->addFlash('danger', $message);

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
                $message = $translator->trans('System error: please try again');
                $this->addFlash('danger', $message);

                return $this->redirectToRoute('figure_show', [
                    'slug' => $figure->getSlug(),
                ]);
            }
            $message = $translator->trans('your comment has been added');
            $this->addFlash('success', $message);

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
    public function new(SnowFigure $figure = null, Request $request, FigureManagerInterface $figureManager, TranslatorInterface $translator): Response
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
                $isCreated = $figureManager->handleFigure($figure, $user);
                if ($isCreated) {
                    $message = $translator->trans('The figure has been created successfully');
                    $this->addFlash('success', $message);
                } else {
                    $message = $translator->trans('The figure has been modified');
                    $this->addFlash('success', $message);
                }
            } catch (Exception) {
                $message = $translator->trans('System error: please try again');
                $this->addFlash('danger', $message);

                return $this->redirectToRoute('figure_edit');
            }

            return $this->redirectToRoute('figures_list', [
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
     public function deleteFigure(SnowFigure $figure, FigureManagerInterface $figureManager, TranslatorInterface $translator): Response
     {
         $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

         $hasBeenRemoved = $figureManager->removeFigure($figure);

         if ($hasBeenRemoved) {
             $message = $translator->trans('Figure could not be deleted');
             $this->addFlash('danger', $message);
         } else {
             $message = $translator->trans('Figure has been deleted');
             $this->addFlash('success', $message);
         }

         return $this->redirectToRoute('figures_list');
     }
}
