<?php

namespace App\PortalBundle\Controller;

use App\PortalBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use App\PortalBundle\Entity\Contact;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $form = $this->get('form.factory')->create(ContactType::class, new Contact());

        if ($this->getRequestContactFormHandler()->handle($form, $request)) {
            $this->addFlash('success', 'Merci pour votre message.');
            return $this->redirect($this->generateUrl('contact'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @return \App\CoreBundle\Form\Handler\FormHandlerInterface
     */
    protected function getRequestContactFormHandler()
    {
        return $this->get('app_portal.request_contact.handler');
    }
}
