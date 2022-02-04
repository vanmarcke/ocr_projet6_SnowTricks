<?php

namespace App\Security;

use App\Entity\SnowUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * Checks the user account before authentication.
     *
     * @throws AccountStatusException
     */
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof SnowUser || ($user instanceof SnowUser && $user->isVerified())) {
            return;
        }

        throw new CustomUserMessageAccountStatusException('Compte non activé. Vérifiez vos mails pour valider votre inscription !');
    }

    /**
     * Checks the user account after authentication.
     *
     * @throws AccountStatusException
     */
    public function checkPostAuth(UserInterface $user)
    {
        return;
    }
}
