<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PaymentController extends Controller
{
    /**
     * @Route("/payment", name="app_payment")
     * @Template("payment/form.html.twig")
     */
    public function indexAction()
    {
        $values = array(
            'client_id' => 1,
            'order_id' => 'REF1234567',
            'amount' => 5.0,
            'description' => 'my description',
        );

        return array(
            'values' => $values,
            'displaySubmitBtn' => false,
            'message' => 'payment',
            'createAlias' => true,
        );
    }
}
