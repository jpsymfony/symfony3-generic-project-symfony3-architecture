<?php

namespace App\PortalBundle\Services\Interfaces;

use App\PortalBundle\Services\GenericPaymentServiceInterface;
use App\PortalBundle\Services\ManagerContainerService;
use App\PortalBundle\Services\PaymentContainerService;

interface ManagerServiceInterface
{
    /**
     * @param $paymentClassLabel
     * @return GenericPaymentServiceInterface $paymentService
     * @throws \Exception
     */
    public function getManagerClass($paymentClassLabel);

    /**
     * @param ManagerContainerService $managerContainerService
     */
    public function setManagerContainerService(ManagerContainerService $managerContainerService);
}