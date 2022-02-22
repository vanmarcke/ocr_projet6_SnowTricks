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
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function editProfile(Request $request, ProfileManagerInterface $profileManager, UserPasswordHasherInterface $userPasswordHasher, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $profileManager->uploadProfile($form, $user, $userPasswordHasher);
            } catch (Exception) {
                $message = $translator->trans('System error: please try again');
                $this->addFlash('danger',  $message);

                return $this->redirectToRoute('home');
            }
            $message = $translator->trans('Your profile has been successfully modified');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
