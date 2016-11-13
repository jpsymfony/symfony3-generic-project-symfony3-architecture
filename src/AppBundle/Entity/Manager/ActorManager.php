<?php
namespace AppBundle\Entity\Manager;

use Jpsymfony\CoreBundle\Entity\Manager\AbstractGenericManager;
use Jpsymfony\CoreBundle\Repository\AbstractGenericRepository;
use AppBundle\Entity\Manager\Interfaces\ActorManagerInterface;
use AppBundle\Entity\Manager\Interfaces\ManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\RouterInterface;

class ActorManager extends AbstractGenericManager implements ActorManagerInterface, ManagerInterface
{
    /**
     * @var FormTypeInterface
     */
    protected $searchFormType;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @inheritdoc
     */
    public function __construct(AbstractGenericRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterPaginated($motcle ='', $limit = 20, $offset = 0)
    {
        return $this->repository->getResultFilterPaginated($motcle, $limit, $offset);
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterCount($requestVal)
    {
        return $this->repository->getResultFilterCount($requestVal);
    }

    /**
     * @inheritdoc
     */
    public function getActorSearchForm()
    {
        return $this->formFactory->create(
            $this->searchFormType,
            null,
            [
                'action' => $this->router->generate('actors_list'),
                'method' => 'POST',
                'attr' => ['id' => 'form_recherche']
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function setSearchFormType($searchFormType)
    {
        $this->searchFormType = $searchFormType;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'actorManager';
    }
}
