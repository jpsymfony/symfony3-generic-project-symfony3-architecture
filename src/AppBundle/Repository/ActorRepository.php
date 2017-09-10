<?php

namespace AppBundle\Repository;

use Jpsymfony\CoreBundle\Repository\AbstractGenericRepository;
use AppBundle\Repository\Interfaces\ActorRepositoryInterface;

class ActorRepository extends AbstractGenericRepository implements ActorRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getResultFilterCount($motcle)
    {
        $qb = $this->getQueryResultFilter($motcle);
        $qb->select('COUNT(a.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterPaginated($motcle, $limit = 20, $offset = 0)
    {
        $limit = (int) $limit;
        if ($limit <= 0) {
            throw new \LogicException('$limit must be greater than 0.');
        }

        $qb = $this->getQueryResultFilter($motcle);

        $qb->orderBy('a.lastName', 'ASC');

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function getQueryResultFilter($motcle)
    {
        $qb = $this->getBuilder('a');
        $qb
            ->where("a.firstName LIKE :motcle OR a.lastName LIKE :motcle")
            ->setParameter('motcle', '%' . $motcle . '%');

        return $qb;
    }
}
