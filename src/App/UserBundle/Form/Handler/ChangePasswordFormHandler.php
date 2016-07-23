<?php

namespace App\UserBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use App\CoreBundle\Form\Handler\FormHandlerInterface;
use App\UserBundle\Entity\Manager\UserManagerInterface;

class ChangePasswordFormHandler implements FormHandlerInterface
{
    /**
     *
     * @var UserManagerInterface $manager
     */
    private $manager;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->manager = $userManager;
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

        $this->manager->updateCredentials($form->getData()->getUser(), $form->getData()->getNewPassword());

        return true;
    }
}