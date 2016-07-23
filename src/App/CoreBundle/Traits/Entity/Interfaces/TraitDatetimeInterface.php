<?php

namespace App\CoreBundle\Traits\Entity\Interfaces;

interface TraitDatetimeInterface
{
    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt);
    
    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt);
    
    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt();
    
    /**
     * Set published_at
     *
     * @param \DateTime $publishedAt
     */
    public function setPublishedAt($publishedAt);
    
    /**
     * Get published_at
     *
     * @return \DateTime
     */
    public function getPublishedAt();
    
    /**
     * Set archive_at
     *
     * @param \DateTime $archiveAt
     */
    public function setArchiveAt($archiveAt);
    
    /**
     * Get archive_at
     *
     * @return \DateTime
     */
    public function getArchiveAt();
}
