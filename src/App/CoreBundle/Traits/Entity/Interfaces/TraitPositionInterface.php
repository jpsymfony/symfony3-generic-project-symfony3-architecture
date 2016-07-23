<?php

namespace App\CoreBundle\Traits\Entity\Interfaces;

interface TraitPositionInterface
{
    /**
     * Set $position
     *
     * @param integer $position
     */
    public function setPosition($position);
    
    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition();
}
