<?php

namespace AppBundle\Services;

use AppBundle\Entity\Manager\Interfaces\ManagerInterface;

class ManagerContainerService
{
    private $managers;

    public function __construct()
    {
        $this->managers = array();
    }

    public function addManager(ManagerInterface $manager)
    {
        array_push($this->managers, $manager);
    }

    public function getManagers()
    {
        return $this->managers;
    }

}