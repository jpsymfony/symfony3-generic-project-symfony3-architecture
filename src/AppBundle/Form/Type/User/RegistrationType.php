<?php

namespace AppBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, array('label' => 'user.registration.username'));
        $builder->add('email', EmailType::class);
        $builder->add('password', RepeatedType::class, array(
            'first_name'  => 'password',
            'second_name' => 'confirm',
            'type'        => PasswordType::class,
            'first_options'  => array('label' => 'user.registration.password'),
            'second_options' => array('label' => 'user.registration.confirm'),
        ));
        $builder->add('Register', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'user.registration.register'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Registration\Registration',
        ]);
    }
} 
