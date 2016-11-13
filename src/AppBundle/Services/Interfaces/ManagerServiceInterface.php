<?php

namespace AppBundle\Services\Interfaces;

use AppBundle\Services\GenericPaymentServiceInterface;
use AppBundle\Services\ManagerContainerService;

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