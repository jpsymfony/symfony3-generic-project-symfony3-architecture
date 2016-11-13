<?php
namespace AppBundle\Entity\Manager;

use Jpsymfony\CoreBundle\Entity\Manager\AbstractGenericManager;
use Jpsymfony\CoreBundle\Repository\AbstractGenericRepository;
use AppBundle\Entity\Manager\Interfaces\CategoryManagerInterface;
use AppBundle\Entity\Manager\Interfaces\ManagerInterface;

class CategoryManager extends AbstractGenericManager implements CategoryManagerInterface, ManagerInterface
{
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
    public function getLabel()
    {
        return 'categoryManager';
    }
}
