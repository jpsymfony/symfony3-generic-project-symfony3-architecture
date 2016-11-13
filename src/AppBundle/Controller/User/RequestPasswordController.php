<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\User\RequestPasswordType;
use AppBundle\Entity\Password\RequestPassword;

/**
 * @Route("/")
 */
class RequestPasswordController extends Controller
{
    /**
     * @param Request $request
     * @Route("/request-password", name="request_password")
     * @Method("GET|POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function requestPasswordAction(Request $request)
    {
        $form = $this->createForm(RequestPasswordType::class, new RequestPassword());

        if ($this->getRequestPasswordFormHandler()->handle($form, $request)) {
            $this->addFlash('success', 'A mail has been sent to your mailbox to reset your password.');
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('user/request-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return \Jpsymfony\CoreBundle\Form\Handler\FormHandlerInterface
     */
    protected function getRequestPasswordFormHandler()
    {
        return $this->get('app.user_request_password.handler');
    }
}
