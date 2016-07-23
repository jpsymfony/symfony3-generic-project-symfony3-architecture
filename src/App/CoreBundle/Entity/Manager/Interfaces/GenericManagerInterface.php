<?php

namespace App\CoreBundle\Entity\Manager\Interfaces;

interface GenericManagerInterface
{
    /**
     * Count all fields existed from the given entity
     *
     * @param boolean $enabled [0, 1]
     *
     * @return int the count of all fields.
     * @access public
     */
    public function count($enabled = false);

    /**
     * @param $entity
     */
    public function remove($entity);

    /**
     * @param string $result
     * @param null $maxResults
     * @param string $orderby
     * @param string $dir
     * @return array
     */
    public function all($result = "object", $maxResults = null, $orderby = '', $dir = 'ASC');

    /**
     * @param $entity
     * @return null|object
     */
    public function find($entity);

    /**
     * @param $entity
     * @param bool $persist
     * @param bool $flush
     * @return mixed
     */
    public function save($entity, $persist = false, $flush = true);

    /**
     * @param $labelClass
     * @return GenericManagerInterface
     */
    public function isTypeMatch($labelClass);

    /**
     * @return string LabelClass
     */
    public function getLabel();
}