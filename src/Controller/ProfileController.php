<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Manager\ProfileManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function editProfile(Request $request, ProfileManagerInterface $profileManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $profileManager->uploadProfile($form, $user, $userPasswordHasher);
            } catch (Exception $ex) {
                $this->addFlash('danger',  $ex->getMessage() . 'Erreur Système : veuillez ré-essayer');

                return $this->redirectToRoute('home');
            }
            $this->addFlash('success', 'Votre profil a été modifié avec succès');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
