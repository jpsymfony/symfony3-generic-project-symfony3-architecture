<?php

namespace AppBundle\Services\Interfaces;

use AppBundle\Services\GenericPaymentServiceInterface;
use AppBundle\Services\ManagerContainerService;

interface ManagerServiceInterface
{
    /**
     * @param $managerClassLabel
     * @return ManagerServiceInterface $managerService
     * @throws \Exception
     */
    public function getManagerClass($managerClassLabel);

    /**
     * @param ManagerContainerService $managerContainerService
     */
    public function setManagerContainerService(ManagerContainerService $managerContainerService);
}