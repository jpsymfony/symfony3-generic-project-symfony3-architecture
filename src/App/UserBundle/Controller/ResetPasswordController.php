<?php

namespace App\UserBundle\Controller;

use App\UserBundle\Form\Type\ResetPasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\UserBundle\Entity\Password\ResetPassword;

/**
 * @Route("/")
 */
class ResetPasswordController extends Controller
{

    /**
     * @Route("/reset-password", name="reset_password")
     * @Method("GET|POST")
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
     * @return \App\CoreBundle\Form\Handler\FormHandlerInterface
     */
    protected function getResetPasswordFormHandler()
    {
        return $this->get('app_user.reset_password.handler');
    }
}