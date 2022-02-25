<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
     public function login(AuthenticationUtils $authenticationUtils, TranslatorInterface $translator): Response
     {
         if ($this->getUser()) {
             $message = $translator->trans('You are already logged.');
             $this->addFlash('danger', $message);

             return $this->redirectToRoute('home');
         }

         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();
         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

         return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
     }

    #[Route('/déconnexion', name: 'app_logout')]
     public function logout(): void
     {
         throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
     }
}
