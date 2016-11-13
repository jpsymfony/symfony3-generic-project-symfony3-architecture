<?php

namespace AppBundle\Form\Handler\User;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Jpsymfony\CoreBundle\Form\Handler\FormHandlerInterface;
use AppBundle\Entity\Manager\Interfaces\UserManagerInterface;

class RegistrationFormHandler implements FormHandlerInterface
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

        $this->handler->createUser($form->getData()->getUser());

        return true;
    }
} 
