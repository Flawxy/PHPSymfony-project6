<?php
namespace App\Security;

use App\Security\AccountDisabledException;
use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // The user didn't validate his mail yet
        if ($user->getConfirmationToken() !== null) {
            throw new AccountDisabledException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {

    }
}