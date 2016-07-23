<?php

namespace App\PortalBundle\Services;

class PaymentContainerService
{
    private $paymentServices;

    public function __construct()
    {
        $this->paymentServices = array();
    }

    public function addPaymentService(GenericPaymentServiceInterface $paymentService)
    {
        $this->paymentServices[] = $paymentService;
    }

    public function getPaymentServices()
    {
        return $this->paymentServices;
    }
}