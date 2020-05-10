<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class MailManagerService extends AbstractController
{
    public function sendValidationMail(User $user, MailerInterface $mailer)
    {
        $email = (new TemplatedEmail())
            ->from('flawxy.snowtricks@gmail.com')
            ->to($user->getMail())
            ->subject('Confirmation de votre inscription')
            ->htmlTemplate('emails/registration.html.twig')
            ->context([
                'user' => $user
            ])
        ;

        $mailer->send($email);
    }
}