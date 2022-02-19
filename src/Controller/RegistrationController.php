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
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            $this->addFlash('danger', 'Vous êtes déjà inscrit et connecté.');

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
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('vmkdev@vmkdev.com', 'VMKDEV'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            $this->addFlash('success', 'Vérifier votre boite mail afin de valider votre inscription.');

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, SnowUserRepository $snowUserRepository, EntityManagerInterface $entityManager): Response
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
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('danger', 'Le lien pour vérifier votre email n\'est pas valide. Veuillez demander un nouveau lien');

            return $this->redirectToRoute('app_register');
        }
        $user->setIsVerified(true);
        $entityManager->flush();
        $this->addFlash('success', 'Compte vérifié ! Vous pouvez maintenant vous connecter.');

        return $this->redirectToRoute('app_login');
    }
}
