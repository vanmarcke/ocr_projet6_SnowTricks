<?php

namespace App\Manager;

use App\Entity\SnowUser;
use App\Repository\SnowUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileManager implements ProfileManagerInterface
{
    public function __construct(string $imageDirAvatar, string $avatarAbsoluteDir, private SnowUserRepository $user, private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->imageDirAvatar = $imageDirAvatar;
        $this->avatarAbsoluteDir = $avatarAbsoluteDir;
    }

    /**
     * {@inheritdoc}
     */
    public function uploadProfile(FormInterface $form, SnowUser $user, UserPasswordHasherInterface $userPasswordHasher): void
    {
        $password = $form->get('passwordold')->getData();

        if ($userPasswordHasher->isPasswordValid($user, $password)) {
            $new_avatar = $form->get('newavatar')->getData();
            $new_pseudo = $form->get('newpseudo')->getData();
            $new_password = $form->get('newpassword')->getData();

            if (!empty($new_password)) {
                $password = $userPasswordHasher->hashPassword($user, $new_password);
                $user->setPassword($password);
            }

            if (!empty($new_pseudo)) {
                $user->setUsername($new_pseudo);
            }

            if (!empty($new_avatar)) {
                $nameavatar = random_int(1, 999) . '-' . 'SnowAvatar' . '-' . $new_avatar->getClientOriginalName();
                $nameavatar = str_replace(' ', '_', $nameavatar);
                $new_avatar->move($this->avatarAbsoluteDir, $nameavatar);

                $user->setAvatar(sprintf('%s/%s', $this->imageDirAvatar, $nameavatar));
            }

            if (!empty($new_password) || !empty($new_pseudo) || !empty($new_avatar)) {

                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
        } 
    }
}
