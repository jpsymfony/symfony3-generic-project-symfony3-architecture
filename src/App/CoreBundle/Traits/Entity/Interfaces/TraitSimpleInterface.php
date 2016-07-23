<?php

namespace App\CoreBundle\Traits\Entity\Interfaces;

interface TraitSimpleInterface
{
    /**
     * Set id
     *
     * @return integer
     */
    public function setId($id);

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();
    
    /**
     * Set archived
     *
     * @param boolean $archived
     */
    public function setArchived($archived);
    
    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived();
}
