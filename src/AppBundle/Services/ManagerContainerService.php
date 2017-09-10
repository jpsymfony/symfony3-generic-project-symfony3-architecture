<?php

namespace AppBundle\Services;

use AppBundle\Entity\Manager\Interfaces\ManagerInterface;

class ManagerContainerService
{
    /**
     * @var ManagerInterface[]
     */
    private $managers;

    public function __construct()
    {
        $this->managers = [];
    }

    /**
     * @param ManagerInterface $manager
     */
    public function addManager(ManagerInterface $manager)
    {
        array_push($this->managers, $manager);
    }

    /**
     * @return ManagerInterface[]
     */
    public function getManagers()
    {
        return $this->managers;
    }

}