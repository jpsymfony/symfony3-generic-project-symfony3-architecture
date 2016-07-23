<?php
namespace App\PortalBundle\Form\Handler\Contact;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use App\CoreBundle\Form\Handler\FormHandlerInterface;
use App\PortalBundle\Entity\Manager\Interfaces\ContactManagerInterface;

class ContactFormHandler implements FormHandlerInterface
{
    /**
     *
     * @var ContactManagerInterface
     */
    private $manager;

    /**
     * @param ContactManagerInterface $contactManager
     */
    public function __construct(ContactManagerInterface $contactManager)
    {
        $this->manager = $contactManager;
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

        $this->manager->sendMail($form->getData());

        return true;
    }
}