<?php

namespace App\UserBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use App\CoreBundle\Form\Handler\FormHandlerInterface;
use App\UserBundle\Entity\Manager\UserManagerInterface;

class ResetPasswordFormHandler implements FormHandlerInterface
{
    /**
     *
     * @var UserManagerInterface
     */
    private $handler;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->handler = $userManager;
    }

    /**
     * @param FormInterface $form
     * @param Request       $request
     * @param array         $options
     *
     * @return bool
     */
    public function handle(FormInterface $form, Request $request, array $options = null)
    {
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return false;
        }

        $token = $request->query->get('token');
        $user = $this->handler->getUserByConfirmationToken($token);
        
        $this->handler->clearConfirmationTokenUser($user);
        $this->handler->updateCredentials($user, $form->getData()->getPassword());

        return true;
    }
}