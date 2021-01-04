<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => false, 'attr' => ['placeholder' => 'Votre Pseudonyme']])
            ->add('email', null, ['label' => false, 'attr' => ['placeholder' => 'Votre Email']])
            ->add('password', PasswordType::class, ['label' => false, 'attr' => ['placeholder' => 'Votre Mot de passe']])
            ->add('demo_data', CheckboxType::class, ['mapped' => false, 'label' => 'Ajouter un jeu d\'exemple de données', 'required' => false])
            ->add('save', SubmitType::class, ['label' => 'Créer mon compte', 'attr' => ['class' => 'btn btn-primary btn-block']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
