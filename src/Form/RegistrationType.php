<?php

namespace App\Form;

use App\Entity\User;
<<<<<<< Updated upstream
use Symfony\Component\Form\AbstractType;
=======
>>>>>>> Stashed changes
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname', TextType::class,
<<<<<<< Updated upstream
                $this->getConfiguration('Pseudo', 'Votre pseudonyme...'))
            ->add('mail', EmailType::class,
                $this->getConfiguration('Email', 'Votre adresse email...'))
            ->add('password', PasswordType::class,
                $this->getConfiguration('Mot de passe', 'Votre mot de passe...'))
=======
                $this->getConfiguration("Pseudo", "Votre pseudonyme..."))
            ->add('mail', EmailType::class,
                $this->getConfiguration("Email", "Votre adresse email..."))
            ->add('password', PasswordType::class,
                $this->getConfiguration("Mot de passe", "Votre mot de passe..."))
            ->add('passwordConfirmation', PasswordType::class,
                $this->getConfiguration("Confirmation du mot de passe", "Veuillez confirmer votre mot de passe..."))
>>>>>>> Stashed changes
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
