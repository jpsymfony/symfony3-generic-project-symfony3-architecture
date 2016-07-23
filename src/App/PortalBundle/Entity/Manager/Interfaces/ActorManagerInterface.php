<?php
namespace App\PortalBundle\Entity\Manager\Interfaces;

use App\CoreBundle\Entity\Manager\Interfaces\GenericManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\RouterInterface;

interface ActorManagerInterface extends GenericManagerInterface
{
    /**
     * @param int $limit
     * @param int $offset
     * @return array of actors
     */
    public function getResultFilterPaginated($limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @return FormInterface
     */
    public function getActorSearchForm();

    /**
     * @param string $searchFormType
     * @return ActorManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return ActorManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return ActorManagerInterface
     */
    public function setRouter($router);
}
