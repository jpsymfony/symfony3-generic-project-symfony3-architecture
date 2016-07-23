<?php

namespace App\CoreBundle\Traits\Entity\Interfaces;

interface TraitEnabledInterface
{
    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled);
    
    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled();
}
