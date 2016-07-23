<?php

namespace App\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\UserBundle\Entity\Password\ChangePassword;
use App\UserBundle\Entity\Manager\UserManagerInterface;

class ChangePasswordType extends AbstractType
{
    /**
     *
     * @var UserManagerInterface $handler
     */
    private $handler;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->handler = $userManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, ['required' => false, 'label' => 'user.change_password.old_password' ])
            ->add('newPassword', RepeatedType::class, [
                'required' => false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'user.change_password.new_password',
                ],
                'second_options' => [
                    'label' => 'user.change_password.repeat_new_password',
                ]
            ])
        ;

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();
                if (!$data instanceof ChangePassword) {
                    throw new \RuntimeException('ChangePassword instance required.');
                }

                $oldPassword = $data->getOldPassword();
                $newPassword = $data->getNewPassword();
                $form = $event->getForm();
                if (!$oldPassword || !$newPassword || count($form->getErrors(true))) {
                    return;
                }
    
                $user = $data->getUser();
    
                if (!$this->handler->isPasswordValid($user, $oldPassword)) {
                    $form = $event->getForm();
                    $form->get('oldPassword')->addError(new FormError('Previous password is not valid.'));
                    return;
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\UserBundle\Entity\Password\ChangePassword',
        ]);
    }


    public function getName()
    {
        return 'change_password_form';
    }
}
