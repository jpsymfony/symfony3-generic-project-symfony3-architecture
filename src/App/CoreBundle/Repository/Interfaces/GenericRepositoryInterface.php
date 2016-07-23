<?php
namespace App\CoreBundle\Repository\Interfaces;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface GenericRepositoryInterface
{
    /**
     * @param string $alias
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getBuilder($alias = 'u');
    
    /**
     * @param $entity
     * @param bool $persist
     * @param bool $flush
     */
    public function save($entity, $persist = false, $flush = true);

    /**
     * @return string
     */
    public function getClassName();

    /**
     * @return string alias of className
     */
    public function getAlias();

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
    public function find($entity);

    /**
     * @param $entity
     */
    public function remove($entity);

    /**
     * Find all translations by an entity.
     *
     * @param string $result = {'array', 'object'}
     * @param int    $maxResults
     * @param string $orderby
     * @param string $dir
     *
     * @return array|object
     * @access public
     */
    public function findAllByEntity($result = "object", $maxResults = null, $orderby = '', $dir = 'ASC');

    /**
     * Loads all translations with all translatable fields from the given entity
     *
     * @param Query   $query
     * @param string  $result = {'array', 'object'}
     *
     * @return array|object of result query
     * @access public
     */
    public function findByQuery(Query $query, $result = "array");
}