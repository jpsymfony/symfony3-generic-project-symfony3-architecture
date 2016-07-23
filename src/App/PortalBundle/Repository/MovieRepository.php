<?php

namespace App\PortalBundle\Repository;

use App\CoreBundle\Form\DataTransformer\DatedmYToDateYmdViewTransformer;
use App\CoreBundle\Repository\AbstractGenericRepository;
use App\PortalBundle\Entity\Movie;
use App\PortalBundle\Repository\Interfaces\MovieRepositoryInterface;

class MovieRepository extends AbstractGenericRepository implements MovieRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getResultFilterCount($requestVal)
    {
        $qb = $this->getQueryResultFilter($requestVal);
        $qb->select('COUNT(f.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0)
    {
        $qb = $this->getQueryResultFilter($requestVal);

        $qb->orderBy('f.title', 'ASC');

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function getQueryResultFilter($requestVal)
    {
        $qb = $this->getBuilder('f');

        if (!empty($requestVal)) {
            $isReleaseDateFrom = !empty($requestVal['releaseDateFrom']);
            $isReleaseDateTo = !empty($requestVal['releaseDateTo']);

            $viewTransformer = new DatedmYToDateYmdViewTransformer();
            $releaseDateFrom = $viewTransformer->reverseTransform($requestVal['releaseDateFrom']);
            $releaseDateTo = $viewTransformer->reverseTransform($requestVal['releaseDateTo']);

            foreach ($requestVal as $key => $val) {
                if (!empty($requestVal[$key])) {
                    // title, description
                    if (in_array($key, Movie::getLikeFieds())) {
                        $qb->andWhere(sprintf('f.%s LIKE :%s', $key, $key))
                            ->setParameter($key, "%" . $val . "%");
                    }

                    // hashTags, actors
                    if (in_array($key, Movie::getCollectionFields())) {
                        $alias = substr($key, 0, 3);
                        $qb->leftJoin(sprintf('f.%s', $key), $alias);
                        $qb->andWhere(sprintf($alias . '.id IN (:%s)', $key))
                            ->setParameter($key, $val);
                    }

                    // category
                    if (in_array($key, Movie::getObjectFields())) {
                        $qb->andWhere(sprintf('f.%s = :%s', $key, $key))
                            ->setParameter($key, $val);
                    }
                }
            }

            if ($isReleaseDateFrom && $isReleaseDateTo) {
                $qb->andWhere('DATE(f.releasedAt) >= :releaseDateFrom')
                    ->setParameter('releaseDateFrom', $releaseDateFrom);
                $qb->andWhere('DATE(f.releasedAt) <= :releaseDateTo')
                    ->setParameter('releaseDateTo', $releaseDateTo);
            } elseif ($isReleaseDateFrom && !$isReleaseDateTo) {
                $qb->andWhere('DATE(f.releasedAt) >= :releaseDateFrom')
                    ->setParameter('releaseDateFrom', $releaseDateFrom);
            } elseif (!$isReleaseDateFrom && $isReleaseDateTo) {
                $qb->andWhere('DATE(f.releasedAt) <= :releaseDateTo')
                    ->setParameter('releaseDateTo', $releaseDateTo);
            }
        }

        return $qb;
    }
}
