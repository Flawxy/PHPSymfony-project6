<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CoverImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coverImage', FileType::class, [
                'label' => 'Image de couverture',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/gif',
                            'image/svg'
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner un fichier image valide'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
