<?php

namespace AppBundle\Repository\Interfaces;

interface MovieRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of movies
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);
}
