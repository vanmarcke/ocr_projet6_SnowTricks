<?php

namespace App\Manager;

use App\Entity\SnowUser;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

interface ProfileManagerInterface
{
    /**
     * Method uploadProfile.
     *
     * @param FormInterface               $form               contains Form information
     * @param SnowUser                    $user               contains user information
     * @param UserPasswordHasherInterface $userPasswordHasher contains PasswordHasher
     */
    public function uploadProfile(FormInterface $form, SnowUser $user, UserPasswordHasherInterface $userPasswordHasher): void;

    /**
     * Method inscriptionUser.
     *
     * @param FormInterface $form contains Form information
     * @param SnowUser      $user contains user information
     */
    public function createAvatar(FormInterface $form, SnowUser $user): void;
}
