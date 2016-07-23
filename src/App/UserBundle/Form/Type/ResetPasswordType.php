<?php

namespace App\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\UserBundle\Entity\Password\ResetPassword;
use App\UserBundle\Entity\Manager\UserManagerInterface;

class ResetPasswordType extends AbstractType
{
    /**
     *
     * @var UserManagerInterface $handler
     */
    private $handler;

    /**
     *
     * @var RequestStack $request
     */
    private $request;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager, RequestStack $request)
    {
        $this->handler = $userManager;
        $this->request = $request;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', RepeatedType::class, array(
            'first_name'  => 'password',
            'second_name' => 'confirm',
            'type'        => PasswordType::class,
            'first_options' => [
                'label' => 'user.reset_password.new_password',
            ],
            'second_options' => [
                'label' => 'user.reset_password.repeat_new_password',
            ]
        ));
        $builder->add('Reset Password', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'user.reset_password.button'
        ));

        $builder->addEventListener(
        FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                if (!$data instanceof ResetPassword) {
                    throw new \RuntimeException('ResetPassword instance required.');
                }
                $token = $this->request->getCurrentRequest()->get('token');

                if (!$token) {
                   throw new \Exception('Incorrect Token.');
                }

                $user = $this->handler->getUserByConfirmationToken($token);

                if (!$user) {
                   throw new \Exception('User not identified in our database with this token.');
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\UserBundle\Entity\Password\ResetPassword',
        ]);
    }

    public function getName()
    {
        return 'reset_password_form';
    }
} 
