<?php

namespace AppBundle\Services;

use AppBundle\Services\Interfaces\ManagerServiceInterface;

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

        throw new \Exception(sprintf('None manager service found for class %s', $managerClassLabel));
    }

    /**
     * @inheritdoc
     */
    public function setManagerContainerService(ManagerContainerService $managerContainerService)
    {
        $this->managerContainerService = $managerContainerService;
    }
}