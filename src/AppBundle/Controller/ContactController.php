<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ContactType;
use AppBundle\Entity\Contact;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     * @Template("contact/index.html.twig")
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
     * @return \Jpsymfony\CoreBundle\Form\Handler\FormHandlerInterface
     */
    protected function getRequestContactFormHandler()
    {
        return $this->get('app.request_contact.handler');
    }
}
