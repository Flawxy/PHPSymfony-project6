<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\CreateNewPasswordType;
use App\Form\MailType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Service\MailManagerService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Displays the register form
     *
     * @Route("/register", name="account_register")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param MailManagerService $mailManagerService
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, MailManagerService $mailManagerService, MailerInterface $mailer)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $manager->flush();

            $mailManagerService->sendValidationMail($user, $mailer);

            $this->addFlash(
                'success',
                "Un mail de confirmation a été envoyé à <strong>{$user->getMail()}</strong> afin de valider votre inscription !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Displays the connecting form
     *
     * @Route("/login", name="account_login")
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Allows the user to disconnect
     *
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout()
    {
        // Managed by Symfony
    }

    /**
     * Allows the user to change his password
     *
     * @Route("/account/update-password", name="account_update_password")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!$encoder->isPasswordValid($user, $passwordUpdate->getOldPassword())) {
                $form->get('oldPassword')->addError(new FormError("Le mot de passe renseigné est incorrect !"));
            }else {

                $newPassword = $passwordUpdate->getNewPassword();
                $hashedPassword = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($hashedPassword);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié !"
                );

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('/account/updatePassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Allows an user to validate his email
     *
     * @Route("/account/validation/{confirmationToken}", name="account_validation")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function validateMail(User $user, EntityManagerInterface $manager)
    {
        $user->setConfirmationToken(null);

        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "Votre adresse mail <strong>{$user->getMail()}</strong> a été validée ! Vous pouvez maintenant vous connecter !"
        );

        return $this->redirectToRoute('account_login');

    }

    /**
     * Allows the user to reset his password
     *
     * @Route("/account/reset-password", name="account_reset_password")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param MailManagerService $mailManagerService
     * @param MailerInterface $mailer
     * @param UserRepository $userRepository
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function resetPassword(Request $request, EntityManagerInterface $manager, MailManagerService $mailManagerService, MailerInterface $mailer, UserRepository $userRepository)
    {
        $form = $this->createForm(MailType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailManagerService->sendPasswordResetMail($form['mail']->getData(), $mailer, $userRepository, $manager);

            $this->addFlash(
                'success',
                "S'il existe un compte associé à cette adresse, un mail vous sera envoyé sous peu !"
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('account/resetPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Allows an user to choose a new password when he forgot the previous one
     *
     * @Route("/account/reset-password/{resetToken}", name="account_create_new_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $manager
     * @param User $user
     * @return Response
     */
    public function createNewPassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager, User $user)
    {
        $form = $this->createForm(CreateNewPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $user->setResetToken(null);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre mot de passe a bien été mis à jour !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/createNewPassword.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
