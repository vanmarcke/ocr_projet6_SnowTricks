<?php

namespace App\Controller;

use App\Entity\SnowUser;
use App\Form\RegistrationFormType;
use App\Repository\SnowUserRepository;
use App\Security\EmailVerifier;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    private string $imageDirAvatar;

    public function __construct(EmailVerifier $emailVerifier, string $imageDirAvatar)
    {
        $this->emailVerifier = $emailVerifier;
        $this->imageDirAvatar = $imageDirAvatar;
    }

    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        if ($this->getUser()) {
            $message = $translator->trans('You are already registered and logged in.');
            $this->addFlash('danger', $message);

            return $this->redirectToRoute('home');
        }

        $user = new SnowUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setCreatedAt(new DateTime());

            $avatar = $form->get('avatar')->getData();
            if ($avatar) {
                $nameavatar = random_int(1, 999) . '-' . 'SnowAvatar' . '-' . $avatar->getClientOriginalName();
                $nameavatar = str_replace(' ', '_', $nameavatar);
                $avatar->move($this->getParameter('avatarAbsoluteDir'), $nameavatar);

                $user->setAvatar(sprintf("%s/%s",$this->imageDirAvatar, $nameavatar));
            }

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $message = $translator->trans('Please confirm your email');
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('vmkdev@vmkdev.com', 'VMKDEV'))
                    ->to($user->getEmail())
                    ->subject($message)
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            $message = $translator->trans('Check your email to confirm your registration.');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, SnowUserRepository $snowUserRepository, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $user = $snowUserRepository->find($request->query->get('id'));
        if (!$user) {
            throw $this->createNotFoundException();
        }
        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail(),
            );
        } catch (VerifyEmailExceptionInterface ) {
            $message = $translator->trans('The link to verify your email is invalid. Please request a new link');
            $this->addFlash('danger', $message);

            return $this->redirectToRoute('app_register');
        }
        $user->setIsVerified(true);
        $entityManager->flush();
        $message = $translator->trans('Account verified! You can now connect.');
        $this->addFlash('success', $message);

        return $this->redirectToRoute('app_login');
    }
}
