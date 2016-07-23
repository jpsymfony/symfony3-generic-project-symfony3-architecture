<?php

namespace App\UserBundle\Repository;

use App\CoreBundle\Repository\AbstractGenericRepository;
use App\UserBundle\Repository\Interfaces\UserRepositoryInterface;
use Doctrine\ORM\QueryBuilder;

class UserRepository extends AbstractGenericRepository implements UserRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getUserByIdentifierQueryBuilder(QueryBuilder &$qb, $identifier)
    {
        $qb->andWhere(
            $qb->expr()->orX(
                'u.username = :identifier', 'u.email = :identifier'
            )
        )
            ->setParameter('identifier', $identifier);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUserByEmailOrUsername($identifier)
    {
        $qb = $this->getBuilder();
        $this->getUserByIdentifierQueryBuilder($qb, $identifier);

        return $qb->getQuery()->getOneOrNullResult();
    }
}