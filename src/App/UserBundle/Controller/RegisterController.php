<?php

namespace App\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\UserBundle\Form\Type\RegistrationType;
use App\UserBundle\Entity\Registration\Registration;

/**
 * Controller used to manage the application security.
 * See http://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class RegisterController extends Controller
{

    /**
     * @Route("/register", name="security_register_form")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(RegistrationType::class, new Registration());

        if ($this->getRegistrationFormHandler()->handle($form, $request)) {
            $this->addFlash('success', 'Your account has been created. An email has been sent to you.');
            return $this->redirectToRoute('security_login_form');
        }

        return $this->render('security/register.html.twig', [
                'form' => $form->createView(),
        ]);
    }

    /**
     * @return \App\CoreBundle\Form\Handler\FormHandlerInterface
     */
    protected function getRegistrationFormHandler()
    {
        return $this->get('app_user.registration.handler');
    }
}