<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/account")
 */
class UserController extends Controller
{
    /**
     * @Route("/dashboard", name="user_dashboard")
     * @Method("GET|POST")
     */
    public function dashboardAction()
    {
        return $this->render('user/dashboard.html.twig');
    }

    /**
     * @Route("/sales-conditions", name="sales_conditions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function salesConditionAction()
    {
        return $this->render('/user/sales-conditions.html.twig');
    }
}
