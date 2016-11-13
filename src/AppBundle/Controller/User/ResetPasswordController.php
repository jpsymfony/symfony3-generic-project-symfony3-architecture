<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\User\ResetPasswordType;
use AppBundle\Entity\Password\ResetPassword;

/**
 * @Route("/")
 */
class ResetPasswordController extends Controller
{
    /**
     * @param Request $request
     * @Route("/reset-password", name="reset_password")
     * @Method("GET|POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function requestPasswordAction(Request $request)
    {
        try {
            $form = $this->createForm(ResetPasswordType::class, new ResetPassword());

            if ($this->getResetPasswordFormHandler()->handle($form, $request)) {
                $this->addFlash('success', 'Your password has been resetted. You can login now.');
                return $this->redirect($this->generateUrl('homepage'));
            }

            return $this->render('user/reset-password.html.twig',
                    [
                    'form' => $form->createView(),
            ]);
        } catch (\Exception $ex) {
            $this->addFlash('error', $ex->getMessage());
            return $this->redirect($this->generateUrl('security_login_form'));
        }
    }

    /**
     * @return \Jpsymfony\CoreBundle\Form\Handler\FormHandlerInterface
     */
    protected function getResetPasswordFormHandler()
    {
        return $this->get('app.user_reset_password.handler');
    }
}