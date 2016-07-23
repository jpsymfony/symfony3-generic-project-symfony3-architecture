<?php

namespace App\PortalBundle\Entity\Manager\Interfaces;

interface ManagerInterface
{
    /**
     * @param $labelClass
     * @return ManagerInterface
     */
    public function isTypeMatch($labelClass);

    /**
     * @return string LabelClass
     */
    public function getLabel();
}