<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class MailManagerService extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param User $user
     * @param MailerInterface $mailer
     * @throws TransportExceptionInterface
     */
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

    /**
     * @param string $mail
     * @param MailerInterface $mailer
     * @param UserRepository $userRepository
     * @throws TransportExceptionInterface
     */
    public function sendPasswordResetMail(string $mail, MailerInterface $mailer, UserRepository $userRepository)
    {
        /** @var User $user */
        $user = $userRepository->findOneByMail($mail);
        if ($user) {

            $user->createResetPasswordToken();

            $this->manager->persist($user);
            $this->manager->flush();

            $email = (new TemplatedEmail())
                ->from('flawxy.snowtricks@gmail.com')
                ->to($user->getMail())
                ->subject('Demande de reset de mot de passe')
                ->htmlTemplate('emails/reset.html.twig')
                ->context([
                    'user' => $user
                ])
            ;

            $mailer->send($email);
        }
    }
}
