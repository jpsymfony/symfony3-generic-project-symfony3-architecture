<?php

namespace App\CoreBundle\Entity\Manager;

use App\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use App\CoreBundle\Repository\AbstractGenericRepository;

abstract class AbstractGenericManager implements GenericManagerInterface
{
    /**
     * @var AbstractGenericRepository $repository
     */
    protected $repository;

    /**
     * @inheritdoc
     */
    public function __construct(AbstractGenericRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function count($enabled = false) 
    {
        return $this->repository->count($enabled);
    }
    
    /**
     * @inheritdoc
     */
    public function remove($entity)
    {
        $this->repository->remove($entity);
    }

    /**
     * @inheritdoc
     */
    public function all($result = "object", $maxResults = null, $orderby = '', $dir = 'ASC')
    {
        return $this->repository->findAllByEntity($result, $maxResults, $orderby, $dir);
    }

    /**
     * @inheritdoc
     */
    public function find($entity)
    {
        return $this->repository->find($entity);
    }

    /**
     * @inheritdoc
     */
    public function save($entity, $persist = false, $flush = true)
    {
        return $this->repository->save($entity, $persist, $flush);
    }

    /**
     * @inheritdoc
     */
    public function isTypeMatch($labelClass)
    {
        return $labelClass === $this->getLabel();
    }

    /**
     * @inheritdoc
     */
    abstract public function getLabel();

    public function getPagination($request, $page, $route, $maxPerPage, $count = null)
    {
        $pageCount = null === $count ? ceil($this->count() / $maxPerPage) : ceil($count / $maxPerPage);
        return array(
            'page' => $page,
            'route' => $route,
            'pages_count' => $pageCount,
            'route_params' => $request,
        );
    }
}