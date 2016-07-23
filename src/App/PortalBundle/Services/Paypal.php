<?php

namespace App\PortalBundle\Services;

class Paypal extends AbstractPaymentService
{
    public function getHtml($url, $parameters, $displaySubmitBtn, $message)
    {
        return 'PaypalServiceForm';
    }

    /**
     * @inheritdoc
     */
    public function addFail()
    {
        // send mail and log error
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'Paypal';
    }
}