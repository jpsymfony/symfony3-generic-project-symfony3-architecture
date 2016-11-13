<?php
namespace AppBundle\Entity\Manager\Interfaces;

use Jpsymfony\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use AppBundle\Entity\Movie;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

interface MovieManagerInterface extends GenericManagerInterface
{
    /**
     * @param int $limit
     * @param int $offset
     * @return array of movies
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param Movie $movie
     * @return FormInterface
     */
    public function getMovieSearchForm(Movie $movie);

    /**
     * @param string $searchFormType
     * @return MovieManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return MovieManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return MovieManagerInterface
     */
    public function setRouter($router);
}
