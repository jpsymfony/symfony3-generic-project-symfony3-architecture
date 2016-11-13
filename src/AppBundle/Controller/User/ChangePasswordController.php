<?php

namespace AppBundle\Controller\User;

use AppBundle\Form\Type\User\ChangePasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Password\ChangePassword;

/**
 * @Route("/account")
 */
class ChangePasswordController extends Controller
{
    /**
     * @param Request $request
     * @Route("/change-password", name="change_password")
     * @Method("GET|POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordAction(Request $request)
    {
        $data = new ChangePassword($this->getUser());
        $form = $this->createForm(ChangePasswordType::class, $data);

        if ($this->getChangePasswordFormHandler()->handle($form, $request)) {
            $this->addFlash('success', 'The password has been changed successfully.');
            return $this->redirect($this->generateUrl('user_dashboard'));
        }

        return $this->render('user/change-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return \Jpsymfony\CoreBundle\Form\Handler\FormHandlerInterface
     */
    protected function getChangePasswordFormHandler()
    {
        return $this->get('app.user_change_password.handler');
    }
}
