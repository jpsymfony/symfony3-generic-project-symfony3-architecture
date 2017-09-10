<?php

namespace AppBundle\Services;

class PaymentContainerService
{
    private $paymentServices;

    public function __construct()
    {
        $this->paymentServices = array();
    }

    /**
     * @param GenericPaymentServiceInterface $paymentService
     */
    public function addPaymentService(GenericPaymentServiceInterface $paymentService)
    {
        $this->paymentServices[] = $paymentService;
    }

    /**
     * @return GenericPaymentServiceInterface[]
     */
    public function getPaymentServices()
    {
        return $this->paymentServices;
    }
}