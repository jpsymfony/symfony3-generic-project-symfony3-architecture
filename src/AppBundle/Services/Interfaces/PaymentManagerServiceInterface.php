<?php

namespace AppBundle\Services\Interfaces;

use AppBundle\Services\GenericPaymentServiceInterface;
use AppBundle\Services\PaymentContainerService;

interface PaymentManagerServiceInterface
{

    /**
     * @param $paymentClassLabel
     * @return GenericPaymentServiceInterface $paymentService
     * @throws \Exception
     */
    public function getPaymentClass($paymentClassLabel);

    /**
     * @param PaymentContainerService $paymentContainerService
     */
    public function setPaymentContainerService(PaymentContainerService $paymentContainerService);
}