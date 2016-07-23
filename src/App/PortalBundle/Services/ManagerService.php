<?php

namespace App\PortalBundle\Services;

use App\PortalBundle\Services\Interfaces\ManagerServiceInterface;

class ManagerService implements ManagerServiceInterface
{
    /**
     * @var ManagerContainerService
     */
    private $managerContainerService;

    /**
     * @inheritdoc
     */
    public function getManagerClass($managerClassLabel)
    {
        foreach ($this->managerContainerService->getManagers() as $manager)
        {
            if ($manager->isTypeMatch($managerClassLabel)) {
                return $manager;
            }
        }

        throw new \Exception('None manager service found for class ' . $managerClassLabel);
    }

    /**
     * @inheritdoc
     */
    public function setManagerContainerService(ManagerContainerService $managerContainerService)
    {
        $this->managerContainerService = $managerContainerService;
    }
}