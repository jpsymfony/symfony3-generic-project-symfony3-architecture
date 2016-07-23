<?php

namespace App\PortalBundle\Services\Interfaces;

use App\PortalBundle\Services\GenericPaymentServiceInterface;
use App\PortalBundle\Services\PaymentContainerService;

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